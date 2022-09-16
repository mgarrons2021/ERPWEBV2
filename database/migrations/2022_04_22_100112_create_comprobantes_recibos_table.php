<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesRecibosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_recibos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nro_recibo');
            $table->unsignedBigInteger('compra_id');
            $table->timestamps();

            $table->foreign('compra_id')->on('compras')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comprobantes_recibos');
    }
}
