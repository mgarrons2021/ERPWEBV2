<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeperisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keperis', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('cantidad_kilos',18,2);
            $table->decimal('cantidad_crudo',18,2);
            $table->decimal('cantidad_marinado',18,2);
            $table->decimal('cantidad_cocido',18,2);
            
            $table->decimal('cantidad_sellado',18,2);
            $table->decimal('cantidad_enviado',18,2)->nullable();
            $table->string('nombre_usuario');
            $table->decimal('temperatura_maxima',2);
            $table->integer('veces_volcado');

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
        Schema::dropIfExists('keperis');
    }
}
