<?php

namespace App\Models;

use App\Facades\Bics\Bics;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected $guarded = [];

    public function getVolumeFormattedAttribute()
    {
        return number_format($this->volume / 1024 / 1024, 2);
    }

    public function getCountryDetailsAttribute($country)
    {
        return Country::where('bics_id', $this->country)->first();
    }

    public function getDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    }

    public function getVolumeAttribute($value)
    {
        return abs($value);
    }

    public function getOperatorNameAttribute()
    {
        try {
            $destinations = Bics::getRoamingDestinations();
        } catch (\Exception $exception) {
            return 'N/A';
        }

        return collect($destinations->rows[0]->tadigList)->where('tadigCode', $this->operator)->first()->operatorName ?? 'N/A';
    }
}
