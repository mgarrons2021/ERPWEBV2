<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePartesProduccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_partes_producciones', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio',18,2);
            $table->decimal('cantidad',18,2);
            $table->decimal('subtotal',18,2);

            $table->unsignedBigInteger('parte_produccion_id');
            $table->unsignedBigInteger('producto_id');

            $table->foreign('parte_produccion_id')->on('partes_producciones')->references('id')->onDelete('cascade');
            $table->foreign('producto_id')->on('productos')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_partes_producciones');
    }
}
