<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Data;

class CommonController extends Controller
{
  public function upload()
  {
    $params = $this->via([
      'table' => 'required',
      'header' => 'array',
      'unique' => 'array',
      'data' => 'array',
      'conflict' => 'string',
    ]);

    return success_response([
      'message' => '数据已上传',
      'data' => call_user_func_array([Data::class, 'upload'], $params)
    ]);
  }
}
