<?php

use App\Models\Contrato;
use App\Models\Sucursal;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_contratos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio_contrato');
            $table->date('fecha_fin_contrato');
            $table->string('disponibilidad');
            $table->unsignedBigInteger('contrato_id');
            $table->unsignedBigInteger('user_id');
           /*  $table->foreignIdFor(Contrato::class);
            $table->foreignIdFor(User::class); */
            $table->timestamps();

            $table->foreign('contrato_id')->on('contratos')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_contratos');
    }
}
