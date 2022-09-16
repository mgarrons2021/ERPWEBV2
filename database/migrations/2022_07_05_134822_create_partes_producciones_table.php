<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartesProduccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partes_producciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total',18,2)->nullable();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_usuario_id');

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('sucursal_usuario_id')->on('sucursals')->references('id');


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
        Schema::dropIfExists('partes_producciones');
    }
}
