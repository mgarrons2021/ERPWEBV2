<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroAsistenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_asistencia', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->decimal('hora_trabajadas', 18, 4);
            $table->char('turno');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('user_id')->on('users')->references('id');
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
        Schema::dropIfExists('registro_asistencia');
    }
}
