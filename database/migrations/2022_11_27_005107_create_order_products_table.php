<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('order_product_id');
            $table->integer('order_id')->unsigned();//訂單編號
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->string('title');//產品名稱
            $table->text('spec');//規格名稱
            $table->integer('amount')->unsigned();//數量
            $table->json('price_array');//產品單價陣列
            $table->integer('price')->unsigned();//單價
            $table->integer('sum')->unsigned();//總價格
            $table->integer('box')->unsigned();//產品總價格
            $table->json('promotion');//優惠活動
            $table->json('product');//商品內容
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
