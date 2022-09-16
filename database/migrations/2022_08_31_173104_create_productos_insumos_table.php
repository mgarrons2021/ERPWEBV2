<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_insumos', function (Blueprint $table) {
            $table->id();
            $table->double('cantidad');

            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('insumos_dias_id');

            $table->foreign('insumos_dias_id')->on('insumos_dias')->references('id');          
            $table->foreign('producto_id')->on('productos')->references('id');

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
        Schema::dropIfExists('productos_insumos');
    }
}
