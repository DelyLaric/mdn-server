<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Columns extends BaseRepository
{
  public function search($params = [])
  {
    $query = DB::table('columns')->orderBy('columns.id');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['table'])) {
      $query->where('table', $params['table']);
    }

    return $query->get();
  }

  public function create($name, $text, $comment, $table)
  {
    Transaction::begin();

    Schema::table($table, function ($table) use ($name) {
      $table->string($name)->nullable();
    });

    $id = DB::table('columns')->insertGetId([
      'name' => $name,
      'text' => $text,
      'table' => $table,
      'comment' => $comment
    ]);

    Transaction::commit();

    return $this->search(['id' => $id])[0];
  }

  public function destroy($id, $pivot, $pivotKey)
  {
    $column = $this->search(['id' => $id])[0];
    $table = $column->table;
    $name = $column->name;

    Transaction::begin();

    Schema::table($table, function ($table) use ($name) {
      $table->dropColumn($name);
    });

    DB::table($pivot)->update([$pivotKey => DB::raw("array_remove($pivotKey, $id)")]);
    DB::table('columns')->where('id', $id)->delete();

    Transaction::commit();
  }

  public function updateName($id, $name)
  {
    $column = $this->search(['id' => $id])[0];
    $oldName = $column->name;
    $table = $column->table;

    Transaction::begin();

    Schema::table($table, function ($table) use ($oldName, $name) {
      $table->renameColumn($oldName, $name);
    });

    DB::table('columns')->where('id', $id)->update([
      'name' => $name
    ]);

    Transaction::commit();
  }
}
