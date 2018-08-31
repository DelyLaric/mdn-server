<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Tasks;

class TaskController extends Controller
{
  public function create()
  {
    $params = $this->via([
      'projectId' => 'required'
    ]);

    $id = DB::table('tasks')->insertGetId([
      'project_id' => $params['projectId']
    ]);

    return (array) Tasks::search(['id' => $id])[0];
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    DB::table('tasks')->where('id', $params['id'])->delete();

    return 200;
  }

  public function search()
  {
    $params = $this->via([
      'projectId' => 'nullable'
    ]);

    $params['project_id'] = $params['projectId'];

    return Tasks::search($params);
  }

  public function updateComment()
  {
    $params = $this->via([
      'id' => 'required',
      'value' => 'required'
    ]);

    DB::table('tasks')->where('id', $params['id'])->update([
      'comment' => $params['value']
    ]);

    return 200;
  }
}
