<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_inventario', function (Blueprint $table) {
            $table->id();
            $table->integer('stock');
            $table->decimal('precio',18,4);
            $table->decimal('subtotal',18,4);

            $table->unsignedBigInteger('producto_id')->nullable();
            $table->unsignedBigInteger('inventario_id');
            $table->unsignedBigInteger('plato_id')->nullable();
            
            $table->timestamps();
            
            $table->foreign('producto_id')->on('productos')->references('id');
            $table->foreign('inventario_id')->on('inventarios')->references('id')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('plato_id')->on('platos')->references('id')->onDelete('cascade')->onUpdate('cascade');
                                                                                               
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_inventario');
    }
}
