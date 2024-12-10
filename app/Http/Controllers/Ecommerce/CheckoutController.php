<?php

namespace App\Http\Controllers\Ecommerce;

use App\Facades\Square;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Plan;
use App\Models\Sim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PH7\Eu\Vat\Provider\Europa;
use PH7\Eu\Vat\Validator as Vat;

class CheckoutController extends Controller
{
    private $url = 'https://gw1.cardsaveonlinepayments.com:4430/';

    private $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $user = Auth::User();
        $cart = json_decode($user->cart, true);

        //        if (!$cart) {
        //            return redirect()->route('cart');
        //        }

        $plans = Plan::get();
        $data = [];

        $total = 0;
        $tax = 0;

        if (! $cart) {
            return redirect('/catalog');
        }
        foreach ($cart as $item) {
            $plan = $plans->where('id', $item['plan_id'])->first();
            $data[] = [
                'plan' => $plan->name,
                'piccid' => $item['iccid'],
                'rate' => '£ '.number_format($plan->pricing / 100, 2),
                'img' => $plan->image,
                'quantity' => $item['quantity'],
                'total' => '£ '.number_format(($plan->pricing * (int) $item['quantity']) / 100, 2),
            ];
            $itemTotal = round(($plan->pricing * (int) $item['quantity']) / 100, 2);
            $total += $itemTotal;
            $tax += round(($itemTotal * .2), 2);
        }

        return view('ecom.checkout')->with([
            'user' => $user,
            'subHeader' => 'Checkout',
            'cart' => $data,
            'total' => number_format($total + $tax, 2),
            'subtotal' => number_format($total, 2),
            'tax' => number_format($tax, 2),
        ]);
    }

    public function validateTax(Request $request)
    {
        $companyCodes = [
            'AT',
            'BE',
            'BG',
            'HR',
            'CY',
            'CZ',
            'DK',
            'EE',
            'FI',
            'FR',
            'DE',
            'EL',
            'GB',
            'HU',
            'IE',
            'IT',
            'LV',
            'LT',
            'LU',
            'MT',
            'NL',
            'PL',
            'PT',
            'RO',
            'SK',
            'SI',
            'ES',
            'SE',
        ];

        $taxCode = $request->tax;
        $companyCode = strtoupper(substr($taxCode, 0, 2));

        $number = ltrim($taxCode, substr($taxCode, 0, 2));

        if (! in_array($companyCode, $companyCodes)) {
            return response()->json(false);
        }
        $vat = new Vat(new Europa, $number, $companyCode);

        return response()->json($vat->check());
    }

    public function orderItemsCreateOrUpdate($orderId)
    {
        $user = Auth::User();
        $cart = json_decode($user->cart, true);
        $plans = Plan::get();
        if (! $cart) {
            return;
        }
        foreach ($cart as $item) {
            $plan = $plans->where('id', $item['plan_id'])->first();
            $sim = Sim::where('iccid', $item['iccid'])->first();
            OrderItem::updateOrCreate([
                'order_id' => $orderId,
                'plan_id' => $item['plan_id'],
                'sim_id' => $sim->id,
                'scheduled' => $item['scheduled'] == 0 ? null : $item['scheduled'],
            ], [
                'quantity' => $item['quantity'],
                'price' => $plan->pricing,
            ]);
        }
    }

    public function orderCreate(array $request)
    {
        $user = Auth::User();
        $cart = json_decode($user->cart, true);

        //        if (!$cart) {
        //            return redirect()->route('cart');
        //        }

        $plans = Plan::get();
        $data = [];
        $total = 0;
        $tax = 0;

        if ($cart) {
            foreach ($cart as $item) {
                $plan = $plans->where('id', $item['plan_id'])->first();
                $itemTotal = ceil(($plan->pricing * (int) $item['quantity']));
                $total += $itemTotal;
                $tax += ceil(($itemTotal * .2));
            }
        }

        $order = new Order;

        $order->user_id = Auth::user()->id;
        $order->first_name = $request['fname'];
        $order->last_name = $request['lname'];
        $order->company_name = $request['company_name'];
        $order->tax_code = $request['tax_code'];
        $order->phone = $request['phone'];
        $order->email = $request['email'];
        $order->address_1 = $request['address1'];
        $order->address_2 = $request['address2'];
        $order->postcode = $request['postcode'];
        $order->city = $request['city'];
        $order->county = $request['county'];
        $order->country = $request['country'];
        $order->subtotal = $total;

        \Log::alert($total);

        if ($request['country'] == 77) {
            $order->tax = $tax;
        } else {
            $order->tax = 0;
        }

        $order->total = $order->tax + $total;
        $order->status = 'pending';

        $res = $order->save();

        if ($res) {
            $this->orderItemsCreateOrUpdate($order->id);

            return $order;
        }

        return false;
    }

    public function pay(Request $request)
    {
        $order = $this->orderCreate($request->form);
        \Log::alert($order->total);
        $res = Square::charge($order->total, $request->sourceId, Auth::user(), 'LMD - Topup for '.$request->form['email'] ?? '');

        Session::put('order', $order->id);

        if ($res['result']) {
            $order->squareup_checkout = $res['payment']->getOrderId();
            $order->save();

            return $res['payment'];
        }

        return false;
    }

    private function postPayProcess($request)
    {
        if (! $request->session()->has('order')) {
            return null;
        }

        return Order::find(Session::get('order'));
    }

    public function success(Request $request)
    {
        $order = $this->postPayProcess($request);

        if (! $order) {
            return redirect('/cart');
        }
        $user = Auth::User();
        $user->cart = null;
        $user->save();

        return view('ecom.complete')->with([
            'order' => $order,
            'subHeader' => 'Checkout Complete',
        ]);
    }

    public function cancelled(Request $request)
    {
        $order = $this->postPayProcess($request);

        if (! ($order->user_id == $this->user->id && $order->status == 0)) {
            return abort(404);
        }
        $user = Auth::User();
        $user->cart = null;
        $user->save();
        $order->status = 'cancelled';
        $order->save();

        return view('ecom.complete')->with([
            'order' => $order,
            'subHeader' => 'Order Cancelled',
        ]);
    }

    public function notification(Request $request)
    {
        $order = Square::onWebhook();

        if (! $order) {
            exit;

            return;
        }
        foreach ($order->orderItems as $item) {
            if (! (! $item->scheduled && ! $item->applied)) {
                continue;
            }
            for ($i = 0; $i < $item->quantity; $i++) {
                $item->sim->addPlan($item->plan, $item->id);
                $item->update([
                    'applied' => 1,
                ]);
            }
        }

        $order->update(['status' => 'completed']);

        \Mail::to($order->email)->send(new \App\Mail\OrderConfirmation($order));
        \Mail::to('orders@speakeasytelecom.com')->send(new \App\Mail\OrderConfirmation($order));

        exit;
    }

    public function failed(Request $request)
    {
        $order = $this->postPayProcess($request);

        if (! ($order->user_id == $this->user->id && $order->status == 0)) {
            return abort(404);
        }
        $user = Auth::User();
        $user->cart = null;
        $user->save();
        $order->status = 'failed';
        $order->save();

        return view('ecom.complete')->with([
            'order' => $order,
            'subHeader' => 'Order Failed',
        ]);
    }
}
