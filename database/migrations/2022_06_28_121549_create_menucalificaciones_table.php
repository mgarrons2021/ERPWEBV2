<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenucalificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */  
    public function up()
    {
        Schema::create('menucalificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_semanal_id')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->unsignedBigInteger('sucursal_id')->nullable();
            $table->decimal('promedio',10,4);
            $table->foreign('menu_semanal_id')->on('menus_semanales')->references('id')->onDelete('cascade');
            $table->foreign('usuario_id')->on('users')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('menucalificaciones');
    }
}
