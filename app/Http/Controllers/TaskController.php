<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Tasks;

class TaskController extends Controller
{
  public function create()
  {
    $projectId = $this->get('projectId', 'required');

    $id = DB::table('tasks')->insertGetId([
      'project_id' => $projectId
    ]);

    return (array) DB::table('tasks')->where('id', $id)->get()[0];
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    DB::table('tasks')->where('id', $params['id'])->delete();

    return success_response('任务已删除');
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

  public function updatePart()
  {
    $taskId = $this->get('id', 'required');
    $partId = $this->get('partId', 'nullable');

    DB::table('tasks')->where('id', $taskId)->update(['part_id' => $partId]);

    return 'ok';
  }

  public function updateLine()
  {
    $taskId = $this->get('id', 'required');
    $lineId = $this->get('lineId', 'nullable');

    DB::table('tasks')->where('id', $taskId)->update(['line_id' => $lineId]);

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

  public function search()
  {
    $projectId = $this->get('projectId', 'nullable');

    $query = DB::table('tasks')
               ->select('tasks.*')
               ->orderBy('id', 'desc');

    if ($projectId !== null) {
      $query->where('project_id', $projectId);
    }

    return $query->paginate(50);
  }

  public function searchArea()
  {
    $search = $this->get('query', 'nullable');
    $areaId = $this->get('areaId', 'required');
    $taskId = $this->get('taskId', 'nullable');
    $projectId = $this->get('projectId', 'nullable');
    $taskStatus = $this->get('taskStatus', 'nullable');

    $query = DB::table('tasks')
      ->orderBy('tasks.id', 'desc')
      ->addSelect('tasks.*')
      ->addSelect(DB::raw('to_json(projects.*) as "project"'))
      ->addSelect(DB::raw('to_json(task_areas.*) as "taskArea"'))
      ->addSelect(DB::raw("coalesce(to_json(locations.*), '{}') as location"))
      ->leftJoin('projects', 'tasks.project_id', 'projects.id')
      ->leftJoin('task_areas', function ($join) use ($areaId) {
        $join->on('task_areas.task_id', 'tasks.id')
             ->where('task_areas.area_id', $areaId);
      })
      ->leftJoin('locations', function ($join) use ($areaId) {
        $join->on('locations.data_id', '=', 'task_areas.data_id')
             ->where('locations.categroy_id', $areaId);
      })
      ->whereNotNull('task_areas.task_id');

    if ($projectId !== null) {
      $query->where('tasks.project_id', $projectId);
    }

    if ($search !== null) {
      $query->where(function ($query) use ($search) {
        foreach ([
          'tasks.part_id',
          'tasks.line_id',
          'tasks.comment',
          'locations.data_id',
          DB::raw("to_char(tasks.project_id, '')")
        ] as $field) {
          $query->orWhere($field, 'like', "%$search%");
        }
      });
    }

    if ($taskId !== null) {
      $query->where('tasks.id', $taskId);
    }

    if ($taskStatus !== null) {
      $query->where('tasks.status', $taskStatus);
    }

    $result = $query->paginate(50)->toArray();

    foreach ($result['data'] as $item) {
      $item->project = json_decode($item->project);
      $item->location = json_decode($item->location);
      $item->taskArea = json_decode($item->taskArea);
    }

    return $result;
  }
}
