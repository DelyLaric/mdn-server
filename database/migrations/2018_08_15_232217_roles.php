<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Roles extends Migration
{
    public function up()
    {
        Schema::create('roles', function ($table) {
            $table->increments('id');

            $table->string('name');
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
