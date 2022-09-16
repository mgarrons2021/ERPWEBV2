<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiatRegistroPuntoVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siat_registro_punto_venta', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_punto_venta');
            $table->unsignedBigInteger('sucursal_id');

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
        Schema::dropIfExists('siat_registro_punto_venta');
    }
}
