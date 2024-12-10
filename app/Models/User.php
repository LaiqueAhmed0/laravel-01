<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'country_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    public function endpoint()
    {
        return $this->hasMany(Endpoint::class);
    }

    public function sims()
    {
        return $this->hasMany(Sim::class);
    }

    public function retailer()
    {
        return $this->belongsTo(Retailer::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getCountryNameAttribute()
    {
        $country = Country::where('iso', $this->country);

        if ($country->exists()) {
            return $country->first()->name;
        }

        return 'No Country';
    }

    public function admin()
    {
        return $this->group == 3 ? true : false;
    }

    public function getRetailer()
    {
        if ($this->retailer_id) {
            return Retailer::find($this->retailer_id) ?? false;
        }

        return false;
    }

    public function settings()
    {
        return $this->hasMany(UserSettings::class);
    }
}
