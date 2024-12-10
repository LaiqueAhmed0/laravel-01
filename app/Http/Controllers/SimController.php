<?php

namespace App\Http\Controllers;

use App\Mail\AssignToUser;
use App\Models\Endpoint;
use App\Models\OrderItem;
use App\Models\Sim;
use App\Models\User;
use App\Rules\Luhn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SimController extends Controller
{
    protected $today;

    public function __construct()
    {
        $this->today = carbon::now();
    }

    public function registerView()
    {
        $data = [
            'subHeader' => 'Sim Card Registration',
            'breadcrumbs' => [
                [
                    'label' => 'Dashboard',
                    'link' => '/dashboard',
                ],
            ],
        ];

        return view('sim.register')->with($data);
    }

    public function switchEndpoint(Request $request, Sim $sim, Endpoint $endpoint)
    {
        $sim->switchEndpoint($endpoint);

        return back();
    }

    public function updateNickname(Request $request, Sim $sim)
    {
        $sim->update([
            'nickname' => $request->nickname,
        ]);

        return back();
    }

    public function updateScheduled(Request $request, OrderItem $orderItem)
    {
        $orderItem->update([
            'scheduled' => $request->scheduled,
        ]);

        return back();
    }

    public function mobility(Request $request)
    {
        Log::alert(print_r($request->all(), true));
    }

    public function remove(Request $request, Endpoint $endpoint)
    {
        $id = Auth::user()->id;

        if ($endpoint && $endpoint->user_id == $id) {
            $endpoint->user_id = null;
            $endpoint->save();
            Session::flash('swal', [
                'type' => 'success',
                'title' => 'Sim Deleted',
                'message' => 'The sim with the id of: '.$endpoint->iccid.' has been removed.',
            ]);
        } else {
            Session::flash('swal', [
                'type' => 'error',
                'title' => 'Sim Failed to Delete',
                'message' => 'The sim cannot be deleted.',
            ]);
        }

        return back();
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'iccid_first' => [
                'required',
                'integer',
                'confirmed',
            ],
            'iccid_end' => [
                'required',
                'integer',
                'confirmed',
            ],
            'iccid_luhn' => [
                'required',
                'integer',
                'confirmed',
            ],
        ]);

        $validator = Validator::make([$data['iccid_first'].$data['iccid_end'].$data['iccid_luhn']], [
            'required',
            new Luhn(),
        ]);

        $iccid = substr($validator->validate()[0], 0, -1);

        $sim = Sim::where('iccid', $iccid)->first();

        if (! $sim) {
            Session::flash('swal', [
                'type' => 'error',
                'title' => 'Sim Not Activated',
                'message' => 'The sim with the id of: '.$iccid.' is not active. Please speak to our team if this is incorrect.',
            ]);

            return back();
        }

        if ($sim->user_id !== null) {
            Session::flash('swal', [
                'type' => 'error',
                'title' => 'Sim Already Claimed',
                'message' => 'The sim with the id of: '.$iccid.' has already been claimed. Please speak to our team if this is incorrect.',
            ]);

            return back();
        }

        $sim->user_id = Auth::id();
        $sim->save();

        Session::flash('swal', [
            'type' => 'success',
            'title' => 'Sim Added',
            'message' => 'The sim with the id of: '.$iccid.' has been added.',
        ]);

        return redirect('/dashboard?sim='.$iccid);
    }

    public function unAssigned(Request $request)
    {
        $sims = Sim::where('retailer_id', null)->limit(30)->offset(($request->page ?? 0) * 30)->get();
        $data['results'] = [];
        foreach ($sims as $sim) {
            $data['results'][] = [
                'id' => $sim->id,
                'text' => $sim->iccid,
            ];
        }

        $data['pagination'] = [
            'more' => (count($data['results']) == 30),
        ];

        return response()->json($data);
    }

    public function get(Request $request)
    {
        $pagination = $request->input('pagination');
        $sims = Sim::query();

        if (! Route::currentRouteName() == 'admin.endpoints.get') {
            $id = Auth::user()->retailer_id;
            $sims->where('sims.retailer_id', $id);
        }

        $sims->leftJoin('users', 'users.id', '=', 'sims.user_id');
        $sims->leftJoin('retailers', 'retailers.id', '=', 'sims.retailer_id');

        if ($request->input('query') && isset($request->input('query')[0])) {
            $sims->where(function ($sims) use ($request) {
                $sims->orWhere('sims.id', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('sims.iccid', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('sims.serial_no', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('users.first_name', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('users.last_name', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('users.company_name', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('users.email', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('users.postcode', 'LIKE', "%{$request->input('query')[0]}%");
                $sims->orWhere('retailers.name', 'LIKE', "%{$request->input('query')[0]}%");

                return $sims;
            });
        }

        $sims->selectRaw('sims.*, CONCAT(users.first_name, " ", users.last_name) as claimed_by, retailers.name as retailer_name');
        $pagination['total'] = $sims->count();

        $sims->limit($pagination['perpage'])->skip(($pagination['page'] - 1) * $pagination['perpage']);

        $data = $sims->get();
        $return = [];
        foreach ($data as $item) {
            $return[] = $item->toArray();
        }

        return response()->json([
            'meta' => [
                'page' => $pagination['page'],
                'perpage' => $pagination['perpage'],
                'total' => $pagination['total'],
                'pages' => ceil($pagination['total'] / $pagination['perpage']),
            ],
            'data' => $return,
        ]);
    }

    public function removeClaimant(Request $request, Endpoint $endpoint)
    {
        $endpoint->user_id = null;
        $endpoint->save();

        $request->session()->flash('swal', [
            'title' => 'Claimant Removed',
            'message' => 'The claimant was removed from the sim: '.$endpoint->iccid,
            'type' => 'success',
        ]);

        return back();
    }

    public function removeRetailer(Request $request, Endpoint $endpoint)
    {
        $endpoint->retailer_id = null;
        $endpoint->save();

        $request->session()->flash('swal', [
            'title' => 'Retailer Removed',
            'message' => 'The retailer was removed from the sim: '.$endpoint->iccid,
            'type' => 'success',
        ]);

        return back();
    }

    public function send(Request $request)
    {
        $endpoint = Endpoint::find($request->endpoint);

        if (! $endpoint) {
            $request->session()->flash('swal', [
                'title' => 'Missing/Invalid Sim',
                'message' => 'Missing or invalid sim, speak to support.',
                'type' => 'error',
            ]);

            return back();
        }

        if (! $request->email) {
            $request->session()->flash('swal', [
                'title' => 'Missing/Invalid Email',
                'message' => 'Missing or invalid email for the following sim: '.$endpoint->iccid,
                'type' => 'error',
            ]);

            return back();
        }

        $user = User::where('email', $request->email);
        if ($user->exists()) {
            $endpoint->user_id = $user->first()->id;
        }

        $endpoint->assigned_to = $request->email;
        $endpoint->save();

        Mail::to($request->email)->send(new AssignToUser($endpoint->iccid));

        $request->session()->flash('swal', [
            'title' => 'Assigned Sim',
            'message' => $endpoint->iccid.' Has been assigned to the user: '.$request->email,
            'type' => 'success',
        ]);

        return back();
    }

    public function export()
    {
        $path = 'storage/export.csv';

        $file = fopen($path, 'w');

        fputcsv($file, [
            'Serial No',
            'Iccid',
            'Retailer',
            'Current Plan',
            'Claimed By',
        ]);

        foreach (Sim::all() as $sim) {
            fputcsv($file, [
                $sim->serial_no,
                $sim->iccid,
                $sim->retailer,
                $sim->current_plan_name,
                $sim->retailer_name,
            ]);
        }

        fclose($file);

        return Storage::download('public/export.csv');
    }

    public function addBenefit(Request $request, Sim $sim)
    {
        return view('admin.endpoints.add-plan')->with([
            'sim' => $sim,
        ]);
    }

    public function create()
    {
        return view('admin.endpoints.create');
    }

    public function delete()
    {
        return view('admin.endpoints.delete');
    }
}
