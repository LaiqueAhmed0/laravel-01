<?php

namespace App\Facades\Bics;

use Illuminate\Support\Facades\Facade;

class Import extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'bics_import';
    }
}
