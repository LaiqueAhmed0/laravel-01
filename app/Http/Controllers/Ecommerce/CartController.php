<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        //        $cart = Session::get('cart');
        //        dd($cart);
        $product = [
            'iccid' => $request->iccid,
            'plan_id' => $request->plan,
            'quantity' => 1,
            'scheduled' => $request->scheduled ?? null,
        ];

        if (! empty($cart) && count($cart)) {
            $exist = false;
            foreach ($cart as $key => $item) {
                if ($item['iccid'] == $product['iccid'] && $item['plan_id'] == $product['plan_id']) {
                    $cart[$key]['quantity'] += $product['quantity'];
                    $exist = true;
                }
            }

            if (! $exist) {
                $cart[] = $product;
                $user->cart = $cart;
            } else {
                $user->cart = $cart;
            }
        } else {
            $user->cart = [$product];
        }

        $user->save();
    }

    public function remove(Request $request, $id = null)
    {
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        if ($id) {
            unset($cart[$id - 1]);
            $user->cart = $cart;
            $user->save();
        }

        return back();
    }

    private function format($cart)
    {
        $plans = Plan::get();
        $items['items'] = [];
        $items['total'] = 0;
        $items['tax'] = 0;
        $items['subtotal'] = 0;

        if (! $cart) {
            return $items;
        }
        foreach ($cart as $key => $item) {
            $plan = $plans->where('id', $item['plan_id'])->first();
            $items['items'][] = [
                'id' => $key,
                'planName' => $plan->name,
                'iccid' => $item['iccid'],
                'rate' => $plan->pricing,
                'qty' => $item['quantity'],
                'scheduled' => $item['scheduled'] ?? null,
                'scheduled_format' => $item['scheduled'] ? Carbon::parse($item['scheduled'])->format('d/m/Y') : Carbon::now()->format('d/m/Y'),
            ];
            $items['total'] += ($plan->pricing * $item['quantity']);
            $items['tax'] += round(($plan->pricing * $item['quantity']) * .2);
        }
        $items['subtotal'] = $items['total'] + $items['tax'];

        return $items;
    }

    public function get(Request $request)
    {
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        $items = $this->format($cart);

        return response()->json($items);
    }

    public function increase(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        $cart[$id]['quantity']++;

        $user->cart = $cart;
        $user->save();
    }

    public function decrease(Request $request)
    {
        $id = $request->id;
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        if (! ($id || $id === '0' && ! empty($cart[(int) $id]))) {
            $user->cart = $cart;
            $user->save();

            return;
        }
        $cart[$id]['quantity']--;

        if (! $cart[$id]['quantity']) {
            unset($cart[$id]);
        }

        $user->cart = $cart;
        $user->save();
    }

    public static function clear()
    {
        $user = Auth::user();
        $user->cart = null;
        $user->save();
    }

    public function cart()
    {
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        $plans = Plan::get();
        $total = 0;
        $tax = 0;
        if ($cart) {
            foreach ($cart as $item) {
                $plan = $plans->where('id', $item['plan_id'])->first();
                $itemTotal = $plan->pricing * (int) $item['quantity'];
                $total += $itemTotal;
                $tax += round($itemTotal * .2);
            }
        }

        return view('ecom.cart')->with([
            'subHeader' => 'My Cart',
            'back' => '/catalog',
            'total' => number_format(($total + $tax) / 100, 2),
            'subtotal' => number_format($total / 100, 2),
            'tax' => number_format($tax / 100, 2),
        ]);
    }

    public function table(Request $request)
    {
        $user = Auth::user();
        $cart = json_decode($user->cart, true);
        $plans = Plan::get();
        $total = count($cart) ?? 0;
        $counter = 1;
        $data = [
            'meta' => [
                'page' => 1,
                'perpage' => $total,
                'total' => $total,
                'pages' => 1,
            ],
        ];

        $data['data'] = [];

        if (! $cart) {
            return response()->json($data);
        }
        foreach ($cart as $item) {
            $plan = $plans->where('id', $item['plan_id'])->first();
            $data['data'][] = [
                'id' => $counter++,
                'plan' => $plan->name,
                'iccid' => $item['iccid'],
                'img' => $plan->image,
                'scheduled' => $item['scheduled'] ? Carbon::parse($item['scheduled'])->format('d/m/Y') : Carbon::now()->format('d/m/Y'),
                'rate' => '£ '.($plan->pricing / 100),
                'quantity' => $item['quantity'],
                'total' => '£ '.round(($plan->pricing * (int) $item['quantity']) / 100, 2),
            ];
        }

        return response()->json($data);
    }
}
