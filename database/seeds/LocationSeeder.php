<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                foreach ($columns as $column) {
                    $data[$column] = '测试数据' . random_int(0, 10000);
                }
                $data['area_id'] = $area->id;
                $data['location_id'] = random_int(0, 100000);
                DB::table('locations')->insert($data);
            }
        }
    }
}
