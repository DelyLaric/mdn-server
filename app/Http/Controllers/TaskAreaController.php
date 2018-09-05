<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\TaskAreas;

class TaskAreaController extends Controller
{
  public function add()
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

  public function remove()
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
}
