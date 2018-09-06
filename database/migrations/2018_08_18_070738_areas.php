<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Areas extends Migration
{
    public function up()
    {
        Schema::create('areas', function ($table) {
            $table->increments('id');
            $table->integer('plant_id');
            $table->string('name');
            $table->string('text');
            $table->string('comment')->nullable();

            $table->unique(['plant_id', 'name']);
        });

        DB::statement('ALTER TABLE areas ADD COLUMN columns integer[] DEFAULT \'{}\'');
    }

    public function down()
    {
        Schema::drop('areas');
    }
}
