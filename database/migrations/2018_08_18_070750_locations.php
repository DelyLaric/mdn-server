<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Locations extends Migration
{
    public function up()
    {
        Schema::create('locations', function ($table) {
            $table->increments('id');
            $table->integer('area_id');
            $table->string('location_id')->nullable()->comment('位置代码');
            $table->unique(['area_id', 'location_id']);
        });
    }

    public function down()
    {
        Schema::drop('locations');
    }
}
