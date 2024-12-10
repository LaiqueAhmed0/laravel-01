<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->group >= 3) {
            return view('dashboard.admin')->with([
                'subHeader' => 'Admin Dashboard',
            ]);
        }

        if ($user->group == 2) {
            return redirect()->route('retailer.index');
        }

        if ($user->sims) {
            return view('dashboard.sims')->with([
                'sims' => Auth::user()->sims,
                'subHeader' => 'My Sims',
            ]);
        }

        return redirect('/sim/register');
    }

    /** END: Callum's Code **/
    public function showDashboard(Request $request, object $user)
    {
        $endpoint = $user->getFirstEndpoint();

        return redirect("/dashboard/{$endpoint->iccid}");
    }

    public function sim(Sim $sim)
    {
        $sim->syncBenefits();

        return view('dashboard.user')->with([
            'history' => \request()->input('history') ?? null,
            'sim' => $sim,
            'subHeader' => 'Usage for: ',
            'subHeaderType' => 'sim',
            'back' => '/dashboard',
        ]);
    }
}
