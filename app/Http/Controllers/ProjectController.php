<?php

namespace App\Http\Controllers;

use App\Repositories\Facades\Projects;

class ProjectController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'plantId' => 'required',
      'name' => 'required',
      'text' => 'required',
      'comment' => 'nullable'
    ]);

    return success_response([
      'message' => '项目已创建',
      'data' => call_user_func_array([Projects::class, 'create'], $params)
    ]);
  }

  public function search()
  {
    $params = $this->via([
      'plantId' => 'nullable'
    ]);

    $params['plant_id'] = $params['plantId'];

    return Projects::search($params);
  }

  public function updateName()
  {
    $params = $this->via([
      'id' => 'required',
      'name' => 'required'
    ]);

    Projects::updateName($params['id'], $params['name']);

    return success_response('项目编号已修改');
  }

  public function updateText()
  {
    $params = $this->via([
      'id' => 'required',
      'text' => 'required'
    ]);

    Projects::updateText($params['id'], $params['text']);

    return success_response('项目编号已修改');
  }

  public function updateComment()
  {
    $params = $this->via([
      'id' => 'required',
      'comment' => 'required'
    ]);

    Projects::updateComment($params['id'], $params['comment']);

    return success_response('项目编号已修改');
  }

  public function file ()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    return success_response([
      'message' => '项目已归档',
      'data' => Projects::file($params['id'])
    ]);
  }

  public function reopen()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    Projects::reopen($params['id']);

    return success_response('项目已重新开启');
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    Projects::destroy($params['id']);

    return success_response('项目已删除');
  }
}
