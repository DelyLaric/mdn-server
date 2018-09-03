<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run()
    {
        $plantIds = Facades\Plants::search()->pluck('id');
        $columns = Facades\Columns::search();

        foreach ($plantIds as $plantId) {
            for ($i = 0; $i < random_int(6, 15); $i++) {
                DB::table('areas')->insert([
                    'plant_id' => $plantId,
                    'name' => "test_area_$i",
                    'text' => "测试区域_$i",
                    'comment' => "用于测试_$i",
                    'column_ids' => array_encode(
                        $columns->random(random_int(8, 20))->pluck('id')->toArray()
                    )
                ]);
            }
        }
    }
}
