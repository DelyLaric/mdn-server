<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Plant;

class PlantController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'code' => 'required|unique:plants,code'
    ]);

    $code = $params['code'];

    return success_response([
      'message' => '工厂已创建',
      'data' => Plant::create($code)
    ]);
  }

  public function delete($code)
  {
    Plant::delete($code);

    return success_response('工厂已删除');
  }

  public function updateCode($oldCode)
  {
    $params = $this->via([
      'code' => 'required|unique:plants,code'
    ]);

    $code = $params['code'];

    Plant::update($oldCode, ['code' => $code]);

    return success_response('工厂代码已更新');
  }

  public function search()
  {
    return Plant::search();
  }
}
