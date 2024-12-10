<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'countries_count',
    ];

    public function getCountriesCountAttribute(): int
    {
        return count($this->countries);
    }

    public function getCountriesAttribute($value)
    {
        return Country::whereIn('id', json_decode($value))->get();
    }

    public function getMinCostAttribute()
    {
        return $this->countries->min('price_per_mb');
    }

    public function getMaxCostAttribute()
    {
        return $this->countries->max('price_per_mb');
    }

    public function getAvgCostAttribute()
    {
        return round($this->countries->avg('price_per_mb'), 4);
    }
}
