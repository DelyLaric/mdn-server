<?php

namespace App\Repositories;

use DB;

class Plant extends BaseRepository
{
  public function create($name)
  {
    $id = DB::table('plants')->insertGetId(['name' => $name]);

    return $this->findById($id);
  }

  public function delete($name)
  {
    DB::table('plants')->where('name', $name)->update([
      'deleted_at' => 'now()'
    ]);
  }

  public function update($name, $data)
  {
    DB::table('plants')->where('name', $name)->update($data);
  }

  public function search()
  {
    return DB::table('plants')->orderBy('id')->get();
  }

  public function find($name)
  {
    return DB::table('plants')->where('name', $name)->get()[0];
  }

  public function findById($id)
  {
    return DB::table('plants')->where('id', $id)->get()[0];
  }
} 
