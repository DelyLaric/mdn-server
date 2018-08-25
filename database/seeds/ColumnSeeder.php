<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Facades\Columns::create("test_column_$i", "测试属性_$i", "用于测试_$i");
        }
    }
}
