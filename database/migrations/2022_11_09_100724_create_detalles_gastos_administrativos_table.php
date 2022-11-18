<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesGastosAdministrativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_gastos_administrativos', function (Blueprint $table) {
            $table->id();
          
            $table->decimal('egreso',18,4);
            $table->string('glosa');
            $table->char('tipo_comprobante');
            $table->bigInteger('nro_comprobante');
            $table->unsignedBigInteger('gastos_administrativos_id');
            $table->unsignedBigInteger('categorias_gastos_administrativos_id');
            $table->boolean('para_costo');
            $table->unsignedBigInteger('sucursal');
            $table->timestamps();
            $table->foreign('gastos_administrativos_id')->on('gastos_administrativos')->references('id')->onDelete('cascade');
            $table->foreign('categorias_gastos_administrativos_id')->on('categorias_gastos_administrativos')->references('id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_gastos_administrativos');
    }
}
