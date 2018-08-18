<?php

namespace App\Repositories;

use DB;

class Plant extends BaseRepository
{
  public function create($name)
  {
    $id = DB::table('plants')->insertGetId(['name' => $name]);

    return $this->search(['id' => $id])[0];
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

  public function search($params = [])
  {
    $query = DB::table('plants')->orderBy('id');

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    if (isset($params['name'])) {
      $query->where('name', $params['name']);
    }

    return $query->get();
  }
} 
