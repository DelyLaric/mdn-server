<?php

namespace App\Repositories\Serialize;

class Area
{
  public static function getResource($data)
  {
    $result = ['result' => [], 'data' => []];

    foreach ($data as $datum) {
      $result['result'][] = $datum->id;

      $datum->columns = [
        'result' => array_decode($datum->column_ids),
        'data' => json_decode($datum->columns)
      ];

      unset($datum->column_ids);

      $result['data'][$datum->id] = $datum;
    }

    return $result;
  }
}
