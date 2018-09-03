<?php

namespace App\Repositories;

use DB;

class Areas extends BaseRepository
{
  public function search($params = [])
  {
    $query = DB::table('areas')->orderBy('id');

    isset($params['id']) && $query->where('id', $params['id']);

    $result = $query->get();

    return Serialize\Area::getResource($result);
  }
}
