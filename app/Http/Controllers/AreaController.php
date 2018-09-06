<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Areas;

class AreaController extends Controller
{
  public function search()
  {
    return Areas::search();
  }

  public function create()
  {
    $params = $this->via([
      'plantId' => 'required',
      'name' => 'required',
      'text' => 'required',
      'comment' => 'nullable',
      'columns' => 'array'
    ]);

    $params['plant_id'] = $params['plantId'];
    $params['columns'] = array_encode($params['columns']);
    unset($params['plantId']);
    unset($params['columns']);

    $id = DB::table('areas')->insertGetId($params);

    return success_response([
      'message' => '流程区域已创建',
      'data' => Areas::search(['id' => $id])[0]
    ]);
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    DB::table('areas')->where('id', $params['id'])->delete();

    return success_response('流程区域已删除');
  }

  public function updateName()
  {
    $params = $this->via([
      'id' => 'required',
      'name' => 'required'
    ]);

    DB::table('areas')->where('id', $params['id'])->update(['name' => $params['name']]);

    return success_response('流程区域信息已修改');
  }

  public function updateText()
  {
    $params = $this->via([
      'id' => 'required',
      'text' => 'required'
    ]);

    DB::table('areas')->where('id', $params['id'])->update(['text' => $params['text']]);

    return success_response('流程区域信息已修改');
  }

  public function updateComment()
  {
    $params = $this->via([
      'id' => 'required',
      'comment' => 'required'
    ]);

    DB::table('areas')->where('id', $params['id'])->update(['comment' => $params['comment']]);

    return success_response('流程区域信息已修改');
  }

  public function updateColumns()
  {
    $params = $this->via([
      'id' => 'required',
      'columns' => 'required'
    ]);

    DB::table('areas')->where('id', $params['id'])->update([
      'columns' => array_encode($params['columns'])
    ]);

    return success_response('流程区域信息已修改');
  }
}
