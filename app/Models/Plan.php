<?php

namespace App\Models;

use App\GlobalGig\GlobalPlan;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $guarded = [];

    protected $appends = [
        'formatted_countries',
        'pricing',
    ];

    public static function sync()
    {
        $plans = GlobalPlan::get();

        foreach ($plans as $plan) {
            Plan::firstOrCreate(
                ['gg_id' => $plan->id],
                [
                    'name' => $plan->name, 'desc' => $plan->description, 'duration' => $plan->duration, 'rate' => $plan->bundles[0]->rate, 'quota' => $plan->bundles[0]->byteQuota * 1024]
            );
        }
    }

    public function getCountriesAttribute($countries)
    {
        return json_decode($countries);
    }

    public function scopeSearch($query, $search)
    {
        $query->orWhere([
            ['name', 'Like', "%{$search}%"],
        ]);

        $countries = Country::where('name', 'LIKE', "%{$search}%")->pluck('id');

        foreach ($countries as $country) {
            $query->orWhereJsonContains('countries', $country);
        }

        return $query;
    }

    public function scopeFilterCredit($query, $values)
    {
        if (! $values) {
            return $query;
        }
        $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                if ($value) {
                    $query->orWhere('credit', $value);
                }
            }
        });

        return $query;
    }

    public function getPricingAttribute()
    {
        if ($this->fixed_price) {
            return $this->rate;
        }

        return (new Pricing())->get($this) ?? $this->rate;
    }

    public function scopeFilterCountry($query, $value)
    {
        if ($value && $value != 'all') {
            $query->where(function ($query) use ($value) {
                return $query->where('countries', 'like', '%"'.$value.'"%');
            });
        } else {
            $query->where('hybrid', 1)->orWhere('featured', 1);
        }
        $query->orderBy('hybrid', 'ASC');

        return $query;
    }

    public function scopeFilterRate($query, $value)
    {
        if (! $value) {
            return $query;
        }
        $query->where(function ($query) use ($value) {
            if ($value != 'all') {
                $query->whereBetween('rate', explode('-', $value));
            }
        });

        return $query;
    }

    public function getCountries()
    {
        if ($this->countries) {
            return Country::whereIn('id', $this->countries)->orderBy('name')->get();
        }

        return [];
    }

    public function getNetworks()
    {
        $networks = [];
        foreach ($this->getCountries() as $country) {
            if ($country->operators) {
                foreach (json_decode($country->operators) as $operator) {
                    $networks[] = ['country' => $country->name, 'name' => $operator->name];
                }
            }
        }

        return $networks;
    }

    public function getFormattedCountriesAttribute()
    {
        $html = '';
        foreach ($this->getCountries() as $country) {
            $html .= "<img src='/media/{$country->icon}' title='{$country->name}' class='w-25px mr-1 mb-1'>";
        }

        return $html;
    }

    public function getOperatorsAttribute($operators)
    {
        return json_decode($operators);
    }

    public function getBicsIdAttribute($ids)
    {
        return json_decode($ids);
    }

    public function getCountriesIconsAttribute()
    {
        $icons = [];
        foreach ($this->countries as $country) {
            $icons[] = Country::find($country)->icon;
        }

        return $icons;
    }
}
