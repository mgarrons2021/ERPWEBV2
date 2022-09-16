<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatosProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platos_productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plato_id');
            $table->unsignedBigInteger('producto_proveedor_id');
            $table->decimal('cantidad', 18,4)->nullable();
            $table->decimal('subtotal', 18,4)->nullable();

            $table->foreign('plato_id')->on('platos')->references('id')->onDelete('cascade');
            $table->foreign('producto_proveedor_id')->on('producto_proveedor')->references('id');
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
        Schema::dropIfExists('platos_productos');
    }
}
