<?php

namespace App\Repositories\Serialize;

class Locations
{
    public static function getArray($data)
    {
      $resource = [];

      foreach ($data as $datum) {
        unset($datum->id);
        unset($datum->area_id);
        $resource[] = array_values((array)$datum);
      }

      return $resource;
    }
}
