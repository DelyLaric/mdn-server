<?php

namespace App\Repositories;

use DB;

class Data extends BaseRepository
{
  /**
   *
   * object like params
   * @param string table
   * @param string categroyId
   * @param string query
   *
   */

  public function search($params = [])
  {
    $table = $params['table'];

    $columns = Facades\Columns::search(['table' => $table]);
    $selects = [];
    foreach ($columns as $column) {
      $selects[] = $column->name;
    }

    $query = DB::table($table);
    $query->orderByRaw("data_id is null desc, id desc");
    $query->select(array_merge(['id'], $selects));

    if (isset($params['categroy_id'])) {
      $query->where('categroy_id', $params['categroy_id']);
    }

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

    if (!isset($params['format'])) $params['format'] = 'normal';
    switch ($params['format']) {
      case 'array':
        return Serialize\Locations::getArray($query->get());
      case 'normal':
        return $query->get();
      case 'paginate':
        return Serialize\Pagination::getResource($query->paginate(50));
    }
  }

  public function upload($table, $fields, $uniqueField, $values, $conflict)
  {
    // 减少数据了，增强开发体验
    // $values = array_chunk($values, 10)[0];
    $this->transValues($values);
    $table = $this->transTableName($table);
    $unique = $this->transUniqueKey($uniqueField);
    $columns = $this->transHeader($fields);
    $updateSetter = $this->transUpdateFieldValue($fields);

    if (sizeof($uniqueField)) {
      if ($conflict === 'update') {
        $handleConflict = "do update set $updateSetter ";
      } else {
        $handleConflict = 'do nothing ';
      }

      $data = DB::select(
        "insert into $table $columns ".
        "values $values on conflict ($unique)".
        $handleConflict . "returning id, $unique"
      );

      return array_map(function ($item) use ($uniqueField) {
        $date = [];
        foreach ($uniqueField as $key) {
            $data[] = $item->$key;
        }
        return $data;
      }, $data);
    } else {
      $result = DB::select(
        "insert into $table $columns ".
        "values $values returning id"
      );

      return $result;
    }
  }

  public function transTableName (&$name)
  {
    $name = explode('.', $name);
    $name = '"' . implode('"."', $name) . '"';

    return $name;
  }

  public function transUniqueKey($columns)
  {
    return '"' . implode('","', $columns) . '"';
  }

  public function transHeader($header)
  {
    return '("' . implode('","', $header) . '")';
  }

  public function transValues (&$values)
  {
    if (!is_array($values[0])) {
      $values = [$values];
    }

    foreach ($values as &$item) {
      $item = '(\'' . implode('\',\'', $item) . '\')';
    }

    $values = implode(', ', $values);
  }

  public function transUpdateFieldValue($fields)
  {
    return '"' . implode('","', array_map(function ($field) {
      return $field . '"' . ' = ' . 'EXCLUDED."' . $field;
    }, $fields)) . '"';
  }
}
