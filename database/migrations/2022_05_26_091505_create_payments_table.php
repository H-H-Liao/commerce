<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return null
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('payment_id');
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('type')->nullable();//支付類型
            $table->integer('api_type')->default(0);//串接商類型
            $table->json('api_code')->nullable(); //串接商相關API資訊
            $table->boolean('show_description')->default(0);//付款說明
            $table->text('description')->nullable();
            $table->integer('additional_fee_model')->default(0);//附加費用 0=沒有 1=固定 2=百分比
            $table->integer('additional_fee')->nullable();//附加費用
            $table->json('excluded_shipping')->nullable();//排除的送貨方式
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
        Schema::drop('payments');
    }
}
