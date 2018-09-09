<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $projects = DB::table('projects')->select(['id'])->get();
        foreach ($projects as $project) {
            $id = $project->id;
            $data = [];
            for ($i = 0; $i < random_int(20, 30); $i++) {
                $data[] = [
                    'project_id' => $id,
                    'part_id' => random_int(1, 400),
                    'comment' => "测试任务_" . random_int(1, 200000)
                ];
            }
            DB::table('tasks')->insert($data);
        }
    }
}
