<?php

use App\Repositories\Facades\Columns;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Packages extends Migration
{
    public function up()
    {
        Schema::create('packages', function ($table) {
            $table->increments('id');
            $table->integer('categroy_id');
            $table->string('data_id')->nullable();
            $table->string('length')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();

            $table->unique(['categroy_id', 'data_id']);
        });

        Columns::createFixed('packages', 'data_id', '包装代码');
        Columns::createFixed('packages', 'length', '长');
        Columns::createFixed('packages', 'width', '宽');
        Columns::createFixed('packages', 'height', '高');
    }

    public function down()
    {
        Schema::drop('packages');
    }
}
