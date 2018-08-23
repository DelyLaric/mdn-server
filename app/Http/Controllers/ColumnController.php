<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Columns;

class ColumnController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'name' => 'required|unique:area_columns,name',
      'text' => 'required',
      'comment' => 'nullable'
    ]);

    return success_response([
      'message' => '流程字段已创建',
      'data' => Columns::create(
        $params['name'], $params['text'], $params['comment']
      )
    ]);
  }

  public function delete($column)
  {
    Columns::delete($column);

    return success_response('流程字段已删除');
  }

  public function updateName($column)
  {
    $name = $this->via([
      'name' => 'required|unique:area_columns,name'
    ])['name'];

    Columns::updateName($column, $name);

    return success_response('流程属性字段已修改');
  }

  public function updateText($column)
  {
    $text = $this->via([
      'text' => 'required|unique:area_columns,name'
    ])['text'];

    Columns::updateText($column, $text);

    return success_response('流程属性显示名已修改');
  }

  public function updateComment($column)
  {
    $comment = $this->via([
      'comment' => 'required|unique:area_columns,name'
    ])['comment'];

    Columns::updateComment($column, $comment);

    return success_response('流程属性备注已修改');
  }

  public function search()
  {
    return columns::search();
  }
}
