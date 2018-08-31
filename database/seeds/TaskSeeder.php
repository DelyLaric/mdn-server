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
            for ($i = 0; $i < random_int(100, 200); $i++) {
                $data[] = [
                    'project_id' => $id,
                    'comment' => "测试任务_" . random_int(1, 200000)
                ];
            }
            DB::table('tasks')->insert($data);
        }
    }
}
