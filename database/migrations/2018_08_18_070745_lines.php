<?php

use App\Repositories\Facades\Columns;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lines extends Migration
{
    public function up()
    {
        Schema::create('lines', function ($table) {
            $table->increments('id');
            $table->integer('categroy_id');
            $table->string('data_id')->nullable();

            $table->unique(['categroy_id', 'data_id']);
        });

        Columns::createFixed('lines', 'data_id', '工位代码');
    }

    public function down()
    {
        Schema::drop('lines');
    }
}
