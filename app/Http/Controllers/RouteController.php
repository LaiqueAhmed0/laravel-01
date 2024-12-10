<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function register()
    {
        return redirect()->route('login');
    }

    public function root()
    {
        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
