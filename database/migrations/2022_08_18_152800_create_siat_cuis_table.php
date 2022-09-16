<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiatCuisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siat_cuis', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_generado');
            $table->date('fecha_expiracion');
            $table->string('codigo_cui');
            $table->char('estado')->nullable();
            
            $table->unsignedBigInteger('sucursal_id');

            $table->foreign('sucursal_id')->on('sucursals')->references('id');

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
        Schema::dropIfExists('siat_cuis');
    }
}
