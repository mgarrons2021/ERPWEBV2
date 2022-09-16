<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManosObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manos_obras', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('ventas',18,4);
            $table->decimal('total_horas',18,4)->nullable();
            $table->decimal('total_costo',18,4)->nullable();

            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('turno_id');

            $table->foreign('sucursal_id')->on('sucursals')->references('id');
            $table->foreign('turno_id')->on('turnos')->references('id');
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
        Schema::dropIfExists('manos_obras');
    }
}
