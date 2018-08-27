<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Locations extends BaseRepository
{
  public function create($areaId)
  {
    $id = DB::table('locations')->insertGetId([
      'area_id' => $areaId
    ]);

    return (array) $this->search([
      'id' => $id,
      'area_id' => $areaId
    ])[0];
  }

  public function upload($areaId, $header, $unique, $data, $conflict)
  {
    Facades\Common::upload("locations");
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

  public function search($params = [])
  {
    $columns = Facades\Columns::search(['area_id' => $params['area_id']]);
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
}
