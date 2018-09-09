<?php

namespace App\Repositories\Serialize;

class Tasks
{
  public static function getResource(&$data)
  {
    foreach ($data as &$datum) {
      $datum->part = json_decode($datum->part);
      $datum->areas = json_decode($datum->areas);
    }

    return $data;
  }
}
