<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlatosSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('platos_sucursales', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio');
            $table->decimal('precio_delivery')->nullable();

            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('plato_id');
            $table->unsignedBigInteger('categoria_plato_id');

            $table->foreign('sucursal_id')->on('sucursals')->references('id')->onDelete('cascade');
            $table->foreign('plato_id')->on('platos')->references('id')->onDelete('cascade');
            $table->foreign('categoria_plato_id')->on('categorias_plato')->references('id')->onDelete('cascade');


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
        Schema::dropIfExists('platos_sucursales');
    }
}
