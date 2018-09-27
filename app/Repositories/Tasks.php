<?php

namespace App\Repositories;

use DB;
use Transaction;

class Tasks extends BaseRepository
{
  public function getPlantIdByTaskId($id)
  {
    return DB::select("select plant_id from projects where id = (select project_id from tasks where tasks.id = $id)")[0]->plant_id;
  }
}
