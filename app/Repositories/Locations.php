<?php

namespace App\Repositories;

use DB;
use Transaction;

class Locations extends BaseRepository
{
  /**
   * @param number $params['area_id'] required
   */

  public function search($params = [])
  {
    $columns = Facades\Columns::search(['table' => 'locations']);
    $selects = ['location_id'];

    foreach ($columns as $column) {
      $selects[] = $column->name;
    }

    $query = DB::table('locations')->orderBy('id', 'desc');
    $query->select(array_merge(['id', 'area_id'], $selects));

    $query->where('area_id', $params['area_id']);

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['query'])) {
      $param = $params['query'];
      $query->where(function ($query) use ($selects, $param) {
        foreach ($selects as $select) {
          $query->orWhere($select, 'like', "%$param%");
        }
      });
    }

    if (!isset($params['format'])) $params['format'] = 'object';
    switch ($params['format']) {
      case 'array':
        return Serialize\Locations::getArray($query->get());
      case 'object':
        return $query->get();
      case 'paginate':
        return Serialize\Pagination::getResource($query->paginate(50));
    }
  }

  public function upload($areaId, $header, $unique, $data, $conflict)
  {
    Facades\Common::upload("locations");
  }
}
