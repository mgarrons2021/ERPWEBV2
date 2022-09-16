<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleMenusSemanalesTable extends Migration
{
    /**
     * Run the migration
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_menus_semanales', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('plato_id');
            $table->unsignedBigInteger('menu_semanal_id');

            $table->foreign('plato_id')->on('platos')->references('id') ; 
            $table->foreign('menu_semanal_id')->on('menus_semanales')->references('id')->onDelete('cascade') ; 
            
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
        Schema::dropIfExists('detalle_menus_semanales');
    }
}
