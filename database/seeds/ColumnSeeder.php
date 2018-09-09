<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;

class ColumnSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 20; $i++) {
            Facades\Columns::create("test_column_$i", "区域属性_$i", "测试属性_$i", 'locations');
        }

        for ($i = 0; $i < 20; $i++) {
            Facades\Columns::create("test_column_$i", "零件属性_$i", "测试属性_$i", 'parts');
        }
    }
}
