<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReciclajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reciclajes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total',18,4)->nullable();
            $table->string('estado');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->unsignedBigInteger('inventario_id')->nullable();
            $table->unsignedBigInteger('turno_id');

            $table->foreign('turno_id')->on('turnos')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('sucursal_id')->on('sucursals')->references('id');
            $table->foreign('inventario_id')->on('inventarios')->references('id');
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
        Schema::dropIfExists('reciclajes');
    }
}
