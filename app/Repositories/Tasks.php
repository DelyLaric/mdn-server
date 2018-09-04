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
      $query->where('project_id', $params['project_id']);
    }
    $query->addSelect('tasks.*');
    $query->addSelect(DB::raw("
      (
        select coalesce(jsonb_object_agg(areas.area_id, areas.*), '{}') from (
          select
            row_to_json(l.*) as location, a.area_id, a.location_id
          from task_areas as a
          left join locations as l on
            l.location_id = a.location_id and l.area_id = a.area_id
          where
            a.task_id = tasks.id
        ) as areas
      ) as areas
    "));

    $result = $query->get();
    return Serialize\Tasks::getResource($result);
  }

  public function getAreasByProjectId ($id)
  {
    $plantId = DB::select("select plant_id from projects where id = $id")[0]->plant_id;
    $areas = DB::select("select id, name from areas where plant_id = $plantId");
    return $areas;
  }
}
