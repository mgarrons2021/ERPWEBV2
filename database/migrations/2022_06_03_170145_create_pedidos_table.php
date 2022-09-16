<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_actual');
            
            $table->date('fecha_pedido');
            $table->decimal('total_solicitado')->nullable();
            $table->decimal('total_enviado')->nullable();
            
            $table->string('estado');
            $table->string('estado_impresion')->nullable()->default('N');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_principal_id');
            $table->unsignedBigInteger('sucursal_secundaria_id');

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('sucursal_principal_id')->on('sucursals')->references('id');
            $table->foreign('sucursal_secundaria_id')->on('sucursals')->references('id');
            

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
        Schema::dropIfExists('pedidos');
    }
}
