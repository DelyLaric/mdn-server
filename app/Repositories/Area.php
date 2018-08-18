<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Area extends BaseRepository
{
  public function createColumn($name, $text, $comment)
  {
    Transaction::begin();

    Schema::table('locations', function ($table) use ($name) {
      $table->string($name);
    });

    $id = DB::table('area_columns')->insertGetId([
      'name' => $name,
      'text' => $text,
      'comment' => $comment
    ]);

    Transaction::commit();

    return $this->getColumns(['id' => $id]);
  }

  public function deleteColumn($name)
  {
    Transaction::begin();

    Schema::table('locations', function ($table) use ($name) {
      $table->dropColumn($name);
    });

    $id = $this->getColumns(['name' => $name])[0]->id;
    DB::table('areas')->update(['column_ids' => DB::raw("array_remove(column_ids, $id)")]);
    DB::table('area_columns')->where('name', $name)->delete();

    Transaction::commit();
  }

  public function getColumns($params = [])
  {
    $query = DB::table('area_columns')->orderBy('id');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['name'])) {
      $query->where('name', $params['name']);
    }

    return $query->get();
  }

  // Areas

  public function createArea($plant, $name, $text, $comment, $columns)
  {
    $id = DB::table('areas')->insertGetId([
      'plant_id' => Facades\Plant::search(['name' => $plant])[0]->id,
      'name' => $name,
      'text' => $text,
      'comment' => $comment,
      'column_ids' => array_encode($columns)
    ]);

    return $this->getAreas(['id' => $id])['data'][$id];
  }

  public function deleteArea($plant, $name)
  {
    DB::table('areas')->where(
      'plant_id', Facades\Plant::search(['name' => $plant])[0]->id
    )->where('name', $name)->delete();
  }

  public function getAreas($params = [])
  {
    $query = DB::table('areas')->orderBy('id');

    $columnQuery = DB::table('area_columns')->where(
      'areas.column_ids', '@>', DB::raw('array[area_columns.id]')
    )->toSql();

    $columnQuery = DB::table(DB::raw("($columnQuery) as columns"))->select(
      DB::raw("coalesce(jsonb_object_agg(columns.id, columns.*), '{}')")
    )->toSql();

    $query->select([
      'areas.*',
      DB::raw("($columnQuery) as columns")
    ]);

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    return Serialize\Area::getResource($query->get());
  }

  public function updateAreaColumns($plant, $area, $columns)
  {
    DB::table('areas')->where(
      'plant_id', Facades\Plant::search(['code' => $plant])[0]->id
    )->where('name', $area)->update(['column_ids' => array_encode($columns)]);
  }
}
