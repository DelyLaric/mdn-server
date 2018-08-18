<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaColumns extends Migration
{
    public function up()
    {
        Schema::create('area_columns', function ($table) {
            $table->increments('id');

            $table->string('name');
            $table->string('text');
            $table->string('comment')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('area_columns');
    }
}
