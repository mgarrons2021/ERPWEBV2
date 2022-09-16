
 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nro_autorizacion');
            $table->date('fecha_inicial');
            $table->date('fecha_fin');
            $table->integer('nro_factura');
            $table->string('llave');
            $table->bigInteger('nit');
            $table->integer('estado');
            $table->unsignedBigInteger('sucursal_id');
            $table->timestamps();

            $table->foreign('sucursal_id')->on('sucursals')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autorizaciones');
    }
}
