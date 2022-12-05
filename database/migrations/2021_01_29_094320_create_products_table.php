<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return null
     */
    public function up()
    {
        Schema::create('product_indices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_index_id');
            $table->integer('product_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('product_id');
            $table->boolean('status')->default(0);//狀態
            $table->string('name');//產品名稱
            $table->boolean('show_description')->default(0);//簡介
            $table->text('description')->nullable();
            $table->json('spec')->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('product_id')->on('products')->onDelete('cascade');
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
        Schema::drop('products');//產品資訊
        Schema::drop('product_indices');//產品資訊
    }
}
