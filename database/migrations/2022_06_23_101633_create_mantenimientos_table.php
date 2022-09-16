<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMantenimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->decimal('total_egreso',18,4)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('user_id')->on ('users')-> references('id');
            $table->foreign('sucursal_id')->on ('sucursals')-> references('id');
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
        Schema::dropIfExists('mantenimientos');
    }
}
