<?php

namespace App\Http\Controllers;

use App\Facades\Bics\Bics;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BenefitController extends Controller
{
    public function create()
    {
        return view('admin/benefit/form')->with([
            'countries' => Country::whereNotNull('operators')->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required',
            'data' => 'required',
            'length' => 'required',
            'country_1' => 'required',
            'country_2' => 'required',
            'country' => 'required',
        ]);

        $data['data'] = str_replace(',', '', str_replace(' MB', '', $data['data']));
        $data['length'] = str_replace(' Days', '', $data['length']);

        $destinations = Bics::getDestinations();
        $destinations = collect($destinations->rows);
        if ($data['type'] != 'Single Country/Region') {
            return;
        }
        $country = Country::find($data['country']);

        if (! $destinations->where('roamingProfileName', $country->name)->count()) {
            $response = Bics::createDestination($country);
            $destination = Bics::getDestination($response->Response->resultParam->roamingProfileId);
        } else {
            $destination = $destinations->where('roamingProfileName', $country->name)->first();
        }

        Bics::createPlan($data['data'], $data['length'], $destination->roamingProfileId);
    }

    public function notification(Request $request)
    {
        Log::alert(print_r($request->all(), true));
    }
}
