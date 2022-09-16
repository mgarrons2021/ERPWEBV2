<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasManosObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas_manos_obras', function (Blueprint $table) {
            $table->id();
            $table->decimal('ventas',18,4);
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
        Schema::dropIfExists('ventas_manos_obras');
    }
}
