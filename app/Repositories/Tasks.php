<?php

namespace App\Repositories;

use DB;
use Transaction;

class Tasks extends BaseRepository
{
  public function search($params = [])
  {
    $query = DB::table('tasks')
               ->select('tasks.*')
               ->orderBy('id', 'desc');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['project_id'])) {
      $projectId = $params['project_id'];
      $query->where('project_id', $params['project_id']);
      $plantId = DB::select("
        select plant_id from projects where id = $projectId
      ")[0]->plant_id;
    }

    return $query->get();
  }

  public function getPlantIdByTaskId($id)
  {
    return DB::select("select plant_id from projects where id = (select project_id from tasks where tasks.id = $id)")[0]->plant_id;
  }
}
