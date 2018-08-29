<?php

namespace App\Http\Controllers;

use DB;

class TestController extends Controller
{
  public function test()
  {
    return DB::table('locations')->whereNotNull('test_column_0')->limit(10)->toSql();
  }
}
