<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlantSeeder extends Seeder
{
    public function run()
    {
        foreach ([1, 2, 3, 4, 5, 6, 7] as $key) {
            DB::table('plants')->insert([
                'name' => "test_plant_$key",
                'comment' => "测试工厂_$key"
            ]);
        }
    }
}
