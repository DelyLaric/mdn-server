<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Columns extends BaseRepository
{
  public function search($params = [])
  {
    $query = DB::table('area_columns')->orderBy('area_columns.id');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['name'])) {
      $query->where('name', $params['name']);
    }

    return $query->get();
  }

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

  public function destroy($id)
  {
    $name = $this->search(['id' => $id])[0]->name;

    Transaction::begin();

    Schema::table('locations', function ($table) use ($name) {
      $table->dropColumn($name);
    });

    DB::table('areas')->update(['column_ids' => DB::raw("array_remove(column_ids, $id)")]);
    DB::table('area_columns')->where('id', $id)->delete();

    Transaction::commit();
  }

  public function updateName($id, $name)
  {
    $oldName = $this->search(['id' => $id])[0]->name;

    Transaction::begin();

    Schema::table('locations', function ($table) use ($oldName, $name) {
      $table->renameColumn($oldName, $name);
    });

    DB::table('area_columns')->where('id', $id)->update([
      'name' => $name
    ]);

    Transaction::commit();
  }
}
