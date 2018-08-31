<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tasks extends Migration
{
    public function up()
    {
        Schema::create('tasks', function ($table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->string('name')->nullable();
            $table->string('comment')->nullable();

            $table->string('part_id')->nullable();
            $table->string('line_id')->nullable();

            $table->integer('status')->default(0);
            $table->integer('due_time')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('filed_at')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('tasks');
    }
}
