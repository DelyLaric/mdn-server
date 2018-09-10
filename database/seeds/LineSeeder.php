<?php

use Illuminate\Database\Seeder;

class LineSeeder extends Seeder
{
    public function run()
    {
        $plants = DB::table('plants')->pluck('id');
        foreach ($plants as $plant) {
            $data = [];
            for ($i = 0; $i < 100; $i++) {
                $data[] = [
                    'data_id' => 10000 + $i * 100,
                    'categroy_id' => $plant
                ];
            }
            DB::table('lines')->insert($data);
        }
    }
}
