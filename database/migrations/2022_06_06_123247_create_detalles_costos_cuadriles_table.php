<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesCostosCuadrilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_costos_cuadriles', function (Blueprint $table) {
            $table->id();
          
            $table->decimal('cantidad_lomo',18,4);
            $table->decimal('cantidad_eliminado',18,4);
            $table->decimal('cantidad_recortado',18,4);
            $table->decimal('cantidad_cuadril',18,4);
            $table->decimal('cantidad_ideal_cuadril',18,4);


            $table->unsignedBigInteger('costo_cuadril_id');
            $table->foreign('costo_cuadril_id')->on('costos_cuadriles')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('detalles_costos_cuadriles');
    }
}
