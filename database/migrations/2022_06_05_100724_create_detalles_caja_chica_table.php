<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesCajaChicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_caja_chica', function (Blueprint $table) {
            $table->id();
          
            $table->decimal('egreso',18,4);
            $table->string('glosa');
            $table->char('tipo_comprobante');
            $table->bigInteger('nro_comprobante');
            $table->unsignedBigInteger('caja_chica_id');
            $table->unsignedBigInteger('categoria_caja_chica_id');
            $table->boolean('para_costo');
            $table->timestamps();
            $table->foreign('caja_chica_id')->on('cajas_chicas')->references('id')->onDelete('cascade');
            $table->foreign('categoria_caja_chica_id')->on('categorias_caja_chica')->references('id');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalles_caja_chica');
    }
}
