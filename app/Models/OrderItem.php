<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];

    public function getPlan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id')->first();
    }

    public function getImageAttribute($value)
    {
        return $this->getPlan()->image;
    }

    public function getIccidAttribute($value)
    {
        return $this->sim->iccid ?? 'N/A';
    }

    public function getNameAttribute($value)
    {
        return $this->getPlan()->name ?? 'N/A';
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function sim()
    {
        return $this->belongsTo(Sim::class);
    }
}
