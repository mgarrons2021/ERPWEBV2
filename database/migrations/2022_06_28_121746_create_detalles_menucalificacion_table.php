<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesMenucalificacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_menucalificacion', function (Blueprint $table) {
            $table->id();            
            $table->integer('sabor');  
            $table->text('estado');  
            $table->text('observacion');  
            $table->integer('presentacion');
            $table->unsignedBigInteger('plato_id')->nullable();
            $table->unsignedBigInteger('menu_calificacion_id')->nullable();
            $table->foreign('plato_id')->on('platos')->references('id')->onDelete('cascade');
            $table->foreign('menu_calificacion_id')->on('menucalificaciones')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('detalles_menucalificacion');
    }
}
