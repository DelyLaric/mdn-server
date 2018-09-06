<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $areas = Facades\Areas::search();
        $columns = Facades\Columns::search();

        foreach ($areas as $area) {
            $data = [];
            $areaColumns = $columns->whereIn('id', $area->columns)->pluck('name');
            for ($i = 0, $l = random_int(4, 6) * 10; $i < $l; $i++) {
                $item = [];
                $item['area_id'] = $area->id;
                foreach ($areaColumns as $column) {
                    $item[$column] = '测试数据' . random_int(0, 10000);
                }
                $item['location_id'] = $i;
                $data[] = $item;
            }

            $groups = array_chunk($data, 500);
            foreach ($groups as $group) {
                DB::table('locations')->insert($group);
            }
        }
    }
}
