<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        $areas = Facades\Areas::search();

        foreach ($areas as $area) {
            $data = [];
            $columns = Facades\Columns::search(
                ['area_id' => $area->id]
            )->pluck('name')->toArray();
            for ($i = 0, $l = random_int(1, 20) * 10; $i < $l; $i++) {
                $item = [];
                $item['area_id'] = $area->id;
                foreach ($columns as $column) {
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
