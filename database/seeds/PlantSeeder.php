<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run()
    {
        foreach ([1, 2, 3, 4] as $key) {
            Facades\Plant::create("test_plant_$key", "测试工厂_$key");
        }
    }
}
