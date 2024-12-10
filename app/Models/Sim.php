<?php

namespace App\Models;

use App\Facades\Bics\Bics;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sim extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status', 'current_plan_name', 'claimed_by'];

    public function getClaimedByAttribute()
    {
        return $this->user ? ($this->user->first_name.' '.$this->user->last_name) : 'N/A';
    }

    public function endpoint()
    {
        return $this->hasOne(Endpoint::class);
    }

    public function getStatusAttribute()
    {
        return $this->endpoint()->exists();
    }

    public function getEndpointWherePlanCountry($country)
    {
        return $this->endpoints()
            ->leftJoin('benefits', 'endpoints.id', '=', 'benefits.endpoint_id')
            ->leftJoin('plans', 'plans.id', 'benefits.plan_id')
            ->whereJsonContains('plans.countries', (string) $country)
            ->where('endpoints.active', 0)
            ->where(function ($query) {
                return $query->where('endpoints.expiry', '>', Carbon::now())->orWhere('endpoints.expiry', null);
            })
            ->where(function ($query) {
                return $query->where('endpoints.scheduled', '>', Carbon::now());
            })
            ->select(['endpoints.*', DB::raw('benefits.id AS benefit_id'), DB::raw('plans.id AS plan_id'), DB::raw('plans.countries AS countries')])->oldest()->first() ?? null;
    }

    public function addPlan(Plan $plan, $itemId = null, $scheduled = null)
    {
        if (! $this->current_endpoint) {
            Bics::createEndpoint($this);
        }

        if ($plan->operators == null) {
            Bics::createDestination($plan->countries, 'lmd'.$plan->id);
            $destination = Bics::getDestinationsBasedOnCountries($plan->countries);
            $plan->operators = '['.$destination['id'].']';
            $plan->save();
        }

        if ($plan->operators != null && ($plan->bics_id == null || $plan->bics_id == '[]')) {
            $id = Bics::createPlan($plan);
            $plan->bics_id = '['.$id.']';
            $plan->save();
        }

        if ($plan->bics_id != null && $plan->operators != null) {
            Bics::addBenefit($this->current_endpoint, $plan);
        }

        sleep(1);

        $this->syncBenefits();
    }

    public function syncBenefits()
    {
        $hybridPrev = null;

        if (! $this->current_endpoint) {
            return;
        }
        foreach ($this->current_endpoint->getPlansFromBics() as $benefit) {
            if (! Benefit::where('bics_id', $benefit['uniqueId'])->exists()) {
                $plan = Plan::whereJsonContains('bics_id', (int) $benefit['planId']);

                // dd($plan->first());

                if (! $plan->exists()) {
                    continue;
                }

                $plan = $plan->first();

                $data = [
                    'bics_id' => $benefit['uniqueId'],
                    'endpoint_id' => $this->current_endpoint->id,
                    'sim_id' => $this->id,
                    'plan_id' => $plan->id,
                    'hybrid' => $plan->hybrid,
                    'start_date' => $benefit['planStartDate'] ?? null,
                    'expiry_date' => $benefit['planExpiryDate'] ?? null,
                ];

                if (str_ends_with($benefit['planName'], ' 1') || str_ends_with($benefit['planName'], ' 2')) {
                    if (! $hybridPrev) {
                        $hybridPrev = $benefit['uniqueId'];
                    } elseif ($hybridPrev) {
                        $data['linked_benefit'] = $hybridPrev;
                        $hybridPrev = null;
                    }
                }

                Benefit::create($data);
            } else {
                Benefit::where('bics_id', $benefit['uniqueId'])->update([
                    'start_date' => $benefit['planStartDate'] ?? null,
                    'expiry_date' => $benefit['planExpiryDate'] ?? null,
                ]);
            }
        }
    }

    public function getCurrentEndpointAttribute()
    {
        return $this->endpoint()->where('active', true)->first();
    }

    public function getCurrentPlanNameAttribute()
    {
        if (! $this->current_endpoint) {
            return 'No Plan';
        }

        return $this->current_endpoint->benefit->plan->name ?? 'No Plan';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function volume()
    {
        return $this->hasMany(Volume::class, 'iccid', 'iccid');
    }

    public function getRetailerNameAttribute()
    {
        return $this->retailer->name ?? 'No Retailer';
    }

    public function switchToNextQueuedEndpoint()
    {
        $endpoint = $this->endpoints()->where('active', 0)->where('expiry', null)->latest()->first();
        $this->switchEndpoint($endpoint);
    }

    public function switchEndpoint($endpoint)
    {
        if (! $endpoint) {
            return;
        }
        $res = \App\Facades\Bics\Bics::getSim($this->iccid);
        if ($res['responseParam']['rows'][0]['endPointId']) {
            \App\Facades\Bics\Bics::delinkEndpoint($res['responseParam']['rows'][0]['endPointId']);
        }

        $currentEndpoint = $this->current_endpoint;
        if ($currentEndpoint) {
            $currentEndpoint->active = false;
            $currentEndpoint->save();
        }

        \App\Facades\Bics\Bics::linkEndpoint($endpoint->bics_id, $this->iccid);
        \App\Facades\Bics\Bics::activateEndpoint($endpoint);
        $endpoint->active = true;
        $endpoint->save();
    }

    public function getUsagePercentage()
    {
    }

    public function getVolumeLimitAttribute()
    {
        return $this->current_endpoint ? number_format($this->current_endpoint->volume_limit, 0) : '0';
    }

    public function getVolumeAttribute()
    {
        return $this->current_endpoint ? number_format($this->current_endpoint->volume, 0) : '0';
    }

    public function getVolumeRemainingAttribute()
    {
        return $this->current_endpoint ? number_format($this->current_endpoint->volume_remaining, 0) : '0';
    }

    public function getBreakdownAttribute()
    {
        $to = Carbon::now();
        $from = $to->clone()->subDays(120);

        if (! ($from && $to)) {
            return false;
        }

        return $this->volume()->where('volume', '!=', 0)->orderBy('date', 'DESC')->whereBetween('date', [$from->startOfDay(), $to->endOfDay()])->get()->map(function ($volume) {
            $volume->date = Carbon::createFromFormat('d/m/Y H:i:s', $volume->timestamp)->toDateString();

            return $volume;
        })->groupBy(['date', 'country', 'operator'])->map(function ($date) {
            return $date->mapWithKeys(function ($operators, $country) {
                return [
                    Country::where('bics_id', $country)->first()->name => $operators->map(function ($volumes) {
                        return $volumes->sum('volume');
                    }),
                ];
            });
        });

        return $this->volume()->where('volume', '!=', 0)->orderBy('date', 'DESC')->whereBetween('date', [$from->startOfDay(), $to->endOfDay()])->get()->map(function ($volume) {
            $volume->date = Carbon::createFromFormat('d/m/Y H:i:s', $volume->timestamp)->toDateString();

            return $volume;
        })->groupBy('date')->map(function ($volumes) {
            $row = [];

            foreach ($volumes->groupBy('country') as $sortedVolumes) {
                foreach ($sortedVolumes->groupBy('operator') as $operatorVolumes) {
                    $row[] = [
                        'date' => $operatorVolumes[0]->date,
                        'operator_name' => $operatorVolumes[0]->operator_name,
                        'country' => $operatorVolumes[0]->country_details,
                        'volume' => $operatorVolumes->sum('volume'),
                    ];
                }
            }

            return $row;
        });

        // return $this->volume()->orderBy('date', 'DESC')->whereBetween('date', [$from->startOfDay(), $to->endOfDay()])->get() ?? false;
    }

    public function getBreakdownChartFormattedAttribute()
    {
        $to = Carbon::now();
        $from = $to->clone()->subDays(30);

        if ($from && $to) {
            // return Usage::chart($this->volume()->orderBy('date', 'DESC')->whereBetween('date', [$from->startOfDay(), $to->endOfDay()])->get(), [$from->startOfDay(), $to->endOfDay()]) ?? ['data' => [], 'labels' => []];
        }

        return false;
    }
}
