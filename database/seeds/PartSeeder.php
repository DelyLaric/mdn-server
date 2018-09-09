<?php

use App\Repositories\Facades;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartSeeder extends Seeder
{
    public function run()
    {
        $plants = Facades\Plants::search();
        $columns = Facades\Columns::search(['table' => 'parts'])->pluck('name');

        foreach ($plants as $plant) {

            $data = [];
            for ($i = 0, $l = random_int(4, 6) * 100; $i < $l; $i++) {
                $item = [];
                $item['categroy_id'] = $plant->id;
                foreach ($columns as $column) {
                    $item[$column] = '测试数据' . random_int(0, 10000);
                }
                $item['data_id'] = $i;
                $data[] = $item;
                if ($i % 1000 === 0) {
                    DB::table('parts')->insert($data);
                    $data = [];
                }
            }
        }
    }
}
