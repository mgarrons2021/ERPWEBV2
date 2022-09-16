<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesStockIdealTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('detalles_stock_ideal', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('cantidad',10,4);
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('asignar__stock_id');

            $table->foreign('producto_id')->on('productos')->references('id')->onDelete('cascade');
            $table->foreign('asignar__stock_id')->on('stock_ideal')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('detalles_stock_ideal');
    }
}
