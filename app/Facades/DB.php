<?php

namespace App\Facades;

use Illuminate\Support\Facades\DB as BaseDB;

class DB extends BaseDB
{
    public static function test()
    {
        return 'success to extend';
    }
}
