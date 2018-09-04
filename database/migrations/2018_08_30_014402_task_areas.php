<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskAreas extends Migration
{
    public function up()
    {
        Schema::create('task_areas', function ($table) {
            $table->integer('task_id');
            $table->integer('area_id');
            $table->string('location_id')->nullable();

            $table->unique(['task_id', 'area_id']);
        });
    }

    public function down()
    {
        Schema::drop('task_areas');
    }
}
