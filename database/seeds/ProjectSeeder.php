<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $plantIds = Facades\Plants::search()->pluck('id');
        foreach ($plantIds as $plantId) {
            $data = [];
            for ($i = 0; $i < random_int(300, 500); $i++) {
                $data[] = [
                    'plant_id' => $plantId,
                    'name' => "poj_$i",
                    'text' => "测试项目_$i",
                    'comment' => "用于测试_$i",
                    'filed_at' => random_int(0, 1) ? 'now()' : null
                ];
            }
            DB::table('projects')->insert($data);
        }
    }
}
