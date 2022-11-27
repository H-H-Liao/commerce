<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return null
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('status');
            $table->string('title'); //送貨方式
            $table->boolean('show_description');//簡介
            $table->text('description')->nullable();
            $table->json('area');//區域規則
            $table->integer('position')->unsigned()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return null
     */
    public function down()
    {
        Schema::drop('deliveries');
    }
}
