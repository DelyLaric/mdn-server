<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run()
    {
        $plantIds = Facades\Plant::search()->pluck('id');
        $columns = Facades\Columns::search();

        foreach ($plantIds as $plantId) {
            for ($i = 0; $i < random_int(3, 10); $i++) {
                Facades\Area::create(
                    $plantId,
                    "test_area_$i",
                    "测试区域_$i",
                    "用于测试_$i",
                    $columns->random(random_int(5, 15))->pluck('id')->toArray()
                );
            }
        }
    }
}
