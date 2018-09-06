<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Columns extends Migration
{
    public function up()
    {
        Schema::create('columns', function ($table) {
            $table->increments('id');
            $table->string('table')->enum(['parts', 'packages', 'lines', 'locations']);

            $table->string('name');
            $table->string('text');
            $table->string('comment')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('columns');
    }
}
