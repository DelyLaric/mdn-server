<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('system.users')->insert([
            'id'       => 1,
            'name'     => 'admin',
            'username' => 'admin',
            'password' => '123456'
          ]);
    }
}
