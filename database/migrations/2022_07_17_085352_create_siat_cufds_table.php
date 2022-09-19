<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiatCufdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siat_cufds', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha_generado');
            $table->dateTime('fecha_vigencia');
            $table->string('codigo');
            $table->string('codigo_control');
            $table->string('direccion');
            $table->char('estado');
            $table->bigInteger('numero_factura');

            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->on('sucursals')->references('id');
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
        Schema::dropIfExists('siat_cufds');
    }
}
