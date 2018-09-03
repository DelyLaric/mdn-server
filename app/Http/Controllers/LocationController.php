<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Locations;

class LocationController extends Controller
{
  public function create()
  {
    $areaId = $this->via([
      'areaId' => 'required'
    ])['areaId'];

    $id = DB::table('locations')->insertGetId([
      'area_id' => $areaId
    ]);

    // area_id 用于确定 location 所拥有的 columns
    return (array) Locations::search([
      'id' => $id,
      'area_id' => $areaId
    ])[0];
  }

  public function search()
  {
    $params = $this->via([
      'areaId' => 'required|exists:areas,id',
      'format' => 'required',
      'query' => 'nullable'
    ]);

    // 待商榷的 areaId 参数
    $params['area_id'] = $params['areaId'];

    return Locations::search($params);
  }

  public function update()
  {
    $items = $this->via([
      'items' => 'required|array'
    ])['items'];

    foreach ($items as $item) {
      $params = [];
      foreach ($item['fields'] as $field) {
        $params[$field['name']] = $field['value'];
      }

      DB::table('locations')->where(
        'id', $item['id']
      )->update($params);
    }

    return success_response('区域数据已更新');
  }

  public function destroy()
  {
    $ids = $this->via([
      'ids' => 'array|required'
    ])['ids'];

    DB::table('locations')->whereIn('id', $ids)->delete();

    return success_response('区域数据已删除');
  }
}
