<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSancionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sanciones', function (Blueprint $table) {
            $table->id();
            $table->string('imagen')->nullable();
            $table->date('fecha')->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('sucursal_id'); 
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('categoria_sancion_id');     
            $table->timestamps();
        });
        Schema::table('sanciones', function (Blueprint $table) {
            $table->foreign('sucursal_id')
            ->references('id')
            ->on('sucursals');
        });
        Schema::table('sanciones', function (Blueprint $table) {
            $table->foreign('user_id')
            ->references('id')
            ->on('users');
        });
        Schema::table('sanciones', function (Blueprint $table) {
            $table->foreign('categoria_sancion_id')
            ->references('id')
            ->on('categoria_sancion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sanciones');
    }
}
