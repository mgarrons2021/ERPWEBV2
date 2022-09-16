<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesTraspasoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_traspaso', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio',18,4);
            $table->decimal('cantidad',18,4);
            $table->decimal('subtotal',18,4);
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('traspaso_id');
            $table->timestamps();

            $table->foreign('producto_id')->on('productos')->references('id');
            $table->foreign('traspaso_id')->on('traspasos')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_traspaso');
    }
}
