<?php

namespace App\Livewire;

use App\Models\Country;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CustomPlanBuilder extends Component
{
    public $countries = [];

    public $data = 1;

    public $length = 60;

    public $iccid = null;

    public $rate = 0;

    private $markup = .25;

    private $curreny = 0.90;

    private $pricePerDay = 3;

    public $date = 0;

    protected $listeners = [
        'countriesUpdated' => 'countriesSelectUpdated',
        'iccidUpdated' => 'iccidSelectUpdated',
        'dateUpdated' => 'dateUpdated',
    ];

    public function dateUpdated($value)
    {
        $this->date = $value;
    }

    public function mount()
    {
        $this->markup = Setting::where('name', 'markup')->value('value') / 100;
        $this->curreny = Setting::where('name', 'conversion')->value('value');

        $this->iccid = Auth::user()->sims()->value('iccid');
    }

    public function render()
    {
        return view('livewire.custom-plan-builder');
    }

    public function countriesSelectUpdated($countries)
    {

        $this->countries = $countries;
        $this->calc();
    }

    public function iccidSelectUpdated($iccid)
    {
        $this->iccid = $iccid;
        $this->calc();
    }

    public function calc()
    {
        if (! (count($this->countries) && $this->iccid && $this->data > 0 && $this->data < 10024 && $this->length > 0 && $this->length < 731)) {
            return;
        }
        $countries = Country::whereIn('id', $this->countries)->get();

        if ($countries) {
            $pricePerMb = $countries->max('price_per_mb');
            $this->rate = round($pricePerMb * ($this->data * 1000) * 100);
            if ($this->length > 60) {
                $costForDays = $this->pricePerDay * ($this->length - 60);
            } else {
                $costForDays = 0;
            }

            $this->rate = ($this->rate + ($this->rate * $this->markup)) * $this->curreny;
            $this->rate = ($this->rate + $costForDays);
        }
    }

    public function updated()
    {
        $this->calc();
    }

    public function addToCart()
    {
        if (! (count($this->countries) && $this->iccid && $this->data > 0 && $this->length > 0 && $this->rate)) {
            return;
        }
        $user = Auth::user();
        $cart = json_decode($user->cart, true);

        $countries = Country::whereIn('id', $this->countries)->get();

        $countriesTitle = implode(', ', $countries->pluck('name')->toArray());

        $plan = Plan::firstOrCreate([
            'countries' => json_encode($this->countries),
            'type' => 'customer',
            'credit' => ($this->data * 1000),
            'length' => $this->length,
            'hybrid' => 0,
            'fixed_price' => true,
            'rate' => $this->rate,
            'name' => $this->data.'GB Data Plan - '.$countriesTitle,
        ]);
        $cart[] = [
            'iccid' => $this->iccid,
            'plan_id' => $plan->id,
            'quantity' => 1,
            'scheduled' => $this->date,
        ];

        $user->cart = $cart;
        $user->save();

        $this->dispatch('cartRefresh');
    }
}
