<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Columns;

class ColumnController extends Controller
{
  public function search()
  {
    return columns::search();
  }

  public function create()
  {
    $params = $this->via([
      'name' => 'required',
      'text' => 'required',
      'comment' => 'nullable',
      'table' => 'required'
    ]);

    return success_response([
      'message' => '属性已创建',
      'data' => Columns::create(
        $params['name'], $params['text'], $params['comment'], $params['table']
      )
    ]);
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required',
      'pivot' => 'required',
      'column' => 'nullable'
    ]);

    Columns::destroy($params['id'], $params['pivot']);

    return success_response('流程字段已删除');
  }

  public function updateName()
  {
    $params = $this->via([
      'id' => 'required',
      'name' => 'required',
      'table' => 'required'
    ]);

    Columns::updateName($params['id'], $params['name'], $params['table']);

    return success_response('流程属性字段已修改');
  }

  public function updateText()
  {
    $params = $this->via([
      'id' => 'required',
      'text' => 'required'
    ]);

    DB::table('columns')->where('id', $params['id'])->update([
      'text' => $params['text']
    ]);

    return success_response('流程属性显示名已修改');
  }

  public function updateComment()
  {
    $params = $this->via([
      'id' => 'required',
      'comment' => 'required'
    ]);

    DB::table('columns')->where('id', $params['id'])->update([
      'comment' => $params['comment']
    ]);

    return success_response('流程属性备注已修改');
  }
}
