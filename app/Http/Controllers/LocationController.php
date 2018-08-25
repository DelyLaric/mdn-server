<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Locations;

class LocationController extends Controller
{
  public function search()
  {
    $params = $this->via([
      'areaId' => 'required|exists:areas,id',
      'format' => 'required'
    ]);

    return Locations::search($params);
  }

  public function update()
  {
    $params = $this->via([
      'data' => 'required|array'
    ])['data'];

    Locations::update($params);

    return success_response('区域数据已更新');
  }

  public function delete()
  {
    $ids = $this->via([
      'ids' => 'array|required'
    ])['ids'];

    Locations::delete($ids);

    return success_response('区域数据已删除');
  }
}
