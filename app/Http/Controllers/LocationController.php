<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Locations;

class LocationController extends Controller
{
  public function create()
  {
    $areaId = $this->via([
      'areaId' => 'required'
    ])['areaId'];

    return Locations::create($areaId);
  }

  public function search()
  {
    $params = $this->via([
      'areaId' => 'required|exists:areas,id',
      'format' => 'required'
    ]);

    // 待商榷的 areaId 参数
    $params['area_id'] = $params['areaId'];

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
