<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockIdealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ideal', function (Blueprint $table) {
            $table->id();    
            $table->date('fecha');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_id');   
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
            $table->foreign('sucursal_id')->on('sucursals')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('stock_ideal');
    }
}
