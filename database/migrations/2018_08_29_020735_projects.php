<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    public function up()
    {
        Schema::create('projects', function ($table) {
            $table->increments('id');
            $table->integer('plant_id');
            $table->string('name')->unqiue();
            $table->string('text');
            $table->string('comment')->nullable();

            $table->timestamp('filed_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::drop('projects');
    }
}
