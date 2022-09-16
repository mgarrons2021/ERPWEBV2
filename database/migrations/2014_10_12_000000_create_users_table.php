<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     *
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->string('name')->nullable();
            $table->string('apellido')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('ci')->nullable();
            $table->integer('celular_personal')->nullable();
            $table->integer('celular_referencia')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('zona')->nullable();
            $table->integer('codigo')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->boolean('estado')->nullable();
            $table->unsignedBigInteger('tipo_usuario_id')->nullable();          
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('tipo_usuario_id')->references('id')->on('tipo_usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
