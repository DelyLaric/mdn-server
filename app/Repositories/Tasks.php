<?php

namespace App\Repositories;

use DB;
use Transaction;

class Tasks extends BaseRepository
{
  public function search($params = [])
  {
    $query = DB::table('tasks')
               ->orderBy('status', 'asc')
               ->orderBy('id', 'desc');
    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['project_id'])) {
      $query->where('project_id', $params['project_id']);
    }

    return $query->get();
  }
}
