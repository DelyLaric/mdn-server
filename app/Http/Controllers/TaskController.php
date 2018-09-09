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

    return 200;
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
    $params = $this->via([
      'taskId' => 'required',
      'areaId' => 'required'
    ]);

    DB::table('task_areas')->insert([
      'task_id' => $params['taskId'],
      'area_id' => $params['areaId']
    ]);

    return 'ok';
  }

  public function removeArea()
  {
    $params = $this->via([
      'taskId' => 'required',
      'areaId' => 'required'
    ]);

    DB::table('task_areas')
      ->where('task_id', $params['taskId'])
      ->where('area_id', $params['areaId'])
      ->delete();

    return 'ok';
  }

  public function updateAreaData()
  {
    $params = $this->via([
      'taskId' => 'required',
      'areaId' => 'required',
      'locationId' => 'nullable'
    ]);

    DB::table('task_areas')
      ->where('task_id', $params['taskId'])
      ->where('area_id', $params['areaId'])
      ->update(['location_id' => $params['locationId']]);

    return (array) DB::table('locations')->where([
      'area_id' => $params['areaId'],
      'location_id' => $params['locationId']
    ])->get()->first();
  }
}
