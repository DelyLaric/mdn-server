<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $plants = DB::table('plants')->pluck('id');
        foreach ($plants as $plant) {
            $data = [];
            for ($i = 0; $i < 100; $i++) {
                $data[] = [
                    'data_id' => 10000 + $i * 100,
                    'length' => random_int(1, 5) * 100,
                    'width' => random_int(1, 5) * 100,
                    'height' => random_int(1, 5) * 100,
                    'categroy_id' => $plant
                ];
            }
            DB::table('packages')->insert($data);
        }
    }
}
