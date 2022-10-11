<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChanchosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chanchos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('usuario');
            $table->decimal('costilla_kilos');
            $table->decimal('costilla_marinado');
            $table->decimal('costilla_horneado');
            $table->decimal('costilla_cortado');

            $table->decimal('pierna_kilos');
            $table->decimal('pierna_marinado');
            $table->decimal('pierna_horneado');
            $table->decimal('pierna_cortada');

            $table->decimal('lechon_cortado');
            $table->decimal('chancho_enviado');

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
        Schema::dropIfExists('chanchos');
    }
}
