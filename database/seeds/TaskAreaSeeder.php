<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskAreaSeeder extends Seeder
{
    public function run()
    {
      $areas = DB::table('areas')->get();
      $plants = DB::table('plants')->get();

      foreach ($plants as $plant) {
        $params = [];
        $plantAreas = $areas->where('plant_id', $plant->id)->pluck('id');
        $length = sizeof($plantAreas);
        $projects = DB::table('projects')->where('plant_id', $plant->id)->pluck('id');
        $tasks = DB::table('tasks')->whereIn('project_id', $projects)->pluck('id');
        foreach ($tasks as $taskId) {
          foreach ($plantAreas->random(random_int(2, $length)) as $areaId) {
            $params[] = [
              'task_id' => $taskId,
              'area_id' => $areaId,
              'data_id' => random_int(1, 39)
            ];
          }
        }
        DB::table('task_areas')->insert($params);
      }
    }
}
