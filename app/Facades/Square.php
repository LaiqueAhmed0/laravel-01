<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Square extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'square';
    }
}
