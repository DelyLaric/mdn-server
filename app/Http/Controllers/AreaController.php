<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Area;

class AreaController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'plantId' => 'required',
      'name' => 'required',
      'text' => 'required',
      'comment' => 'nullable',
      'columns' => 'array'
    ]);

    $result = call_user_func_array([Area::class, 'create'], $params);

    return success_response([
      'message' => '流程区域已创建',
      'data' => $result
    ]);
  }

  public function delete($id)
  {
    Area::delete($id);

    return success_response('流程区域已删除');
  }

  public function updateName($id)
  {
    $name = $this->via([
      'name' => 'required'
    ])['name'];

    Area::updateName($id, $name);

    return success_response('流程区域信息已修改');
  }

  public function updateText($id)
  {
    $text = $this->via([
      'text' => 'required'
    ])['text'];

    Area::updateText($id, $text);

    return success_response('流程区域信息已修改');
  }

  public function updateComment($id)
  {
    $comment = $this->via([
      'comment' => 'required'
    ])['comment'];

    Area::updateComment($id, $comment);

    return success_response('流程区域信息已修改');
  }

  public function updateColumns($id)
  {
    $columns = $this->via([
      'columns' => 'required'
    ])['columns'];

    Area::updateColumns($id, $columns);

    return success_response('流程区域信息已修改');
  }

  public function getAreas()
  {
    return Area::getAreas();
  }
}
