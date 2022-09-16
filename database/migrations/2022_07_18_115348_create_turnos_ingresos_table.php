<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnosIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos_ingresos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha'); 
            $table->boolean('turno'); /* 0 = AM , 1 = PM */
            $table->boolean('estado');/* 1 es Abierto/habilitado y 0 cerrado/deshabilitado */
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();

            $table->decimal('ventas',18,4)->nullable();
            $table->integer('nro_transacciones')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_id');

            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('turnos_ingresos');
    }
}
