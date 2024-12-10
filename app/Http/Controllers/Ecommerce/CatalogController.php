<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->addtocart) {
        }

        return view('topup.catalog')->with([
            'subHeader' => 'Countries and Data plans',
        ]);
    }

    public function embed()
    {
        return view('topup.embed.catalog')->with([
            'subHeader' => 'Countries and Data plans',
        ]);
    }

    public function custom()
    {
        return view('topup.custom')->with([
            'subHeader' => 'Custom Plan Creator',
            'back' => '/catalog',
        ]);
    }
}
