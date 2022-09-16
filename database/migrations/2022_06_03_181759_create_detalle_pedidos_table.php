<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad_solicitada');
            $table->decimal('cantidad_enviada')->nullable();
            $table->decimal('precio');
            $table->decimal('subtotal_solicitado');
            $table->decimal('subtotal_enviado')->nullable();

            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('producto_id');
            
            $table->foreign('pedido_id')->on('pedidos')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('detalle_pedidos');
    }
}
