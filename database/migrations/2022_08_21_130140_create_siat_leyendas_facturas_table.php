<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiatLeyendasFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siat_leyendas_facturas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('codigo_actividad');
            $table->string('descripcion_leyenda');
            

            
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
        Schema::dropIfExists('siat_leyendas_facturas');
    }
}
