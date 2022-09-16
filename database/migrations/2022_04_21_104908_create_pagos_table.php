<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tipo_pago')->nullable();
            $table->string('banco')->nullable();
            $table->integer('nro_cuenta')->nullable();
            $table->integer('nro_comprobante')->nullable();
            $table->integer('nro_cheque')->nullable();
            $table->decimal('total',18,4)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->on('sucursals')->references('id');
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->foreign('proveedor_id')->on('proveedores')->references('id');
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
        Schema::dropIfExists('pagos');
    }
}
