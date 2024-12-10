<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $plan;

    private int|float $markup;

    private false|float $cost;

    private $currency;

    private $operators = [
        'Equal' => '==',
        'Not Equal' => '!=',
        'Greater Than' => '>',
        'Less Than' => '<',
    ];

    private $conditonAttrs = [
        'Cost' => 'rate',
        'Allowance' => 'length',
        'Validity' => 'length',
    ];

    public function get($plan)
    {
        $this->plan = $plan;
        $this->cost = $this->getCost();
        $this->markup = Setting::where('name', 'markup')->first()->value / 100;
        $this->currency = Setting::where('name', 'conversion')->first()->value;

        $pricings = $this->query()->where('countries', json_encode($this->plan->countries))->get();

        if (! count($pricings)) {
            // dd($this->plan->fixed_price);

            // if ($this->plan->fixed_price) {
            //     return ($this->plan->rate);
            // }

            return round(($this->cost + ($this->cost * $this->markup)) * $this->currency);
        }
        foreach ($pricings as $pricing) {
            $metConditions = collect(json_decode($pricing->conditions, true))->filter(function ($condition) {
                return collect($this->plan->first()->toArray())->where($this->conditonAttrs[$condition['attribute']], $this->operators[$condition['operator']], $condition['value'])->count();
            });
            if (count($metConditions) == count(json_decode($pricing->conditions, true))) {
                $this->markup = ($pricing->toArray()['markup'] / 100);
            }
        }

        // dd($this->plan->fixed_price);

        // if ($this->plan->fixed_price) {
        //     return ($this->plan->rate);
        // }

        return round(($this->cost + ($this->cost * $this->markup)) * $this->currency);
    }

    public function getCost()
    {
        $countries = Country::whereIn('id', $this->plan->countries)->get();

        if ($countries) {
            $pricePerMb = $countries->max('price_per_mb');

            return $pricePerMb * ($this->plan->credit) * 100;
        }

        return false;
    }
}
