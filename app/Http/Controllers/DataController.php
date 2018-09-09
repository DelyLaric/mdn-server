<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Data;

class DataController extends Controller
{
  public function create()
  {
    $table = $this->get('table', 'required');
    $categroyId = $this->get('categroyId', 'required');

    $id = DB::table($table)->insertGetId(['categroy_id' => $categroyId]);

    return (array) Data::search([
      'id' => $id,
      'table' => $table
    ])[0];
  }

  public function search()
  {
    $params = $this->via([
      'table' => 'required',
      'categroyId' => 'required',
      'format' => 'required',
      'query' => 'nullable'
    ]);

    $params['categroy_id'] = $params['categroyId'];

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
    $table = $this->get('table', 'required');

    DB::table($table)->whereIn('id', $ids)->delete();

    return success_response('数据已更新');
  }
}
