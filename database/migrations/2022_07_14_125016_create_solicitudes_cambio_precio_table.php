<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesCambioPrecioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_cambio_precio', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('estado');
            $table->string('motivo_cambio');
            $table->unsignedBigInteger('producto_proveedor_id');
            $table->timestamps();

            $table->foreign('producto_proveedor_id')->on('producto_proveedor')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitudes_cambio_precio');
    }
}
