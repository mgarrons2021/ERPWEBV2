<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventariosSistemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventarios_sistema', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total',18,4)->nullable();
            $table->char('tipo_inventario');
            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('turno_id')->nullable();
            $table->unsignedBigInteger('inventario_id');

            $table->foreign('sucursal_id')->on('sucursals')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('turno_id')->on('turnos')->references('id');
            $table->foreign('inventario_id')->on('inventarios')->references('id')->onDelete('cascade');
      
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
        Schema::dropIfExists('inventarios_sistema');
    }
}
