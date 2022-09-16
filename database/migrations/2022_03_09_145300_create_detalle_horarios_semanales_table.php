<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleHorariosSemanalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_horarios_semanales', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('dia');
            $table->unsignedBigInteger('horario_semanale_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();
            
            $table->foreign('horario_semanale_id')->on('horarios_semanales')->references('id');
            $table->foreign('usuario_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_horarios_semanales');
    }
}
