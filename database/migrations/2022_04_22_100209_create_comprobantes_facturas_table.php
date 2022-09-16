<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_facturas', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_factura');
            $table->bigInteger('numero_autorizacion')->nullable();
            $table->string('codigo_control')->nullable();

            $table->unsignedBigInteger('compra_id');
            $table->foreign('compra_id')->on('compras')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('comprobantes_facturas');
    }
}
