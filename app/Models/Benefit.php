<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(\App\Models\Plan::class);
    }

    public function endpoint()
    {
        return $this->belongsTo(\App\Models\Endpoint::class);
    }
}
