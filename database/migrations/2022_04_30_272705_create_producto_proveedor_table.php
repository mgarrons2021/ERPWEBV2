<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_proveedor', function (Blueprint $table) {
            $table->id();
            $table->decimal('precio',10,4);
            $table->date('fecha');
            $table->string('estado')->default('Habilitado');

            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('sucursal_id');
            
            $table->foreign('producto_id') ->on('productos')->references('id')->onDelete('cascade');
            $table->foreign('proveedor_id') ->on('proveedores')->references('id')->onDelete('cascade'); 
            $table->foreign('sucursal_id')->on('sucursals')->references('id')->onDelete('cascade');

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
        Schema::dropIfExists('producto_proveedor');
    }
}
