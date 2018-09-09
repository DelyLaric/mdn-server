<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Tasks;

class TaskController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'projectId' => 'required'
    ]);

    $id = DB::table('tasks')->insertGetId([
      'project_id' => $params['projectId']
    ]);

    return (array) Tasks::search(['id' => $id])[0];
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    DB::table('tasks')->where('id', $params['id'])->delete();

    return success_response('任务已删除');
  }

  public function search()
  {
    $params = $this->via([
      'projectId' => 'nullable'
    ]);

    $params['project_id'] = $params['projectId'];

    return Tasks::search($params);
  }

  public function updateComment()
  {
    $params = $this->via([
      'id' => 'required',
      'comment' => 'required'
    ]);

    DB::table('tasks')->where('id', $params['id'])->update([
      'comment' => $params['comment']
    ]);

    return 'ok';
  }

  public function updateStatus()
  {
    $params = $this->via([
      'id' => 'required',
      'status' => 'required'
    ]);

    DB::table('tasks')->where('id', $params['id'])->update([
      'status' => $params['status']
    ]);

    return 'ok';
  }

  public function updateDuetime()
  {
    $params = $this->via([
      'id' => 'required',
      'duetime' => 'nullable'
    ]);

    DB::table('tasks')->where('id', $params['id'])->update([
      'duetime' => $params['duetime']
    ]);

    return 'ok';
  }

  public function addArea()
  {
    $taskId = $this->get('taskId', 'required');
    $areaId = $this->get('areaId', 'required');

    DB::table('task_areas')->insert([
      'task_id' => $taskId,
      'area_id' => $areaId
    ]);

    return 'ok';
  }

  public function removeArea()
  {
    $taskId = $this->get('taskId', 'required');
    $areaId = $this->get('areaId', 'required');

    DB::table('task_areas')
      ->where('task_id', $taskId)
      ->where('area_id', $areaId)
      ->delete();

    return 'ok';
  }

  public function updateAreaData()
  {
    $taskId = $this->get('taskId', 'required');
    $areaId = $this->get('areaId', 'required');
    $dataId = $this->get('dataId', 'nullable');
    if ($dataId === '') $dataId = null;

    DB::table('task_areas')
      ->where('task_id', $taskId)
      ->where('area_id', $areaId)
      ->update(['data_id' => $dataId]);

    return (array) DB::table('locations')->where([
      'categroy_id' => $areaId,
      'data_id' => $dataId
    ])->get()->first();
  }
}
