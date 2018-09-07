<?php

namespace App\Repositories;

use DB;

class Plants extends BaseRepository
{

  public function search($params = [])
  {
    $query = DB::table('plants')->orderBy('id');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['name'])) {
      $query->where('name', $params['name']);
    }

    $datas = $query->get();
    foreach ($datas as &$data) {
      $data->part_columns = array_decode($data->part_columns);
    }

    return $datas;
  }
}
