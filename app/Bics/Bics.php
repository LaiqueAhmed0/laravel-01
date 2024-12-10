<?php

namespace App\Bics;

use App\Models\Benefit;
use App\Models\Country;
use App\Models\Endpoint;
use App\Models\Plan;
use App\Models\Sim;
use Carbon\Carbon;
use Exception;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Bics
{
    protected ?string $accessToken;

    protected ?string $refreshToken;

    public function __construct(
        protected string $username,
        protected string $password,
    ) {
        $this->authorize();
    }

    protected function request()
    {
        $headers = ['X-Requested-With' => 'XMLHttpRequest'];

        if (isset($this->accessToken)) {
            $headers['X-Authorization'] = "Bearer {$this->accessToken}";
        }

        return Http::baseUrl('https://sft.bics.com/api/')
            ->asJson()
            ->withHeaders($headers)
            ->throw();
    }

    protected function authorize()
    {
        $response = $this->request()->post('login', [
            'username' => $this->username,
            'password' => $this->password,
        ]);

        $this->accessToken = $response->json('AccessToken');
        $this->refreshToken = $response->json('RefreshToken');
    }

    protected function refresh()
    {
        $this->accessToken = null;

        $response = $this->request()
            ->withHeader('X-Authorization', "Bearer {$this->refreshToken}")
            ->get('RefreshToken');

        $this->accessToken = $response->json('AccessToken');
        $this->refreshToken = $response->json('RefreshToken');
    }

    private function endpoints()
    {
        return $this->request()->get('GetEndpoints')->json('Response');
    }

    public function sims($page = 1, $perPage = 100)
    {
        return $this->request()
            ->withQueryParameters(compact('page', 'perPage'))
            ->get('fetchSIM')
            ->json('Response');
    }

    public function getAvailableSims()
    {
        return cache()->remember('availableSims', 3600, function () {
            return collect($this->sims()['responseParam']['rows'])->where('simAttachStatus', 'NOT ATTACHED')->toArray();
        });
    }

    public function getAssignedSims()
    {
        return cache()->remember('assignedSims', 3600, function () {
            return collect($this->sims()['responseParam']['rows'])->where('simAttachStatus', 'ATTACHED')->toArray();
        });
    }

    public function getAllEndpoints()
    {
        $response = $this->endpoints();

        if ($response['resultCode'] == '1' && $response['resultParam']['resultCode'] == '401') {
            $this->refresh();

            return $this->endpoints();
        }

        return $this->endpoints();
    }

    private function endpoint($bicsId)
    {
    }

    public function getSim($iccid)
    {
        return $this->request()->get('fetchSIM', compact('iccid'))->json('Response');
    }

    public function getEndpoint($bicsId)
    {
        return cache()->remember("bics.endpoint.{$bicsId}", 300, function () use ($bicsId) {
            try {
                return $this->request()
                    ->get('GetEndPointProfile', ['endPointId' => $bicsId])
                    ->json('Response');
            } catch (\Exception $exception) {
                return [];
            }
        });
    }

    private function statistics($bicsId, Carbon $from, Carbon $to)
    {
        return $this->request()->get('GetStatistics', [
            'endPointId' => $bicsId,
            'from_date' => $from->format('Ymd'),
            'to_date' => $to->format('Ymd'),
        ])->json('Response');
    }

    public function getStatistics($bicsId, Carbon $from, Carbon $to)
    {
        $stats = $this->statistics($bicsId, $from, $to);

        if ($stats['resultCode'] == '1' && $stats['resultParam']['resultCode'] == '401') {
            $this->refresh();

            return $this->statistics($bicsId, $from, $to);
        }

        return $stats;
    }

    public function syncNewBenefits(Endpoint $endpoint, Plan $plan)
    {
        $plans = $endpoint->getPlansFromBics();

        $benefit = new Benefit();
        $benefit->bics_id = json_encode($plans->sortByDesc('uniqueId')->take(2)->pluck('uniqueId')->toArray());
        $benefit->sim_id = $endpoint->sim->id;
        $benefit->endpoint_id = $endpoint->id;
        $benefit->plan_id = $plan->id;
        $benefit->hybrid = count($plan->bics_id) > 1 ? true : false;
        $benefit->status = 'loaded';
        $benefit->save();
    }

    public function addBenefit(Endpoint $endpoint, Plan $plan)
    {
        $response = $this->request()->patch('endpoint', [
            'Request' => [
                'endPointId' => $endpoint->bics_id,
                'requestParam' => [
                    'addAddonPlanIds' => $plan->bics_id,
                ],
            ],
        ]);

        try {
            $user = \Auth::user() ? \Auth::user()->email ?? 'system' : 'system';

            Mail::raw("Plan added: $plan->name to {$endpoint->sim->iccid} by {$user}", function (Message $message) {
                $message->to('support@speakeasytelecom.com')->from('system@lovemobiledata.com');
            });
        } catch (Exception $exception) {
            \Log::alert(print_r($exception->getMessage(), true));
        }

        return $response->json();
    }

    public function addBenefitManualy(Endpoint $endpoint, $id)
    {
        $response = $this->request()->patch('endpoint', [
            'Request' => [
                'endPointId' => $endpoint->bics_id,
                'requestParam' => [
                    'addAddonPlanIds' => [$id],
                ],
            ],
        ]);

        $this->activateEndpoint($endpoint);

        return $response->body();
    }

    public function activateEndpoint($endpoint)
    {
        $this->request()->post('EndPointActivation', [
            'Request' => [
                'endPointId' => $endpoint->bics_id,
            ],
        ]);
    }

    public function removeBenefits(Endpoint $endpoint, $benefits)
    {
        cache()->forget("bics.endpoint.{$endpoint->bics_id}");
        cache()->forget("endpoint.{$endpoint->id}.benefit");

        return $this->request()->patch('endpoint', [
            'Request' => [
                'endPointId' => $endpoint->bics_id,
                'requestParam' => [
                    'removeAddonUniqueIds' => $benefits,
                ],
            ],
        ])->json();
    }

    public function removeAllBenefits(Endpoint $endpoint)
    {
        foreach ($endpoint->getPlansFromBics()->pluck('uniqueId') as $id) {
            $this->removeBenefit($endpoint, $id);
        }
    }

    public function removeBenefit(Endpoint $endpoint, $id)
    {
        $params = [
            'Request' => [
                'endPointId' => $endpoint->bics_id,
                'requestParam' => [
                    'removeAddonUniqueIds' => [
                        $id,
                    ],
                ],
            ],
        ];

        $response = $this->request()->patch('endpoint', $params);
    }

    public function getPlans($category = 'ADDON', $type = 0)
    {
        $response = $this->request()->get('QueryRatePlan', [
            'planCategory' => $category,
            'planType' => $type,
        ]);

        return json_decode($response->body());
    }

    public function getDestination($id)
    {
        $response = $this->request()->get('GetRoamingProfiles', [
            'roamingProfileId' => $id,
        ]);

        return json_decode($response->body());
    }

    public function getDestinations()
    {
        $response = $this->request()->get('GetRateZone')->json('Response.responseParam');

        return json_decode($response);
    }

    public function getDestinationsBasedOnCountries($countries)
    {
        $response = $this->request()->get('GetRateZone');
        $zones = $response->json('Response')['responseParam']['rateZoneList'];
        $tagIds = [];
        $list = Bics::getDestinationLists();
        foreach ($countries as $country) {
            $countryObj = Country::find($country);
            if (! $countryObj->operators) {
                continue;
            }
            $operators = json_decode($countryObj->operators);
            foreach ($operators as $operator) {
                $found = $list->filter(function ($item) use ($operator) {
                    if ($item['operatorId'] == $operator->id && $item['categoryGroupId'] == $operator->category_group_id) {
                        return true;
                    }

                    return false;
                });

                if (count($found)) {
                    $tagIds[] = $operator->tadigCode;
                }
            }
        }

        $filtered = collect($zones)->filter(function ($zone) use ($tagIds) {
            if (! isset($zone['operatorIdList'])) {
                return false;
            }
            foreach ($tagIds as $tag) {
                if (! collect($zone['operatorIdList'])->where('tadig', $tag)->count()) {
                    return false;
                }
            }

            if (collect($zone['operatorIdList'])->count() == count($tagIds)) {
                return true;
            }

            return false;
        });

        return $filtered->first();
    }

    public function getRoamingDestinations()
    {
        $access = $this->accessToken;

        $response = $this->request()->get('GetRoamingProfiles');

        return json_decode($response->body())->Response->responseParam;
    }

    public function getDestinationLists()
    {
        $response = $this->request()->get('GetRoamingProfiles');
        $json = $response->json();

        return collect($json['Response']['responseParam']['rows'][0]['tadigList']);
    }

    public function createDestination($countries, $name)
    {
        $operators = [];
        $list = Bics::getDestinationLists();
        foreach ($countries as $country) {
            $countryObj = Country::find($country);
            if (! $countryObj->operators) {
                continue;
            }
            foreach (json_decode($countryObj->operators) as $operator) {
                $found = $list->filter(function ($item) use ($operator) {
                    if ($item['operatorId'] == $operator->id && $item['categoryGroupId'] == $operator->category_group_id) {
                        return true;
                    }

                    return false;
                });

                if (count($found)) {
                    $operators[] = [
                        'operatorId' => $operator->id,
                        'sponsorId' => $operator->category_group_id,
                    ];
                }
            }
        }

        $params = [
            'Request' => [
                'requestParam' => [
                    'ratezoneDetails' => [
                        'name' => $name,
                        'destGroupId' => '2515',
                        'status' => '1',
                        'operatorIdList' => $operators,
                    ],
                ],
            ],
        ];

        return $this->request()->post('CreateRateZone', $params);
    }

    public function createDestinationBasedOnPlan($plan)
    {
        $countries = Country::whereIn('id', $plan->countries)->get();
        $params = [
            'roamingProfileInfo' => [
                'roamingProfileName' => 'LMD '.implode(' ', $countries->pluck('id')->toArray()),
                'tadigCodeList' => [],
            ],
        ];
        foreach ($countries as $country) {
            foreach (json_decode($country->operators) as $operator) {
                $params['roamingProfileInfo']['tadigCodeList'][] = [
                    'categoryGroupId' => $operator->category_group_id,
                    'tadigCode' => $operator->tadigCode,
                ];
            }
        }

        $res = $this->request()->post('createRoamingProfile', $params);

        return $res->json('Response.roamingProfileId', false);
    }

    public function getDestinationBasedOnPlan($plan)
    {
        $countries = Country::whereIn('id', $plan->countries)->get();
        $name = 'ALMD '.implode(' ', $countries->pluck('id')->toArray());
        $destinations = $this->getDestinations();

        foreach ($destinations->rows as $destination) {
            if ($destination->roamingProfileName == $name) {
                return $destination->roamingProfileId;
            }
        }

        return false;
    }

    public function createBasePlan(Plan $plan)
    {
        $params = [
            'Request' => [
                'plan' => [
                    'basicInfo' => [
                        'planName' => 'Base Plan '.$plan->id,
                        'planType' => '0',
                        'planCategory' => 'NORMAL',
                        'serviceProfile' => 'SP_1249',
                        'currencyId' => '44',
                        'destinationGroup' => $plan->operators[0],
                        'planStatus' => 'Active',
                    ],
                ],
            ],
        ];

        $response = $this->request()->post('CreatePlan', $params);

        return $response->json('Response.planId', false);
    }

    public function createPlan(Plan $plan)
    {
        $params = [
            'Request' => [
                'plan' => [
                    'basicInfo' => [
                        'planName' => 'ALMD Plan ID '.$plan->id,
                        'planType' => '0',
                        'planCategory' => 'ADDON',
                        'serviceProfile' => 'SP_1335',
                        'planStatus' => 'Active',
                        'currencyId' => '44',
                        'destinationGroup' => 3017,
                        'planStatus' => 'Active',
                        'addOnPriority' => '1',
                    ],
                    'benefit' => [
                        [
                            'benefitId' => '1',
                            'value' => (string) $plan->credit,
                            'rateZone' => (string) $plan->operators[0],
                        ],
                    ],
                    'charge' => [
                        [
                            'chargeAmount' => '0',
                        ],
                    ],
                    'subscription' => [
                        'reSubscription' => 'true',
                        'reSubscriptionRule' => '2',
                        'occurrences' => '1',
                        'activatedBy' => '1',
                    ],
                    'validity' => [
                        'validityType' => '1',
                        'validityFactor' => (string) $plan->length,
                    ],
                ],
                'totalCount' => '1',
            ],
        ];

        return rescue(fn () => $this->request()->post('CreatePlan', $params)->json('Response.planId', false));
    }

    public function delinkEndpoint($id)
    {
        $params = [
            'Request' => [
                'endPointId' => $id,
            ],
        ];

        return $response = $this->request()->post('DeLinkSim', $params);
    }

    public function linkEndpoint($id, $iccid)
    {
        $params = [
            'Request' => [
                'endPointId' => $id,
                'requestParam' => [
                    'iccid' => $iccid,
                ],
            ],
        ];

        return $response = $this->request()->post('LinkSim', $params);
    }

    public function deleteEndpoint($id)
    {
        $response = $this->delinkEndpoint($id);
        if (! ($response->json('Response')['resultParam']['resultCode'] == '6413' || $response->json('Response')['resultParam']['resultCode'] == '6420')) {
            return false;
        }
        $response = $this->request()->post('DeleteEndPoint', [
            'Request' => [
                'endPointId' => $id,
            ],
        ]);

        if ($response->json('Response')['resultParam']['resultCode'] == '10159') {
            Endpoint::where('bics_id', $id)->delete();

            return true;
        }

        return false;
    }

    public function deleteEndpoints($ids)
    {
        $response = [];
        foreach ($ids as $id) {
            if ($id) {
                $response[$id] = $this->deleteEndpoint($id);
            }
        }

        return $response;
    }

    public function createEndpoint($sim)
    {
        $params = [
            'Request' => [
                'requestParam' => [
                    'name' => 'LoveMobileData',
                    'isLinkSIM' => 'true',
                    'roamingProfileId' => '3017',
                    'apnGroupId' => 'PDP_1785',
                    'planId' => 'DEFAULTPRE41274807',
                    'iccid' => $sim->iccid,
                    'isDefaultActivation' => 'true',
                ],
            ],
        ];

        $response = $this->request()->post('CreateEndPoint', $params);

        if ($response->json('Response')['endPointId'] ?? false) {
            $endpoint = Endpoint::create([
                'bics_id' => $response->json('Response')['endPointId'],
                'sim_id' => $sim->id,
                'order_item_id' => null,
                'active' => 1,
                'scheduled' => null,
            ]);
        } else {
            $response = $this->request()->get('fetchSIM?iccid='.$sim->iccid);

            $endpoint = Endpoint::create([
                'bics_id' => $response->json('Response')['responseParam']['rows'][0]['endPointId'],
                'sim_id' => $sim->id,
                'order_item_id' => null,
                'active' => 1,
                'scheduled' => null,
            ]);
        }

        return true;
    }

    public function updatePlanToBeOnActivation($id)
    {
        $params = [
            'Request' => [
                'plan' => [
                    'basicInfo' => [
                        'planId' => $id,
                        'activatedBy' => 0,
                    ],
                ],
            ],
        ];

        $response = $this->request()->post('ModifyPlan', $params);

        return $response->json();
    }

    public function setEndpointBasePlan(Endpoint $endpoint)
    {
        $params = [
            'Request' => [
                'endPointId' => $endpoint->bics_id,
                'requestParam' => [
                    'planId' => 'DEFAULTPRE41274807',
                ],
            ],
        ];

        $response = $this->request()->post('ChangePlan', $params);

        return $response->json('Response')['resultParam']['resultCode'] == '7001';
    }

    public function createEndpointWithBenefits(Sim $sim, Plan $plan, $id = null, $scheduled = null)
    {
        $bicsSim = $this->getSim($sim->iccid)['responseParam']['rows'][0] ?? null;
        if ($bicsSim['endPointId'] !== '-') {
            Endpoint::where('bics_id', $bicsSim['endPointId'])->update(['active' => false]);
            $this->delinkEndpoint($bicsSim['endPointId']);
        }

        $params = [
            'Request' => [
                'requestParam' => [
                    'name' => 'LoveMobileData1',
                    'isLinkSIM' => 'true',
                    'roamingProfileId' => implode('|', $plan->operators),
                    'apnGroupId' => 'PDP_1785',
                    'iccid' => $sim->iccid,
                    'planId' => $plan->bics_base_plan_id,
                    'isDefaultActivation' => 'true',
                ],
            ],
        ];

        if ($plan->hybrid == 1) {
            $params['Request']['requestParam']['addonPlanIds'] = [$plan->bics_id[0]];
        } else {
            $params['Request']['requestParam']['addonPlanIds'] = $plan->bics_id;
        }

        $response = $this->request()->post('CreateEndPoint', $params);

        if (! ($response->json('Response')['endPointId'] ?? false)) {
            return;
        }
        $endpoint = Endpoint::create([
            'bics_id' => $response->json('Response')['endPointId'],
            'sim_id' => $sim->id,
            'order_item_id' => $id,
            'active' => 0,
            'scheduled' => $scheduled,
        ]);

        sleep(1);

        $this->syncNewBenefits($endpoint, $plan);

        if ($bicsSim['endPointId'] !== '-') {
            $this->delinkEndpoint($response->json('Response')['endPointId']);
            $this->linkEndpoint($bicsSim['endPointId'], $sim->iccid);
            $newEndpoint = Endpoint::where('bics_id', $bicsSim['endPointId'])->first();
            $newEndpoint->update(['active' => true]);
            $this->activateEndpoint($newEndpoint);
        } else {
            $this->activateEndpoint($endpoint);
        }
    }

    public function getBenefits()
    {
        $response = $this->request()->get('GetBucket');
    }

    public function createEndpoints($iccids, Plan $plan)
    {
        foreach ($iccids as $iccid) {
            $id = $this->createEndpoint($iccid, $plan);
            $endpointData = $this->getEndpoint($id);
            $endpointData = $endpointData['info']['basicInfo'];
            $endpoint = Endpoint::create([
                'iccid' => $endpointData['iccid'],
                'bics_id' => $id,
                'name' => $endpointData['name'],
                'msisdn' => $endpointData['msisdn'] ?? null,
                'imsi' => $endpointData['imsi'] ?? null,
                'type' => 0,
                'imei_lock_status' => $endpointData['imeiLockStatus'] ?? null,
            ]);
            $details = $endpoint->getBicsSim();
            $serialNo = collect($details['responseParam']['rows'][0]['iMSIList'][0]['supplierIMSIList'])->where('sponsorName', 'IR1')->first()['supplierIMSI'];
            $endpoint->serial_no = $serialNo;
            $endpoint->save();

            $this->addBenefit($endpoint, $plan);
        }
        Artisan::call('bics:sync:endpoints');
    }

    public function addOperatorsToCountries()
    {
        $list = [
            'France' => 'Orange, SFR, Bouygues, Digicel, Free',
            'United Kingdom' => 'Vodafone, O2, Three',
            'Switzerland' => 'Salt',
            'Turkey' => 'TT',
            'Hong Kong' => 'Three, Smartone, CSL',
            'India' => 'Airtel',
            'Indonesia' => 'Telkomsel',
            'Japan' => 'NTT, Softbank',
            'South Korea' => 'Korea Telecom',
            'Thailand' => 'True Move, CAT',
            'Egypt' => 'Orange',
            'Israel' => 'Orange, Hot Mobile, Pelephone',
            'Australia' => 'Optus, Telstra',
            'South Africa' => 'MTN',
            'Canada' => 'Rogers',
            'Mexico' => 'Movistar, Telcel',
            'United States' => 'AT&T, T-Mobile',
            'Brazil' => 'Claro, Telefonica',
        ];

        $response = $this->getRoamingDestinations();
        $destinations = $response->rows[0]->tadigList;

        foreach (Country::all() as $country) {
            $country->operators = '[]';
            $country->save();
        }

        foreach ($destinations as $destination) {
            if ($destination->countryName == 'Viet Nam') {
                $destination->countryName = 'Vietnam';
            }

            $country = Country::where('name', $destination->countryName)->first();

            if ($country && $country->active) {
                $currentOperators = collect(json_decode($country->operators ?? '[]'));

                if (! $currentOperators->where('id', $destination->operatorId)->count()) {
                    $currentOperators->push([
                        'id' => $destination->operatorId,
                        'name' => $destination->operatorName,
                        'category_group_id' => $destination->categoryGroupId,
                        'tadigCode' => $destination->tadigCode,
                    ]);

                    $country->operators = $currentOperators->toArray();
                    $country->save();
                }
            } else {
            }
        }
    }

    public function updateRateZones()
    {
        $response = $this->getDestinations();

        foreach ($response->rateZoneList as $zone) {
            if (! str_contains($zone->name, 'lmd')) {
                continue;
            }
            $planId = str_replace('lmd', '', $zone->name);
            $plan = Plan::find($planId);
            $countries = $plan->countries;
            $operators = [];
            foreach ($countries as $country) {
                $countryModel = Country::find($country);
                if (! $countryModel->operators) {
                    continue;
                }
                foreach (json_decode($countryModel->operators) as $operator) {
                    if (! collect($zone->operatorIdList)->where('operatorId', $operator->id)->where('sponsorId', $operator->category_group_id)->count()) {
                        $operators[] = [
                            'operatorId' => $operator->id,
                            'sponsorId' => $operator->category_group_id,
                        ];
                    }
                }
            }

            //                $removeOperators = [];
            //
            //                foreach ($zone->operatorIdList as $zoneListItem) {
            //                    $removeOperators[] = [
            //                        'operatorId' => $zoneListItem->operatorId,
            //                        'sponsorId' => $zoneListItem->sponsorId
            //                    ];
            //                }

            if (count($operators)) {
                $params = [
                    'Request' => [
                        'requestParam' => [
                            'ratezoneDetails' => [
                                'id' => $zone->id,
                                'operatorIdList' => $operators,
                            ],
                        ],
                    ],
                ];

                $response = $this->request()->post('ModifyRateZone', $params);
            }
        }
    }
}
