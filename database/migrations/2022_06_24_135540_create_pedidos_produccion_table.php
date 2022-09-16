<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_produccion', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->date('fecha_pedido');
            $table->decimal('total_solicitado',18,4)->nullable();
            $table->decimal('total_enviado',18,4)->nullable();

            $table->string('estado');

            $table->unsignedBigInteger('user_id');
            
            $table->unsignedBigInteger('sucursal_usuario_id');
            $table->unsignedBigInteger('sucursal_pedido_id');

            $table->foreign('user_id')->on('users')->references('id');
                     
            $table->foreign('sucursal_usuario_id')->on('sucursals')->references('id');
            $table->foreign('sucursal_pedido_id')->on('sucursals')->references('id');
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
        Schema::dropIfExists('pedidos_produccion');
    }
}
