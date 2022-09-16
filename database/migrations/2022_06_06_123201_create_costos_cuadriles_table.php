<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostosCuadrilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costos_cuadriles', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario');
            $table->decimal('peso_inicial',18,4);
            $table->date('fecha');
            $table->decimal('total_lomo',18,4)->nullable();
            $table->decimal('total_eliminacion',18,4)->nullable();
            $table->decimal('total_recorte',18,4)->nullable();
            $table->decimal('total_unidad_cuadril',18,4)->nullable();
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
        Schema::dropIfExists('costos_cuadriles');
    }
}
