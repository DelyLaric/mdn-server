<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $areas = Facades\Area::search();
        
        foreach ($areas as $area) {
            for ($i = 0; $i < random_int(50, 100); $i++) {
                $columns = Facades\Columns::search(
                    ['area_id' => $area->id]
                )->pluck('name')->toArray();
                $values = array_map(function ($column) { return '测试数据' . random_int(0, 1000); }, $columns);
                $data = array_combine($columns, $values);
                Facades\Locations::create($area->id, $i + 1, $data);
            }
        }
    }
}
