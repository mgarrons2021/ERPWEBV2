<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {

            $table->id();
            $table->string('nombre');
            $table->string('turno');
            $table->time('hora_inicio')->nullable();    
            $table->time('hora_fin')->nullable();    
            $table->string('dia_semana');
            $table->timestamps();
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('cargo_id')->references('id')->on('cargos_sucursales');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tareas');
    }
}
