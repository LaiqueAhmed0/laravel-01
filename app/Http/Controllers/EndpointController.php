<?php

namespace App\Http\Controllers;

use App\Bics\Bics;
use App\Mail\AssignToUser;
use App\Models\Endpoint;
use App\Models\Sim;
use App\Models\Usage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class EndpointController extends Controller
{
    public function index(Request $request)
    {
        return response()->view('admin.endpoints.index', [
            'subHeader' => 'Sims Dashboard',
        ]);
    }

    public function unAssigned(Request $request)
    {
        $endpoints = Endpoint::where('retailer_id', null)->limit(30)->offset(($request->page ?? 0) * 30)->get();
        $data['results'] = [];
        foreach ($endpoints as $endpoint) {
            $data['results'][] = [
                'id' => $endpoint->id,
                'text' => $endpoint->iccid,
            ];
        }

        $data['pagination'] = [
            'more' => (count($data['results']) == 30),
        ];

        return response()->json($data);
    }

    public function get(Request $request)
    {
        $pagination = $request->input('pagination');
        $endpoints = Endpoint::query();

        if (! Route::currentRouteName() == 'admin.endpoints.get') {
            $id = Auth::user()->retailer_id;
            $endpoints->where('endpoints.retailer_id', $id);
        }

        $endpoints->leftJoin('users', 'users.id', '=', 'endpoints.user_id');
        $endpoints->leftJoin('retailers', 'retailers.id', '=', 'endpoints.retailer_id');

        if (! ($request->input('query') && isset($request->input('query')[0]))) {
            $endpoints->selectRaw('endpoints.*, CONCAT(users.first_name, " ", users.last_name) as claimed_by, retailers.name as retailer');
            $pagination['total'] = $endpoints->count();

            $endpoints->limit($pagination['perpage'])->skip(($pagination['page'] - 1) * $pagination['perpage']);
            $endpoints = $endpoints->get();

            $data = $endpoints->toArray();

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
        $endpoints->where(function ($endpoints) use ($request) {
            $endpoints->orWhere('endpoints.id', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('endpoints.iccid', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('endpoints.serial_no', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('users.first_name', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('users.last_name', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('users.company_name', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('users.email', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('users.postcode', 'LIKE', "%{$request->input('query')[0]}%");
            $endpoints->orWhere('retailers.name', 'LIKE', "%{$request->input('query')[0]}%");

            return $endpoints;
        });

        $endpoints->selectRaw('endpoints.*, CONCAT(users.first_name, " ", users.last_name) as claimed_by, retailers.name as retailer');
        $pagination['total'] = $endpoints->count();

        $endpoints->limit($pagination['perpage'])->skip(($pagination['page'] - 1) * $pagination['perpage']);
        $endpoints = $endpoints->get();

        $data = $endpoints->toArray();

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

    public function removeClaimant(Request $request, Sim $sim)
    {
        $sim->user_id = null;
        $sim->save();

        $request->session()->flash('swal', [
            'title' => 'Claimant Removed',
            'message' => 'The claimant was removed from the sim: '.$sim->iccid,
            'type' => 'success',
        ]);

        return back();
    }

    public function removeRetailer(Request $request, Sim $sim)
    {
        $sim->retailer_id = null;
        $sim->save();

        $request->session()->flash('swal', [
            'title' => 'Retailer Removed',
            'message' => 'The retailer was removed from the sim: '.$sim->iccid,
            'type' => 'success',
        ]);

        return back();
    }

    public function send(Request $request)
    {
        $endpoint = Endpoint::find($request->endpoint);

        if (! $endpoint) {
            $request->session()->flash('swal', [
                'title' => 'Missing/Invalid Sim',
                'message' => 'Missing or invalid sim, speak to support.',
                'type' => 'error',
            ]);

            return back();
        }

        if (! $request->email) {
            $request->session()->flash('swal', [
                'title' => 'Missing/Invalid Email',
                'message' => 'Missing or invalid email for the following sim: '.$endpoint->iccid,
                'type' => 'error',
            ]);

            return back();
        }

        $user = User::where('email', $request->email);
        if ($user->exists()) {
            $endpoint->user_id = $user->first()->id;
        }

        $endpoint->assigned_to = $request->email;
        $endpoint->save();

        Mail::to($request->email)->send(new AssignToUser($endpoint->iccid));

        $request->session()->flash('swal', [
            'title' => 'Assigned Sim',
            'message' => $endpoint->iccid.' Has been assigned to the user: '.$request->email,
            'type' => 'success',
        ]);

        return back();
    }

    public function export()
    {
        $path = Storage::path('export.csv');

        if (! Storage::exists($path)) {
            touch($path);
        }

        $file = fopen($path, 'w');

        fputcsv($file, [
            'Serial No',
            'Iccid',
            'Retailer',
            'Current Plan',
            'Claimed By',
        ]);

        foreach (Endpoint::all() as $endpoint) {
            fputcsv($file, [
                $endpoint->serial_no,
                $endpoint->iccid,
                $endpoint->retailer,
                $endpoint->current_benefit,
                $endpoint->claimed_by_email,
                $endpoint->postcode,
            ]);
        }

        fclose($file);

        return Storage::download('export.csv');
    }

    public function addBenefit(Request $request, Endpoint $endpoint)
    {
        return view('admin.endpoints.add-plan')->with([
            'endpoint' => $endpoint,
        ]);
    }

    public function create()
    {
        return view('admin.endpoints.create');
    }

    public function delete()
    {
        return view('admin.endpoints.delete');
    }

    public function show(Endpoint $endpoint, Bics $bics)
    {
        return redirect('/dashboard/'.$endpoint->iccid);

        $data['from'] = '2020-04-01';
        $data['to'] = '2020-04-30';

        $data['usage'] = $bics->getStatistics($endpoint->bics_id, $data['from'], $data['to']);

        if (in_array($data['usage']['resultParam']['resultCode'], ['1340', '1000'])) {
            $data['usage'] = null;
        } else {
            $data['usage'] = $data['usage']['responseParam'];
        }

        $data['usage'] =
            json_decode('{"smsUsage":[{"totalCost":"3","serviceName":"SMS_MO","date":"26/04/2020","totalCount":"3"},{"totalCost":"2","serviceName":"SMS_MO","date":"28/04/2020","totalCount":"2"}],"dataUsage":[{"totalCost":"0.473","date":"27/04/2020","uplink":"2.02","downlink":"21.65","totalVolume":"23.67"},{"totalCost":"0.237","date":"28/04/2020","uplink":"1.01","downlink":"10.82","totalVolume":"11.84"}],"smsTotalUsage":[{"totalCost":"5","serviceName":"SMS_MO","totalCount":"5"}],"dataTotalUsage":{"totalCost":"0.710","uplink":"3.03","downlink":"32.47","totalVolume":"35.50"}}');

        $data['chart'] = Usage::chart($data['usage'], $data['from'], $data['to']);
        $benefit = null;

        if (isset($bics->getEndpoint($endpoint->bics_id)['info']['benefitInfo']) && isset($bics->getEndpoint($endpoint->bics_id)['info']['benefitInfo']['benefit'])) {
            $benefit = $bics->getEndpoint($endpoint->bics_id)['info']['benefitInfo']['benefit'];
        }
        $benefit = collect($benefit);
        $data['subscription'] = $benefit->where('name', '=', 'DATA')->first();

        $data['profile'] = $bics->getEndpoint($endpoint->bics_id)['info']['basicInfo'];

        $data['endpoint'] = $endpoint;
        $data['subHeader'] = 'Details for '.$endpoint->iccid;

        return view('retailer.endpoints.view')->with($data);
    }
}
