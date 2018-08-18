<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Area;

class AreaController extends Controller
{
  public function createColumn()
  {
    $params = $this->via([
      'name' => 'required|unique:area_columns,name',
      'text' => 'required',
      'comment' => 'nullable'
    ]);

    return success_response([
      'message' => '流程字段已创建',
      'data' => Area::createColumn(
        $params['name'], $params['text'], $params['comment']
      )
    ]);
  }

  public function deleteColumn($column)
  {
    Area::deleteColumn($column);

    return success_response('流程字段已删除');
  }

  public function getColumns()
  {
    return Area::getColumns();
  }

  public function createArea($plant)
  {
    $params = $this->via([
      'name' => 'required',
      'text' => 'required',
      'comment' => 'nullable',
      'columns' => 'array'
    ]);

    $params = array_merge(['plant' => $plant], $params);

    $result = call_user_func_array([Area::class, 'createArea'], $params);

    return success_response([
      'message' => '流程区域已创建',
      'data' => $result
    ]);
  }

  public function deleteArea($plant, $area)
  {
    Area::deleteArea($plant, $area);

    return success_response('流程区域已删除');
  }

  public function getAreas()
  {
    return Area::getAreas();
  }

  public function updateAreaColumns($plant, $area)
  {
    $columns = $this->via([
       'columns' => 'required|array'
    ])['columns'];

    Area::updateAreaColumns($plant, $area, $columns);

    return success_response('流程区域字段已修改');
  }
}
