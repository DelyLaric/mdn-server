<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Tasks;

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

    $result = DB::select("
      select
        a.area_id, a.task_id,
        coalesce(row_to_json(l.*), '{}') as location
      from task_areas as a
      left join locations as l on
        l.area_id = ? and l.location_id = a.location_id
      where a.task_id = ? and a.area_id = ?
    ", [$params['areaId'], $params['taskId'], $params['areaId']])[0];

    $result->location = json_decode($result->location);
    return (array) $result;
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
