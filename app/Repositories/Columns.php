<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Columns extends BaseRepository
{
  public function create($name, $text, $comment)
  {
    Transaction::begin();

    Schema::table('locations', function ($table) use ($name) {
      $table->string($name)->nullable();
    });

    $id = DB::table('area_columns')->insertGetId([
      'name' => $name,
      'text' => $text,
      'comment' => $comment
    ]);

    Transaction::commit();

    return $this->search(['id' => $id])[0];
  }

  public function delete($name)
  {
    Transaction::begin();

    Schema::table('locations', function ($table) use ($name) {
      $table->dropColumn($name);
    });

    $id = $this->search(['name' => $name])[0]->id;
    DB::table('areas')->update(['column_ids' => DB::raw("array_remove(column_ids, $id)")]);
    DB::table('area_columns')->where('name', $name)->delete();

    Transaction::commit();
  }

  public function updateName($column, $name)
  {
    Transaction::begin();

    Schema::table('locations', function ($table) use ($column, $name) {
      $table->renameColumn($column, $name);
    });

    DB::table('area_columns')->where('name', $column)->update([
      'name' => $name
    ]);

    Transaction::commit();
  }

  public function updateText($column, $text)
  {
    DB::table('area_columns')->where('name', $column)->update([
      'text' => $text
    ]);
  }

  public function updateComment($column, $comment)
  {
    DB::table('area_columns')->where('name', $column)->update([
      'comment' => $comment
    ]);
  }

  public function search($params = [])
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
}
