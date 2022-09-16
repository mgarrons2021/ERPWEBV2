<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosDiasTable extends Migration
{

    public function up()
    {
        Schema::create('insumos_dias', function (Blueprint $table) {
            $table->id();
            $table->string('dia');
            $table->string('tipo');
            
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
        Schema::dropIfExists('insumos_dias');
    }
}
