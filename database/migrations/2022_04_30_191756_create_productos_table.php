<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id(); 
            $table->string('codigo');
            $table->string('nombre');
            $table->boolean('estado');

            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id') -> on ('categorias')->references('id');

            $table->unsignedBigInteger('unidad_medida_compra_id')->nullable();
            $table->foreign('unidad_medida_compra_id') -> on ('unidades_medidas_compras')->references('id');
            
            $table->unsignedBigInteger('unidad_medida_venta_id')->nullable();
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
        Schema::dropIfExists('productos');
    }
}
