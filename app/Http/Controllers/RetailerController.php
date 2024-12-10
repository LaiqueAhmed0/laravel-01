<?php

namespace App\Http\Controllers;

use App\Bics\Bics;
use App\Models\Endpoint;
use App\Models\Retailer;
use App\Models\Sim;
use App\Models\Usage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RetailerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if (! $user->getRetailer()) {
            return abort(404);
        }

        return response()->view('dashboard.retailer', [
            'subHeader' => 'Retailer Dashboard',
            'retailer' => $user->getRetailer(),
        ]);
    }

    public function show(Retailer $retailer)
    {
        return response()->view('admin.retailers.view', [
            'subHeader' => 'Retailer View',
            'retailer' => $retailer,
        ]);
    }

    public function index()
    {
        return response()->view('admin.retailers.index', [
            'subHeader' => 'Retailer Dashboard',
        ]);
    }

    public function create(Request $request)
    {
        return response()->view('admin.retailers.form', [
            'subHeader' => 'Retailer Creation',
        ]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required',
            'address' => 'nullable',
            'address_2' => 'nullable',
            'postcode' => 'nullable',
            'city' => 'nullable',
            'county' => 'nullable',
            'country' => 'required',
        ]);

        Retailer::create($validData);

        Session::flash('swal', [
            'type' => 'success',
            'title' => 'Retailer Added',
            'message' => 'Retailer successfully added',
        ]);

        return response()->redirectToRoute('admin.retailers.index');
    }

    //    public function claimEndpoints() {
    //         return response()->view('retailer.endpoints.claim', [
    //            'subHeader' => 'Retailer Claim Endpoints'
    //        ]);
    //    }

    //get Sims
    public function getEndpoints(Request $request)
    {
        $pagination = $request->input('pagination');

        if ($request->id) {
            $id = $request->id;
        } else {
            $id = Auth::user()->retailer_id;
        }

        $sims = Sim::where('retailer_id', $id);

        if ($request->input('query')) {
            $sims->where('sims.iccid', 'LIKE', "%{$request->input('query')[0]}%");
        }

        $pagination['total'] = $sims->count();

        $sims->limit($pagination['perpage'])->skip(($pagination['page'] - 1) * $pagination['perpage']);

        $data = $sims->get()->toArray();

        return response()->json([
            'meta' => [
                'page' => $pagination['page'],
                'perpage' => $pagination['perpage'],
                'total' => $pagination['total'],
                'pages' => ceil($pagination['total'] / $pagination['perpage']),
            ],
            'data' => $data,
        ]);
    }

    public function viewEndpoint($iccid, Bics $bics)
    {
        $endpoint = Endpoint::where('iccid', $iccid);

        if (! $endpoint->exists()) {
            return abort(404);
        }

        $endpoint = $endpoint->first();

        $data['from'] = '2020-04-01';
        $data['to'] = '2020-04-30';
        $data['usage'] = $bics->getStatistics($endpoint->bics_id, $data['from'], $data['to']);

        if ($data['usage']['resultParam']['resultCode'] == 1340) {
            $data['usage'] = null;
        } else {
            $data['usage'] = $data['usage']['responseParam'];
        }

        $data['usage'] =
            json_decode('{"smsUsage":[{"totalCost":"3","serviceName":"SMS_MO","date":"26/04/2020","totalCount":"3"},{"totalCost":"2","serviceName":"SMS_MO","date":"28/04/2020","totalCount":"2"}],"dataUsage":[{"totalCost":"0.473","date":"27/04/2020","uplink":"2.02","downlink":"21.65","totalVolume":"23.67"},{"totalCost":"0.237","date":"28/04/2020","uplink":"1.01","downlink":"10.82","totalVolume":"11.84"}],"smsTotalUsage":[{"totalCost":"5","serviceName":"SMS_MO","totalCount":"5"}],"dataTotalUsage":{"totalCost":"0.710","uplink":"3.03","downlink":"32.47","totalVolume":"35.50"}}');

        $data['chart'] = Usage::chart($data['usage'], $data['from'], $data['to']);

        $data['profile'] = $bics->getEndpoint($endpoint->bics_id)['info']['basicInfo'];

        //		$data['subscriptions'] = $sim->subscriptions();
        //		if ($subRequest) {
        //			$requestedSub = Subscription::where([
        //				'sim_id' => $sim->id,
        //				'id'     => $subRequest
        //			])->first();
        //		}
        //		if ($sim->active_subscription_id || !empty($requestedSub)) {
        //
        //			if (!empty($requestedSub) && $requestedSub->exists()) {
        //				$data['subscription'] = $requestedSub;
        //			}
        //			else {
        //				$data['subscription'] = $sim->getActiveSubscription();
        //			}
        //
        //			$data['to'] = $data['subscription']->end_date;
        //			$data['from'] = $data['subscription']->first_usage;
        //
        //			if ($data['subscription']->first_usage != null) {
        //				$data['rawUsages'] = Usage::userTable($sim->piccid, $data['from'], $data['to']);
        //				$data['usage'] = Usage::chart($sim->piccid, $data['from'], $data['to']);
        //				$data['total'] = $data['subscription']->getTotalUsage();
        //			}
        //			$data['plan'] = Plan::find($data['subscription']->plan_id);
        //		}

        //        $data['simCards']  = Endpoint::getUserEndpoints(Auth::id());
        $data['endpoint'] = $endpoint;
        $data['subHeader'] = 'My Usage';

        return view('retailer.endpoints.view')->with($data);
    }

    public function importView(Request $request, Retailer $retailer)
    {
        //        $sims = Sim::where('retailer_id', null)->get();

        return view('admin.retailers.import')->with([
            'subHeader' => "Add Sims To {$retailer->name}",
            'retailer' => $retailer,
        ]);
    }

    public function getSims(Request $request)
    {
        $sims = Sim::where('retailer_id', null);
        $totalPages = ceil($sims->count() / 50);

        if ($request->search) {
            $sims->where('iccid', 'LIKE', '%'.$request->search.'%');
        }

        $sims = $sims->limit(50)->skip(($request->page - 1) * 50)->select('id', 'iccid', 'serial_no')->get();
        $data = [
            'results' => [],
            'pagination' => [
                'more' => $totalPages != $request->page,
            ],
        ];

        foreach ($sims as $sim) {
            $data['results'][] = [
                'id' => $sim->serial_no,
                'text' => $sim->iccid,
            ];
        }

        return $data;
    }

    public function import(Request $request, ?Retailer $retailer = null)
    {
        if ($request->from !== 'null' && $request->to !== 'null') {
            Sim::whereBetween('serial_no', [$request->from, $request->to])
                ->whereNull('retailer_id')
                ->update([
                    'retailer_id' => $retailer->id,
                ]);
        } elseif ($request->file) {
            $import = array_map('str_getcsv', preg_split('/\r*\n+|\r+/', file_get_contents($request->file->getRealPath())));

            if (count($import) && $import[0][0] == 'serial_no' && $import[0][1] == 'retailer_id') {
                unset($import[0]);
                foreach ($import as $item) {
                    $endpoint = Sim::where('serial_no', $item[0])->whereNull('retailer_id');
                    if ($item[1]) {
                        $endpoint->update([
                            'retailer_id' => $item[1],
                        ]);
                    } else {
                        $endpoint->update([
                            'retailer_id' => $retailer->id,
                        ]);
                    }
                }
            }
        } elseif ($request->input('endpoints')) {
            foreach ($request->input('endpoints') as $endpoint) {
                Sim::where('serial_no', $endpoint)->whereNull('retailer_id')->update([
                    'retailer_id' => $retailer->id,
                ]);
            }
        } else {
            Session::flash('swal', [
                'type' => 'error',
                'title' => 'Please completely fill one of the options.',
                'message' => '',
            ]);

            return back();
        }

        Session::flash('swal', [
            'type' => 'success',
            'title' => 'Sims assigned',
            'message' => 'Sims were successfully assigned to the retailer.',
        ]);

        return redirect("/admin/retailers/view/{$retailer->id}");
    }

    public function unclaimEndpoint(Request $request, Sim $sim)
    {
        $sim->user_id = null;
        $sim->assigned_to = null;
        $sim->save();

        return back();
    }

    public function getTableData(Request $request)
    {
        $pagination = $request->input('pagination');

        $retailers = Retailer::query();

        //        $retailers->leftJoin('endpoints', 'endpoints.retailer_id', '=', 'retailers.id');
        //        $retailers->selectRaw('retailers.*, (select count(*) from `endpoints` where `retailer_id` = retailers.id) as total_endpoints, (select count(*) from `endpoints` where `retailer_id` = retailers.id and `user_id` != null) as total_claimed');
        if ($request->input('query')) {
            $retailers->where('retailers.name', 'LIKE', "%{$request->input('query')[0]}%");
        }

        $pagination['total'] = $retailers->count();

        $retailers->limit($pagination['perpage'])->skip(--$pagination['page'] * $pagination['perpage']);
        $data = $retailers->get()->toArray();

        return response()->json([
            'meta' => [
                'page' => $pagination['page'],
                'perpage' => $pagination['perpage'],
                'total' => $pagination['total'],
                'pages' => ceil($pagination['total'] / $pagination['perpage']),
            ],
            'data' => $data,
        ]);
    }
}
