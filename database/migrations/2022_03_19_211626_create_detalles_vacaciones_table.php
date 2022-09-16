<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallesVacacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalles_vacaciones', function (Blueprint $table) {
            $table->id();
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vacacion_id');

            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('vacacion_id')->on('vacaciones')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('detalles_vacaciones');
    }
}
