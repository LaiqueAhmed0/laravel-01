<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    protected $guarded = [];

    public function getCountryNameAttribute()
    {
        return Country::find($this->country)->name;
    }

    public function sims()
    {
        return $this->hasMany(Sim::class);
    }

    public function getTotalSimsAttribute()
    {
        return $this->sims->count();
    }

    public function getTotalUnclaimedAttribute()
    {
        return $this->sims->whereNull('user_id')->count();
    }

    public function getTotalClaimedAttribute()
    {
        return $this->sims->whereNotNull('user_id')->count();
    }

    public function getTotalCombinedUsageAttribute()
    {
        $total = 0;

        foreach ($this->sims as $sim) {
            $total += (float) str_replace(',', '', $sim->volume);
        }

        return $total;
    }

    public function getTotalCombinedUsageRemainingAttribute()
    {
        $total = 0;
        foreach ($this->sims as $sim) {
            $total += (float) str_replace(',', '', $sim->volume_remaining);
        }

        return $total;
    }
}
