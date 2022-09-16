<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesReciclajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_reciclaje', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio',18,4);
            $table->decimal('cantidad',18,4);
            $table->decimal('subtotal',18,4);
            $table->string('observacion')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('plato_id')->nullable();
            $table->unsignedBigInteger('reciclaje_id');
            $table->timestamps();

            $table->foreign('plato_id')->on('platos')->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('producto_id')->on('productos')->references('id');
            $table->foreign('reciclaje_id')->on('reciclajes')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_reciclaje');
    }
}
