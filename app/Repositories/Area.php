<?php

namespace App\Repositories;

use DB;
use Transaction;
use Illuminate\Support\Facades\Schema;

class Area extends BaseRepository
{
  public function create($plantId, $name, $text, $comment, $columns)
  {
    $id = DB::table('areas')->insertGetId([
      'plant_id' => $plantId,
      'name' => $name,
      'text' => $text,
      'comment' => $comment,
      'column_ids' => array_encode($columns)
    ]);

    return $this->search(['id' => $id])[0];
  }

  public function delete($id)
  {
    DB::table('areas')->where('id', $id)->delete();
  }

  public function updateName($id, $name)
  {
    DB::table('areas')->where('id', $id)->update(['name' => $name]);
  }

  public function updateText($id, $text)
  {
    DB::table('areas')->where('id', $id)->update(['text' => $text]);
  }

  public function updateComment($id, $comment)
  {
    DB::table('areas')->where('id', $id)->update(['comment' => $comment]);
  }

  public function updateColumns($id, $columns)
  {
    DB::table('areas')->where('id', $id)->update([
      'column_ids' => array_encode($columns)
    ]);
  }

  public function search($params = [])
  {
    $query = DB::table('areas')->orderBy('id');

    isset($params['id']) && $query->where('id', $params['id']);

    $result = $query->get();

    return Serialize\Area::getResource($result);
  }
}
