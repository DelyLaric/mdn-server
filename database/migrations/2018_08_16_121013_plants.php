<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Plants extends Migration
{
    public function up()
    {
        Schema::create('plants', function ($table) {
            $table->increments('id');

            $table->string('name')->unique();
            $table->string('comment')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::statement('ALTER TABLE plants ADD COLUMN part_columns integer[] DEFAULT \'{}\'');
    }

    public function down()
    {
        Schema::drop('plants');
    }
}
