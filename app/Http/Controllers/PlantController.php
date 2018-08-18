<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Plant;

class PlantController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'name' => 'required|unique:plants,name'
    ]);

    $name = $params['name'];

    return success_response([
      'message' => '工厂已创建',
      'data' => Plant::create($name)
    ]);
  }

  public function delete($name)
  {
    Plant::delete($name);

    return success_response('工厂已删除');
  }

  public function updateName($oldName)
  {
    $params = $this->via([
      'name' => 'required|unique:plants,name'
    ]);

    $name = $params['name'];

    Plant::update($oldName, ['name' => $name]);

    return success_response('工厂代码已更新');
  }

  public function search()
  {
    return Plant::search();
  }
}
