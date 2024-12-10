<?php

use App\Models\Country;
use App\Models\Plan;
use App\Models\Setting;
use App\Models\Sim;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

if (! function_exists('getSim')) {
    function getSim($id)
    {
        return Sim::find($id);
    }
}

if (! function_exists('getPlanName')) {
    function getPlan($id)
    {
        return Plan::find($id);
    }
}

if (! function_exists('getPlanName')) {
    function getPlanName($id)
    {
        return getPlan($id)->name;
    }
}

if (! function_exists('getData')) {
    function getData(string $url)
    {
        $auth = getSetting('GG_token');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Authorization: '.$auth,
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo 'cURL Error #:'.$err;
        } else {
            return json_decode($response);
        }
    }
}

if (! function_exists('postData')) {
    function postData(string $url, $query)
    {
        $auth = getSetting('GG_token');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $query,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTPHEADER => [
                'Authorization: '.$auth,
                'content-type: application/json',
            ],
        ]);

        $response = curl_exec($curl);

        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            dd($err);
        } else {
            //            return '{"startDate":"2019-09-11T08:46:23.056Z","endDate":"1900-01-01T00:00:00.000Z","customerId":201238,"planId":278,"duration":30,"authorId":432,"updaterId":432,"deletedAt":"","alerts":{},"durationType":"days","id":244167,"created_at":"2019-09-11T08:46:23.056Z","updated_at":"2019-09-11T08:46:23.062Z"}';

            return $response;
        }
    }
}

if (! function_exists('getCartTotal')) {
    function getCartTotal($tax)
    {
        $cart = Session::get('cart');
        $plans = Plan::get();
        $total = 0;

        if (! $cart) {
            return number_format($total, 2);
        }
        foreach ($cart as $item) {
            $plan = $plans->where('id', $item['plan_id'])->first();
            $subtotal = round($plan->rate * $item['quantity'], 2);

            if ($tax) {
                $total += round($subtotal + (($subtotal / 100) * 20), 2);
            } else {
                $total += $subtotal;
            }
        }

        return number_format($total, 2);
    }
}

if (! function_exists('getCartSubtotal')) {
    function getCartSubtotal()
    {
        $cart = Session::get('cart');
        $plans = Plan::all();
        $subtotal = 0;

        if (! $cart) {
            return $subtotal;
        }
        foreach ($cart as $item) {
            $plan = $plans->where('id', $item['plan_id'])->first();
            $subtotal += round($plan->rate * $item['quantity'], 2);
        }

        return $subtotal;
    }
}
if (! function_exists('getTableMeta')) {
    function getTableMeta($request, $data)
    {
        $page = $request->pagination['page'];
        $perpage = $request->pagination['perpage'];
        $direction = $request->sort['sort'];
        $sortby = $request->sort['field'];

        $total = $data->count();
        $pages = (int) (ceil($total / $perpage));

        return [
            'meta' => [
                'page' => $page,
                'perpage' => $perpage,
                'total' => $total,
                'pages' => $pages,
            ],
        ];
    }
}

if (! function_exists('getSetting')) {
    function getSetting(string $name)
    {
        $setting = Setting::where('name', $name);
        if ($setting->exists()) {
            return $setting->first()->value;
        }

        return false;
    }
}

if (! function_exists('getCountry')) {
    function getCountry($code)
    {
        $country = Country::where('code', $code);
        if ($country->exists()) {
            return $country->first()->country;
        }

        return false;
    }
}

if (! function_exists('createTable')) {
    function createTable($request, $model, array $columns, ?array $queries = null, $sort = null, $dir = null)
    {
        if ($sort && $dir) {
            $model = $model->orderBy($sort, $dir);
        }

        if ($queries) {
            foreach ($queries as $query) {
                if ($query['query'] == 'whereIn') {
                    $model = $model->whereIn($query['column'], $query['value']);
                }
                if ($query['query'] == 'where') {
                    $model = $model->where($query['column'], $query['value']);
                }
            }
        }

        if ($request->query) {
            $search = $request->input('query');
            if (! empty($search[0])) {
                $table = $model->getTable();
                foreach ($columns as $column => $return) {
                    if (Schema::hasColumn($table, $column)) {
                        $model = $model->orWhere($column, 'LIKE', '%'.$search[0].'%');
                    }
                }
            }
        }

        $table = getTableMeta($request, $model);
        $table['data'] = [];
        $skip = ($table['meta']['page'] - 1) * $table['meta']['perpage'];
        $data = $model->skip($skip)->take($table['meta']['perpage'])->get();

        for ($i = 0; $i < count($data); $i++) {
            foreach ($columns as $column => $return) {
                if ($return == 'default') {
                    $table['data'][$i][$column] = $data[$i]->{$column};
                }
                if ($return == 'formatDate') {
                    $table['data'][$i][$column] = $data[$i]->{$column} ? date('d/m/Y', strtotime($data[$i]->{$column})) : null;
                }
                if (strpos($return, 'method:') !== false) {
                    $method = str_replace('method:', '', $return);
                    $table['data'][$i][$column] = $data[$i]->{$method}();
                }
            }
        }

        return $table;
    }
}
