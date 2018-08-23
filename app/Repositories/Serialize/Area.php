<?php

namespace App\Repositories\Serialize;

class Area
{
  public static function getResource(&$data)
  {
    $result = ['result' => [], 'data' => []];
    foreach ($data as &$datum) {
      $datum->column_ids = array_decode($datum->column_ids);
    }

    return $data;
  }
}
