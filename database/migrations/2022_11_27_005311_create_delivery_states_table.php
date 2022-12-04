<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //物流狀態
        Schema::create('delivery_states', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('delivery_state_id');
            $table->integer('order_id')->unsigned();//訂單編號
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->integer('status');//狀態
            $table->integer('operator')->nullable();//操作者
            $table->integer('operator_id')->nullable();//操作者ID
            $table->text('memo')->nullable();//備註
            $table->timestamps();//log 時間
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_states');
    }
}
