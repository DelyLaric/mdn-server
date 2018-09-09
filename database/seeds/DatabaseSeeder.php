<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(PlantSeeder::class);
        $this->call(ColumnSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(PartSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(TaskAreaSeeder::class);
    }
}
