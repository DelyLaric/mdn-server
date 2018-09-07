<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Parts extends Migration
{
    public function up()
    {
        Schema::create('parts', function ($table) {
            $table->increments('id');
            $table->integer('plant_id');
            $table->string('part_id')->nullable();

            $table->unique(['plant_id', 'part_id']);
        });
    }

    public function down()
    {
        Schema::drop('parts');
    }
}
