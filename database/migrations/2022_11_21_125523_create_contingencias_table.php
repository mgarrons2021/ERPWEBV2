<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContingenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contingencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio_contingencia')->nullable();
            $table->date('fecha_fin_contingencia')->nullable();
            $table->unsignedBigInteger('evento_significativo_id')->nullable();
            $table->timestamps();

            $table->foreign('evento_significativo_id')->on('siat_eventos_significativos')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contingencias');
    }
}
