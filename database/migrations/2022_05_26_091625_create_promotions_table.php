<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return null
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('image_id')->unsigned()->nullable();
            $table->boolean('status');//狀態
            $table->string('title');//名稱
            $table->boolean('show_description');//簡介
            $table->text('description')->nullable();
            $table->integer('type');//類型
            /*
             * 條件:沒有條件/商品達到多少$/指定商品達到多少數量
             */
            $table->json('condition');
            /*
             * 目標族群
             */
            $table->json('target');//目標族群
            /*
             * 開放時間
             */
            $table->datetime('start_date');
            $table->datetime('end_date');
            //排除的促銷方式
            $table->json('exclude_promotions');
            //排除的付款方式
            $table->json('exclude_payments');
            //排除的運送方式
            $table->json('exclude_deliverys');
            /**
             * 其他設定
             */
            $table->json('setting');//其餘設定
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
        Schema::drop('promotions');
    }
}
