<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetrasosFaltasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retrasos_faltas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->nullable();
            $table->time('hora')->nullable();
            $table->string('descripcion')->nullable();
            $table->boolean('justificativo')->nullable();
            $table->boolean('tipo_registro')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean ('estado')->nullable();
            $table->unsignedBigInteger('sucursal_id'); 
            $table->unsignedBigInteger('user_id'); 
            $table->timestamps();
            $table->foreign("sucursal_id")->on("sucursals")->references("id");
            $table->foreign("user_id")->on("users")->references("id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retrasos_faltas');
    }
}
