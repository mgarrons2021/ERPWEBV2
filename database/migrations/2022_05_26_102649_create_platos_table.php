<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');         
            $table->string('imagen')->nullable();
            $table->boolean('estado');
            $table->decimal('costo_plato', 18,4)->nullable();
            $table->unsignedBigInteger('categoria_plato_id')->nullable();
            $table->unsignedBigInteger('unidad_medida_compra_id')->nullable();
            $table->unsignedBigInteger('unidad_medida_venta_id')->nullable();
            $table->foreign('categoria_plato_id') -> on ('categorias_plato')->references('id');
            $table->foreign('unidad_medida_compra_id') -> on ('unidades_medidas_compras')->references('id');
            $table->foreign('unidad_medida_venta_id') -> on ('unidades_medidas_ventas')->references('id');

            
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
        Schema::dropIfExists('platos');
    }
}
