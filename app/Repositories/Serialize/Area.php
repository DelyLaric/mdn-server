<?php

namespace App\Repositories\Serialize;

class Area
{
  public static function getResource(&$data)
  {
    foreach ($data as &$datum) {
      $datum->columns = array_decode($datum->columns);
    }

    return $data;
  }
}
