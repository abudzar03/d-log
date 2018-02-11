<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengirimanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_perusahaan_id')->unsigned();
            $table->foreign('user_perusahaan_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('user_gudang_id')->unsigned();
            $table->foreign('user_gudang_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->integer('amount');
            $table->integer('status');//1=menunggu,2=dikirim ke gudang,3=sampai di gudang,4=diambil untuk dikirim ke pembeli,5=diterima pembeli
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
        Schema::dropIfExists('pengiriman');
    }
}
