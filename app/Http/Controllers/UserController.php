<?php

namespace App\Http\Controllers;

use App\Bics\Bics;
use App\Models\Endpoint;
use App\Models\Sim;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private function getUser($userID)
    {
        if ($userID) {
            return User::find($userID);
        }

        return Auth::user();
    }

    public function index()
    {
        return view('admin.users.index')->with([
            'subHeader' => 'Users Table',
        ]);
    }

    public function delete(User $user)
    {
        $user->delete();
        Session::flash('swal', [
            'type' => 'success',
            'title' => 'User Deleted',
            'message' => '',
        ]);

        return back();
    }

    public function export()
    {
        $path = 'storage/export.csv';

        $file = fopen($path, 'w');

        fputcsv($file, [
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Address',
            'Postcode',
            'Country',
        ]);

        foreach (User::all() as $user) {
            fputcsv($file, [
                $user->first_name,
                $user->last_name,
                $user->email,
                $user->phone,
                $user->address,
                $user->postcode,
                $user->country_name,
            ]);
        }

        fclose($file);

        return Storage::download('public/export.csv');
    }

    public function adminUpdate(Request $request, User $user)
    {
        $input = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => '',
            'tax_code' => '',
            'phone' => '',
            'email' => 'required',
            'address' => '',
            'address_2' => '',
            'city' => '',
            'county' => '',
            'postcode' => '',
            'country' => '',
            'password' => 'sometimes|confirmed',
            'group' => 'required',
            'retailer_id' => '',
        ]);

        if (! $input['password']) {
            unset($input['password'], $input['password_confirmation']);
        } else {
            $input['password'] = Hash::make($input['password']);
        }

        if ($user->update($input)) {
            Session::flash('swal', [
                'type' => 'success',
                'title' => 'User Updated',
                'message' => '',
            ]);

            return redirect('/admin/users');
        }
        Session::flash('swal', [
            'type' => 'error',
            'title' => 'Failed to update',
            'message' => '',
        ]);

        return back()->withErrors(['Cannot Update']);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'company_name' => '',
            'tax_code' => '',
            'phone' => '',
            'email' => 'required|unique:users',
            'address' => '',
            'address_2' => '',
            'city' => '',
            'county' => '',
            'postcode' => '',
            'country' => 'required',
            'password' => 'required|confirmed',
            'group' => 'required',
            'retailer_id' => '',
        ]);

        $input['password'] = Hash::make($input['password']);

        User::create($input);

        return redirect('/admin/users');
    }

    public function create()
    {
        return view('admin.users.form');
    }

    public function endpointsTable(Request $request)
    {
        $pagination = $request->input('pagination');

        $sims = Sim::where('sims.user_id', $request->id);
        $sims->leftJoin('users', 'users.id', '=', 'sims.user_id');
        $sims->selectRaw('sims.*, CONCAT(users.first_name, " ", users.last_name) as claimed_by');

        if ($request->input('query')) {
            $sims->where('sims.iccid', 'LIKE', "%{$request->input('query')[0]}%");
        }

        $pagination['total'] = $sims->count();

        $sims->limit($pagination['perpage'])->skip(--$pagination['page'] * $pagination['perpage']);
        $data = $sims->get()->toArray();

        return response()->json([
            'meta' => [
                'page' => $pagination['page'],
                'perpage' => $pagination['perpage'],
                'total' => $pagination['total'],
                'pages' => ceil($pagination['total'] / $pagination['perpage']),
            ],
            'data' => $data,
        ]);
    }

    public function show($user)
    {
        $data['user'] = User::find($user);
        $data['sims'] = $data['user']->getEndpoints();
        $data['subHeader'] = $data['user']->name.' Profile Page';
        $data['active'] = 'overview';

        return view('admin.users.view')->with($data);
    }

    public function sims(Request $request)
    {
        $data = new Endpoint();
        $data = $data->where('user_id', $request->user);

        $table = getTableMeta($request, $data);

        $skip = ($table['meta']['page'] - 1) * $table['meta']['perpage'];
        $data = $data->skip($skip)->limit($table['meta']['perpage'])->get();

        $table['data'] = $data;

        return response()->json($table);
    }

    public function profile()
    {
        return redirect('/profile/personal-information');
    }

    public function changePassword($userID = null)
    {
        $user = $this->getUser($userID);

        return view('user.change-password')->with([
            'user' => $user,
            'active' => 'change-password',
            'subHeader' => 'Profile Page',
        ]);
    }

    public function personal($userID = null)
    {
        $user = $this->getUser($userID);

        return view('user.personal')->with([
            'user' => $user,
            'active' => 'personal',
            'subHeader' => 'Profile Page',
        ]);
    }

    public function orders($userID = null)
    {
        $user = $this->getUser($userID);

        return view('user.orders')->with([
            'user' => $user,
            'active' => 'orders',
            'subHeader' => 'My Orders',
        ]);
    }

    public function edit(Request $request, User $user)
    {
        return view('admin.users.form')->with(['user' => $user, 'subHeader' => 'Edit User']);
    }

    public function notifications($userID = null)
    {
        $user = $this->getUser($userID);
        $settings = UserSettings::where('user_id', $user->id)->pluck('value', 'name')->toArray();

        return view('user.notifications')->with([
            'user' => $user,
            'settings' => $settings,
            'active' => 'notifications',
            'subHeader' => 'Profile Page',
        ]);
    }

    public function update(Request $request, $id = null)
    {
        $data = $request->all();
        unset($data['_token']);
        $user = $this->getUser($id);
        foreach ($data as $key => $value) {
            $user->{$key} = $value;
        }
        $user->save();
        Session::flash('swal', [
            'type' => 'success',
            'title' => 'Information Updated',
            'message' => 'Your personal information was successfully updated!',
        ]);

        return back();
    }

    public function updateSettings(Request $request, $id = null)
    {
        $data = $request->except(['_token']);
        UserSettings::where('user_id', Auth::id())->delete();
        foreach ($data as $key => $value) {
            UserSettings::create([
                'user_id' => Auth::id(),
                'name' => $key,
                'value' => $value,
            ]);
        }
        Session::flash('swal', [
            'type' => 'success',
            'title' => 'Settings Updated',
            'message' => 'Your settings were successfully updated!',
        ]);

        return back();
    }

    public function updatePassowrd(Request $request, $id = null)
    {
        $data = $request->validate([
            'current_password' => [
                'required',
                'string',
                'min:8',
                'max:20',
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
            ],
        ]);
        $user = $this->getUser($id);
        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Incorrect Password',
            ]);
        }
        User::find($id)->update([
            'password' => Hash::make($data['password']),
        ]);
        Session::flash('swal', [
            'type' => 'success',
            'title' => 'Password Updated',
            'message' => 'Your password was successfully updated!',
        ]);

        return back();
    }

    public function simUsage(Request $request, Bics $bics)
    {
        $piccid = $request->piccid;
        $sim = Endpoint::where('iccid', $piccid)->first();

        $data['usage'] = $bics->getStatistics($sim->bics_id);

        $data['usage'] =
            json_decode('{"smsUsage":[{"totalCost":"3","serviceName":"SMS_MO","date":"26/04/2020","totalCount":"3"},{"totalCost":"2","serviceName":"SMS_MO","date":"28/04/2020","totalCount":"2"}],"dataUsage":[{"totalCost":"0.473","date":"27/04/2020","uplink":"2.02","downlink":"21.65","totalVolume":"23.67"},{"totalCost":"0.237","date":"28/04/2020","uplink":"1.01","downlink":"10.82","totalVolume":"11.84"}],"smsTotalUsage":[{"totalCost":"5","serviceName":"SMS_MO","totalCount":"5"}],"dataTotalUsage":{"totalCost":"0.710","uplink":"3.03","downlink":"32.47","totalVolume":"35.50"}}');

        return response()->json($data);
    }

    public function table(Request $request)
    {
        $data = createTable($request, new User(), [
            'id' => 'default',
            'name' => 'default',
            'phone' => 'default',
            'postcode' => 'default',
            'group' => 'default',
            'email' => 'default',
            'created_at' => 'formatDate',
        ]);

        return response()->json($data);
        //        return response()->json($table);
    }
}
