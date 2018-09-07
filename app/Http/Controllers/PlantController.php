<?php

namespace App\Http\Controllers;

use DB;
use App\Repositories\Facades\Plants;

class PlantController extends Controller
{
  public function search()
  {
    return Plants::search();
  }

  public function create()
  {
    $params = $this->via([
      'name' => 'required|unique:plants,name',
      'comment' => 'nullable'
    ]);

    $id = DB::table('plants')->insertGetId($params);

    return success_response([
      'message' => '工厂已创建',
      'data' => Plants::search(['id' => $id])[0]
    ]);
  }

  public function destroy()
  {
    $params = $this->via([
      'id' => 'required'
    ]);

    DB::table('plants')->where('id', $params['id'])->delete();

    return success_response('工厂已删除');
  }

  public function updateName()
  {
    $params = $this->via([
      'id' => 'required',
      'name' => 'required'
    ]);

    DB::table('plants')->where('id', $params['id'])->update([
      'name' => $params['name']
    ]);

    return success_response('工厂名已更新');
  }

  public function updateComment()
  {
    $params = $this->via([
      'id' => 'required',
      'comment' => 'required'
    ]);

    DB::table('plants')->where('id', $params['id'])->update([
      'comment' => $params['comment']
    ]);

    return success_response('工厂备注已更新');
  }

  public function updatePartColumns()
  {
    $id = $this->get('id', 'required');
    $columns = $this->get('columns', 'required');

    DB::table('plants')->where('id', $id)->update([
      'columns' => array_encode($columns)
    ]);

    return success_response('工厂零件表已更新');
  }
}
