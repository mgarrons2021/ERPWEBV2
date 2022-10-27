<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesProyeccionesVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('detalles_proyecciones_ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_registro');
            $table->date('fecha_proyeccion');
            $table->decimal('venta_proyeccion_am',10,4);
            $table->decimal('venta_proyeccion_pm',10,4);
            $table->decimal('venta_proyeccion_subtotal',10,4);
            $table->decimal('venta_real_am',10,4);
            $table->decimal('venta_real_pm',10,4);
            $table->decimal('venta_real_subtotal',10,4);
            $table->unsignedBigInteger('proyecciones_ventas_id');
            $table->foreign('proyecciones_ventas_id')->on('proyecciones_ventas')->references('id')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('detalles_proyecciones_ventas');
    }
}
