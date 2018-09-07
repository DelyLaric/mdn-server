<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Data;

class DataController extends Controller
{
  public function create()
  {
    $table = $this->get('table', 'required');
    $group = $this->get('group', 'required');
    $groupId = $this->get('groupId', 'required');
    $primary = $this->get('primary', 'required');

    $id = DB::table($table)->insertGetId([
      $group => $groupId
    ]);

    // area_id 用于确定 location 所拥有的 columns
    return (array) Data::search([
      'id' => $id,
      'table' => $table,
      'primary' => $primary
    ])[0];
  }

  public function search()
  {
    $params = $this->via([
      'table' => 'required',
      'primary' => 'required',
      'group' => 'required',
      'groupId' => 'required',
      'format' => 'required',
      'query' => 'nullable'
    ]);

    return Data::search($params);
  }

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

  public function update()
  {
    $table = $this->get('table', 'required');
    $items = $this->get('items', 'required|array');

    foreach ($items as $item) {
      $params = [];
      foreach ($item['fields'] as $field) {
        $params[$field['name']] = $field['value'];
      }

      DB::table($table)->where(
        'id', $item['id']
      )->update($params);
    }

    return success_response('区域数据已更新');
  }

  public function destroy()
  {
    $ids = $this->get('ids', 'required');

    DB::table('locations')->whereIn('id', $ids)->delete();

    return success_response('区域数据已删除');
  }
}
