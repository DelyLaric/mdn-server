<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    public function run()
    {
        // $this->insert('datasource/master.csv', 'data.master');
        // $this->insert('datasource/bins.csv', 'data.bins');
        // $this->insert('datasource/lines.csv', 'data.lines');
        // $this->insert('datasource/kcsq.csv', 'data.kcsq');

        // $this->insert('datasource/parts.csv', 'data.parts');
        // $this->insertForce('datasource/parts.csv', 'data.parts');
    }

    public function insert($file, $table)
    {
        $data = Excel::load(storage_path($file));

        // 这里必须 chunk 否则将造成阻塞
        $data = array_chunk($data, 500);

        foreach ($data as $datum) {
            DB::table($table)->insert($datum);
        } 
    }

    // 忽视异常的数据
    public function insertForce($file, $table)
    {
        $data = Excel::load(storage_path($file));
        foreach ($data as $datum) {
            try {
                DB::table($table)->insert($datum);
            } catch (\Exception $e) {

            }
        }
    }
}
