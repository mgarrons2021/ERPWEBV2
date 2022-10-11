<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_ventas', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad',18,4);
            $table->decimal('precio',18,4);

            $table->decimal('descuento',18,4)->nullable();
            $table->decimal('subtotal',18,4);
            $table->decimal('subtotal_neto',18,4);

            $table->unsignedBigInteger('plato_id');
            $table->unsignedBigInteger('venta_id');

            $table->foreign('plato_id')->on('platos')->references('id');
            $table->foreign('venta_id')->on('ventas')->onDelete('cascade')->references('id');
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
        Schema::dropIfExists('detalles_ventas');
    }
}
