<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function get(Request $request)
    {
        $data = createTable($request, new Pricing(), [
            'id' => 'default',
            'name' => 'default',
        ]);

        return response()->json($data);
    }

    public function index()
    {
        return response()->view('admin.pricing.index', [
            'subHeader' => 'Plans',
        ]);
    }

    public function create(Request $request)
    {
        return response()->view('admin.pricing.form', [
            'subHeader' => 'Pricing Condition Creation',
        ]);
    }

    public function delete(Request $request, Pricing $pricing)
    {
        $pricing->delete();

        return back();
    }

    public function edit(Request $request, Pricing $pricing)
    {
        return response()->view('admin.pricing.form', [
            'subHeader' => 'Pricing update',
            'pricing' => $pricing,
        ]);
    }
}
