<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    public function run()
    {
        $plantIds = Facades\Plants::search()->pluck('id');
        $columns = Facades\Columns::search(['table' => 'locations']);
        $fixedColumns = $columns->where('is_fixed', true)->map(
            function($column) { return $column->id; }
        )->toArray();

        foreach ($plantIds as $plantId) {
            for ($i = 0; $i < random_int(6, 15); $i++) {
                $areaColumns = array_unique(array_merge(
                    $fixedColumns,
                    $columns->random(random_int(8, 20))->pluck('id')->toArray()
                ));
                DB::table('areas')->insert([
                    'plant_id' => $plantId,
                    'name' => "test_area_$i",
                    'text' => "测试区域_$i",
                    'comment' => "用于测试_$i",
                    'columns' => array_encode($areaColumns)
                ]);
            }
        }
    }
}
