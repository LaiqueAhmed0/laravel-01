<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function get(Request $request)
    {
        $data = createTable($request, new Region(), [
            'id' => 'default',
            'name' => 'default',
            'countries_count' => 'default',
            'min_cost' => 'default',
            'avg_cost' => 'default',
            'max_cost' => 'default',
        ]);

        return response()->json($data);
    }

    public function index()
    {
        return response()->view('admin.regions.index', [
            'subHeader' => 'Regions',
        ]);
    }

    public function create(Request $request)
    {
        return response()->view('admin.regions.form', [
            'subHeader' => 'Region Creation',
        ]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'name' => 'required',
            'countries' => 'required',
        ]);

        Region::create([
            'name' => $validData['name'],
            'countries' => json_encode($validData['countries']),
        ]);

        return response()->redirectToRoute('admin.regions.index');
    }

    public function update(Request $request, Region $region)
    {
        $validData = $request->validate([
            'name' => 'required',
            'countries' => 'required',
        ]);

        $region->update([
            'name' => $validData['name'],
            'countries' => json_encode($validData['countries']),
        ]);

        return response()->redirectToRoute('admin.regions.index');
    }

    public function delete(Request $request, Region $region)
    {
        $region->delete();

        return back();
    }

    public function edit(Request $request, Region $region)
    {
        return response()->view('admin.regions.form', [
            'subHeader' => 'Region update',
            'region' => $region,
        ]);
    }
}
