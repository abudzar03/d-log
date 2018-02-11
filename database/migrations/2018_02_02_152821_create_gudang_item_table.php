<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGudangItemTable extends Migration
{
    /**
     * Run the migrations. BINGUNG ENAKNYA GIMANA???
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudang_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gudang_id')->unsigned();
            $table->foreign('gudang_id')->references('id')->on('gudangs')->onDelete('cascade');
            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
            $table->integer('amount');
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
        Schema::dropIfExists('gudang_item');
    }
}
