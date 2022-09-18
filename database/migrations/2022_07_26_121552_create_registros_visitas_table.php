<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrosVisitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registros_visitas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->integer('registro_contador');

            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('venta_id');

            $table->foreign('cliente_id')->on('clientes')->references('id');
            $table->foreign('venta_id')->on('ventas')->onDelete('cascade')->references('id');
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
        Schema::dropIfExists('registros_visitas');
    }
}
