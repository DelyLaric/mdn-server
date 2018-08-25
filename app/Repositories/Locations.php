<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Locations extends BaseRepository
{
  public function create($areaId, $locationId, $data)
  {
    $data['area_id'] = $areaId;
    $data['location_id'] = $locationId;

    $id = DB::table('locations')->insertGetId($data);

    return $id;
  }

  public function delete($ids)
  {
    DB::table('locations')->whereIn('id', $ids)->delete();
  }

  public function update($items)
  {
    if (!is_array($items)) {
      $items = [$items];
    }

    foreach ($items as $item) {
      $params = [];
      foreach ($item['fields'] as $field) {
        $params[$field['name']] = $field['value'];
      }

      DB::table('locations')->where(
        'id', $item['id']
      )->update($params);
    }
  }

  public function search($params)
  {
    $query = DB::table('locations')->orderBy('id', 'desc');
    $query->where('area_id', $params['areaId']);

    $columns = Facades\Columns::search(['area_id' => $params['areaId']]);
    $selects = $columns->map(function ($column) {
      return $column->name;
    })->toArray();
    $query->select(array_merge(['id', 'area_id', 'location_id'], $selects));

    if (!isset($params['format'])) $params['format'] = 'paginate';
    switch ($params['format']) {
      case 'array':
        return Serialize\Locations::getArray($query->get());
      case 'paginate':
        return Serialize\Pagination::getResource($query->paginate(50));
    }
  }
}
