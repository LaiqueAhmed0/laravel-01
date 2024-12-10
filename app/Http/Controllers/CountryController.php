<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function get(Request $request)
    {
        $data = createTable($request, new Country(), [
            'id' => 'default',
            'name' => 'default',
            'code' => 'default',
            'price_per_mb' => 'default',
        ]);

        return response()->json($data);
    }

    public function index()
    {
        return response()->view('admin.countries.index', [
            'subHeader' => 'Countries',
        ]);
    }

    public function delete(Request $request, Country $country)
    {
        $country->delete();

        return back();
    }

    public function edit(Request $request, Country $country)
    {
        return response()->view('admin.countries.form', [
            'subHeader' => 'Country update',
            'country' => $country,
        ]);
    }

    public function update(Request $request, Country $country)
    {
        $validData = $request->validate([
            'name' => 'required',
            'price_per_mb' => 'required',
            'operator.*' => '',
        ]);

        $country->name = $validData['name'];
        $country->price_per_mb = $validData['price_per_mb'];

        $operators = json_decode($country->operators, true);

        foreach ($validData['operator'] as $key => $value) {
            if ($value) {
                $operators[$key]['price'] = $value;
            }
        }

        $country->operators = json_encode($operators);
        $country->save();

        return response()->redirectToRoute('admin.countries.index');
    }
}
