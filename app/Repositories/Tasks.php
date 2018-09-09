<?php

namespace App\Repositories;

use DB;
use Transaction;

class Tasks extends BaseRepository
{
  public function search($params = [])
  {
    $query = DB::table('tasks')
               ->orderBy('id', 'desc');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['project_id'])) {
      $projectId = $params['project_id'];
      $query->where('project_id', $params['project_id']);
      $categroyId = DB::select("
        select plant_id from projects where id = $projectId
      ")[0]->plant_id;
    }

    $query->addSelect('tasks.*');
    $query->addSelect(DB::raw("
      coalesce((
        select to_json(parts.*) from parts
        where parts.data_id = tasks.part_id
        and parts.categroy_id = $categroyId
      ), '{}') as part
    "));
    $query->addSelect(DB::raw("
      (
        select coalesce(jsonb_object_agg(areas.area_id, areas.*), '{}') from (
          select
            a.area_id, a.data_id,
            (
              select coalesce(to_json(l.*), '{}') from locations as l
              where l.categroy_id = a.area_id and l.data_id = a.data_id
            ) as location
          from task_areas as a
          where a.task_id = tasks.id
        ) as areas
      ) as areas
    "));

    $result = $query->get();
    return Serialize\Tasks::getResource($result);
  }

  public function getPlantIdByTaskId($id)
  {
    return DB::select("select plant_id from projects where id = (select project_id from tasks where tasks.id = $id)")[0]->plant_id;
  }
}
