<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];

    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }
}
