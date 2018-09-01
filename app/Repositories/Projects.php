<?php

namespace App\Repositories;

use DB;
use Transaction;

class Projects extends BaseRepository
{
  public function create($plantId, $name, $text, $comment)
  {
    $id = DB::table('projects')->insertGetId([
      'name' => $name,
      'text' => $text,
      'comment' => $comment,
      'plant_id' => $plantId
    ]);

    return $this->search([
      'id' => $id
    ])[0];
  }

  public function search($params = [])
  {
    $query = DB::table('projects')
               ->orderBy('id', 'desc');

    if (isset($params['is_filed'])) {
      if ($params['is_filed']) {
        $query->whereNotNull('is_filed');
      } else {
        $query->whereNull('is_filed');
      }
    }

    if (isset($params['plant_id'])) {
      $query->where('plant_id', $params['plant_id']);
    }

    if (isset($params['id'])) {
      $query->where('id', $params['id']);
    }

    return $query->get();
  }

  public function updateName($id, $name)
  {
    DB::table('projects')->where('id', $id)->update([
      'name' => $name
    ]);
  }

  public function updateText($id, $text)
  {
    DB::table('projects')->where('id', $id)->update([
      'text' => $text
    ]);
  }

  public function updateComment($id, $comment)
  {
    DB::table('projects')->where('id', $id)->update([
      'comment' => $comment
    ]);
  }

  public function file ($id)
  {
    DB::table('projects')->where('id', $id)->update([
      'filed_at' => 'now()'
    ]);

    return $this->search(['id' => $id])[0]->filed_at;
  }

  public function reopen ($id)
  {
    DB::table('projects')->where('id', $id)->update([
      'filed_at' => null
    ]);
  }

  public function destroy ($id)
  {
    DB::table('projects')->where('id', $id)->delete();
    // delete tasks
  }
}
