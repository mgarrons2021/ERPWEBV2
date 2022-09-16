<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesCompraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_compra', function (Blueprint $table) {
            $table->id();
            $table->float('cantidad');
            $table->decimal('precio_compra',18,4);
            $table->decimal('subtotal',18,4);
            $table->unsignedBigInteger('compra_id');
            $table->unsignedBigInteger('producto_id');
            $table->timestamps();

            $table->foreign('producto_id')->on('productos')->references('id');
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
        Schema::dropIfExists('detalles_compra');
    }
}
