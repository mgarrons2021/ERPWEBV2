<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraspasosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traspasos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total',18,4)->nullable();
            $table->char('estado');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('inventario_principal_id')->nullable();
            $table->unsignedBigInteger('inventario_secundario_id')->nullable();
            $table->unsignedBigInteger('sucursal_principal_id');
            $table->unsignedBigInteger('sucursal_secundaria_id');
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('inventario_principal_id')->on('inventarios')->references('id');
            $table->foreign('inventario_secundario_id')->on('inventarios')->references('id');
            $table->foreign('sucursal_principal_id')->on('sucursals')->references('id');
            $table->foreign('sucursal_secundaria_id')->on('sucursals')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('traspasos');
    }
}
