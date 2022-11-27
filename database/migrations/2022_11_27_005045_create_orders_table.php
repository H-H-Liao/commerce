<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->bigInteger('serial_number');//序號
            $table->integer('user_id')->unsigned()->nullable();//訂購者id
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->integer('address_id');//收件者地址
            $table->integer('delivery_model_id');//貨運方式
            $table->integer('payment_model_id');//付款方式
            $table->integer('invoice_type');//發票資訊
            $table->string('invoice_title');//抬頭
            $table->string('invoice_number');//號碼
            $table->text('memo')->nullable();//備註
            $table->integer('subtotal')->default(0);//小計
            $table->integer('fee')->default(0);//額外的費用
            $table->integer('sum')->default(0);//訂單總金額
            $table->json('cart')->nullable();//訂單細節
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
        Schema::dropIfExists('orders');
    }
}
