|<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_venta');
            $table->time('hora_venta');
            $table->integer('numero_factura')->nullable();
            $table->integer('nro_transaccion');
            $table->decimal('total_venta',18,4)->nullable();
            $table->decimal('total_descuento',18,4)->nullable();
            $table->decimal('total_neto',18,4)->nullable();
            $table->string('tipo_pago');
            $table->string('lugar');
            $table->string('estado'); /* Estado Anulacion Siat */
            $table->char('estado_emision')->default("R"); /* Si se emitio al servidor de Impuestos (V- VALIDADA , R- RECHAZADA) */
            $table->string('nombre_delivery')->nullable();
            $table->string('codigo_control')->nullable();
            $table->string('cuf')->nullable();

            $table->string('qr',300)->nullable();
            
            $table->unsignedBigInteger('cufd_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('sucursal_id'); 
            $table->unsignedBigInteger('turnos_ingreso_id')->nullable();
            $table->unsignedBigInteger('autorizacion_id')->nullable();
            $table->unsignedBigInteger('evento_significativo_id')->nullable();

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('cufd_id')->on('siat_cufds')->references('id');
            $table->foreign('cliente_id')->on('clientes')->references('id');
            $table->foreign('sucursal_id')->on('sucursals')->references('id');
            $table->foreign('turnos_ingreso_id')->on('turnos_ingresos')->references('id');
            $table->foreign('autorizacion_id')->on('autorizaciones')->references('id');
            
            $table->foreign('evento_significativo_id')->on('siat_eventos_significativos')->references('id');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('ventas');
    }

}
