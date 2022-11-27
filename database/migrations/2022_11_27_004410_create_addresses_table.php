<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('country')->nullable();//國家
            $table->text('code')->nullable();//區域號碼
            $table->text('city')->nullable();//縣市
            $table->text('town')->nullable();//鄉鎮市區
            $table->text('street')->nullable();//地址
            $table->text('name')->nullable();//姓名
            $table->text('phone')->nullable();//電話
            $table->text('mobilephone')->nullable();//手機
            $table->text('email')->nullable();//信箱
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
        Schema::dropIfExists('addresses');
    }
}
