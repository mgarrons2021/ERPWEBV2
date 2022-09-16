<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleManosObrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_manos_obras', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad_horas',18,4);
            
            $table->decimal('subtotal_costo',18,4);

            $table->unsignedBigInteger('mano_obra_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('mano_obra_id')->on('manos_obras')->references('id');
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
        Schema::dropIfExists('detalle_manos_obras');
    }
}
