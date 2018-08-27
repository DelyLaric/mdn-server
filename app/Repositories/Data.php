<?php

namespace App\Repositories;

use DB;

class Data extends BaseRepository
{
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