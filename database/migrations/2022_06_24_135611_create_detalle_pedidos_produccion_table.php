<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePedidosProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_pedidos_produccion', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio');
            $table->decimal('cantidad_solicitada',18,2);
            $table->decimal('cantidad_enviada',18,2)->nullable();
            $table->decimal('subtotal_solicitado',18,2);
            $table->decimal('subtotal_enviado',18,2)->nullable();

            $table->unsignedBigInteger('pedido_produccion_id');
            $table->unsignedBigInteger('plato_id');

            $table->foreign('pedido_produccion_id')->on('pedidos_produccion')->references('id')->onDelete('cascade');
            $table->foreign('plato_id')->on('platos')->references('id');    


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
        Schema::dropIfExists('detalle_pedidos_produccion');
    }
}
