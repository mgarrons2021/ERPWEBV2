<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyeccionesVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyecciones_ventas', function (Blueprint $table) {
            $table->id();    
            $table->date('fecha_registro');
            $table->date('mes_proyeccion');
            $table->date('proyeccion_subtotal_am');
            $table->date('proyeccion_subtotal_pm');
            $table->date('total_proyeccion');
            $table->date('venta_subtotal_am');
            $table->date('venta_subtotal_pm');
            $table->date('total_ventas_real');
            $table->date('diferencias');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_id');   
            $table->foreign('user_id')->on('users')->references('id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sucursal_id')->on('sucursals')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('proyecciones_ventas');
    }
}
