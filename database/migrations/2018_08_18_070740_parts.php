<?php

use App\Repositories\Facades\Columns;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Parts extends Migration
{
    public function up()
    {
        Schema::create('parts', function ($table) {
            $table->increments('id');
            $table->integer('categroy_id');
            $table->string('data_id')->nullable();
            $table->string('package_id')->nullable();

            $table->unique(['categroy_id', 'data_id']);
        });

        Columns::createFixed('parts', 'data_id', '零件号');
        Columns::createFixed('parts', 'package_id', '包装代码');
    }

    public function down()
    {
        Schema::drop('parts');
    }
}
