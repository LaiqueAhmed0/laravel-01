<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function get(Request $request)
    {
        $data = createTable($request, new Plan(), [
            'id' => 'default',
            'name' => 'default',
            'formatted_countries' => 'default',
            'credit' => 'default',
            'rate' => 'default',
            'pricing' => 'default',
            'length' => 'default',
        ]);

        return response()->json($data);
    }

    public function index()
    {
        return response()->view('admin.plan.index', [
            'subHeader' => 'Plans',
        ]);
    }

    public function create(Request $request)
    {
        return response()->view('admin.plan.form', [
            'subHeader' => 'Plan Creation',
        ]);
    }

    public function store(Request $request)
    {
        $validData = $request->validate([
            'bics_id' => 'nullable',
            'name' => 'required',
            'rate' => 'nullable',
            'credit' => 'required',
            'length' => 'required',
            'hybrid' => 'nullable',
            'type' => 'nullable',
            'fixed_price' => 'nullable',
            'featured' => 'nullable',
            'countries' => 'required',
        ]);

        if (isset($validData['type']) && $validData['type'] == 'on') {
            $validData['type'] = 'admin';
        } else {
            $validData['type'] = 'customer';
        }

        if (isset($validData['hybrid']) && $validData['hybrid'] == 'on') {
            $validData['hybrid'] = 1;
        } else {
            $validData['hybrid'] = 0;
        }

        if (isset($validData['featured']) && $validData['featured'] == 'on') {
            $validData['featured'] = 1;
        } else {
            $validData['featured'] = 0;
        }

        if (isset($validData['fixed_price']) && $validData['fixed_price'] == 'on') {
            $validData['fixed_price'] = 1;
        } else {
            $validData['fixed_price'] = 0;
        }

        $validData['countries'] = json_encode($validData['countries']);

        if (! isset($validData['bics_id'])) {
            Plan::create($validData);

            return response()->redirectToRoute('admin.plans.index');
        }
        foreach (array_values(json_decode($validData['bics_id'])) as $bic) {
            $data[] = $bic->value;
        }
        $validData['bics_id'] = json_encode($data);

        Plan::create($validData);

        return response()->redirectToRoute('admin.plans.index');
    }

    public function copy(Request $request, Plan $plan)
    {
        $newPlan = $plan->replicate();
        $newPlan->created_at = Carbon::now();
        $newPlan->bics_id = null;
        $newPlan->operators = null;
        $newPlan->save();

        return back();
    }

    public function delete(Request $request, Plan $plan)
    {
        $plan->delete();

        return back();
    }

    public function setMarkup(Request $request)
    {
        Setting::updateOrCreate(['name' => 'markup'], ['value' => $request->markup]);

        return back();
    }

    public function setConversion(Request $request)
    {
        Setting::updateOrCreate(['name' => 'conversion'], ['value' => $request->rate]);

        return back();
    }

    public function edit(Request $request, Plan $plan)
    {
        return response()->view('admin.plan.form', [
            'subHeader' => 'Plan update',
            'plan' => $plan,
        ]);
    }

    public function update(Request $request, Plan $plan)
    {
        $validData = $request->validate([
            'bics_id' => 'nullable',
            'name' => 'required',
            'rate' => 'nullable',
            'credit' => 'required',
            'length' => 'required',
            'hybrid' => 'nullable',
            'type' => 'nullable',
            'fixed_price' => 'nullable',
            'featured' => 'nullable',
            'countries' => 'required',
        ]);

        if (isset($validData['type']) && $validData['type'] == 'on') {
            $validData['type'] = 'admin';
        } else {
            $validData['type'] = 'customer';
        }

        if (isset($validData['hybrid']) && $validData['hybrid'] == 'on') {
            $validData['hybrid'] = 1;
        } else {
            $validData['hybrid'] = 0;
        }

        if (isset($validData['featured']) && $validData['featured'] == 'on') {
            $validData['featured'] = 1;
        } else {
            $validData['featured'] = 0;
        }

        if (isset($validData['fixed_price']) && $validData['fixed_price'] == 'on') {
            $validData['fixed_price'] = 1;
        } else {
            $validData['fixed_price'] = 0;
        }

        $validData['countries'] = json_encode($validData['countries']);

        unset($validData['bics_id']);
        //        if (isset($validData['bics_id'])) {
        //            foreach (array_values(json_decode($validData['bics_id'])) as $bic) {
        //                $data[] = $bic->value;
        //            }
        //            $validData['bics_id'] = json_encode($data);
        //        }

        $plan->update($validData);

        return response()->redirectToRoute('admin.plans.index');
    }
}
