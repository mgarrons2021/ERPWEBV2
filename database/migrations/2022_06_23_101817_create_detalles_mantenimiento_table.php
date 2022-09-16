<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesMantenimientoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_mantenimiento', function (Blueprint $table) {
            $table->id();
            $table->decimal('egreso',18,4);
            $table->string('glosa');
            $table->string('foto');
            $table->unsignedBigInteger('mantenimiento_id');
            $table->unsignedBigInteger('categoria_caja_chica_id');
            $table->foreign('mantenimiento_id')->on ('mantenimientos')-> references('id')-> onDelete('cascade');
            $table->foreign('categoria_caja_chica_id')->on ('categorias_caja_chica')-> references('id');
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
        Schema::dropIfExists('detalles_mantenimiento');
    }
}
