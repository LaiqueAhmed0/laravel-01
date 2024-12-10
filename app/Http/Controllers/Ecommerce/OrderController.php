<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function table(Request $request)
    {
        $user = Auth::user();
        $orders = Order::query();

        if ($user->group != 3) {
            $orders->where('email', $user->email);
        }

        $total = $orders->count();
        $pages = ceil($total / $request->pagination['perpage']);

        if (! $request->input('query')) {
            $orders = $orders->latest()->limit($request->pagination['perpage'])->offset($request->pagination['perpage'] * ($request->pagination['page'] - 1))->get();

            return [
                'meta' => [
                    'total' => $total,
                    'perpage' => $request->pagination['perpage'],
                    'page' => $request->pagination['page'],
                    'pages' => $pages,
                ],
                'data' => $orders->toArray(),
            ];
        }
        if (isset($request->input('query')[0])) {
            $orders->where(function ($orders) use ($request) {
                $orders->orWhere('id', 'LIKE', "%{$request->input('query')[0]}%");
                $orders->orWhere('first_name', 'LIKE', "%{$request->input('query')[0]}%");
                $orders->orWhere('last_name', 'LIKE', "%{$request->input('query')[0]}%");
                $orders->orWhere('company_name', 'LIKE', "%{$request->input('query')[0]}%");
                $orders->orWhere('email', 'LIKE', "%{$request->input('query')[0]}%");
                $orders->orWhere('postcode', 'LIKE', "%{$request->input('query')[0]}%");

                return $orders;
            });
        }
        if (isset($request->input('query')['from'])) {
            $orders->where('created_at', '>=', Carbon::createFromFormat('Y-m-d', $request->input('query')['from'])->startOfDay());
        }
        if (isset($request->input('query')['to'])) {
            $orders->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $request->input('query')['to'])->endOfDay());
        }

        $orders = $orders->latest()->limit($request->pagination['perpage'])->offset($request->pagination['perpage'] * ($request->pagination['page'] - 1))->get();

        return [
            'meta' => [
                'total' => $total,
                'perpage' => $request->pagination['perpage'],
                'page' => $request->pagination['page'],
                'pages' => $pages,
            ],
            'data' => $orders->toArray(),
        ];
    }

    public function invoice(Order $order)
    {
        return response()->view('ecom.invoice', [
            'order' => $order,
            'subHeader' => 'Invoice #'.$order->id,
            'back' => '/profile/orders/'.$order->id,
        ]);
    }

    public function export()
    {
        Order::all();
    }

    public function adminInvoice(Order $order)
    {
        return response()->view('ecom.invoice', [
            'order' => $order,
            'subHeader' => 'Invoice #'.$order->id,
            'back' => '/admin/orders/'.$order->id,
        ]);
    }

    public function adminStatus(Order $order, $status)
    {
        $order->status = $status;
        $order->save();

        return back();
    }

    public function adminView(Order $order)
    {
        return view('admin.orders.view')->with([
            'order' => $order,
            'subHeader' => 'Order',
            'back' => '/admin/orders',
        ]);
    }

    public function index(Request $request)
    {
        return response()->view('admin.orders.index');
    }

    public function show(Request $request, $id)
    {
        $user = Auth::user();
        $order = new Order();

        if (! $user->admin()) {
            $order = $order->where('email', $user->email);
        }

        $order = $order->where('id', $id);

        if (! $order->exists()) {
            return redirect('/profile/orders');
        }

        $order = $order->first();

        return view('user.orderDetails')->with([
            'order' => $order,
            'user' => $user,
            'active' => 'orders',
            'subHeader' => 'Order',
            'back' => '/profile/orders',
        ]);
    }
}
