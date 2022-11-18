<?php

namespace Database\Seeders;

use App\Models\DetalleCajaChica;
use Illuminate\Database\Seeder;

class DetalleCajaChicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetalleCajaChica::create([
            'ingreso' => 5.0,
            'glosa' => "none",
            'tipo_comprobante' => 'F',
            'nro_comprobante' => 123,
            'caja_chica_id' => 1,
            'categoria_caja_chica_id' => 1,
            'para_costo' => false
        ]);
        DetalleCajaChica::create([
            'ingreso' => 10.0,
            'glosa' => "none",
            'tipo_comprobante' => 'F',
            'nro_comprobante' => 124,
            'caja_chica_id' => 1,
            'categoria_caja_chica_id' => 2,
            'para_costo' => false
        ]);
        DetalleCajaChica::create([
            'ingreso' => 7.0,
            'glosa' => "none",
            'tipo_comprobante' => 'F',
            'nro_comprobante' => 125,
            'caja_chica_id' => 1,
            'categoria_caja_chica_id' => 3,
            'para_costo' => false
        ]);
        //nueva tanda
        DetalleCajaChica::create([
            'ingreso' => 8.0,
            'glosa' => "none",
            'tipo_comprobante' => 'F',
            'nro_comprobante' => 126,
            'caja_chica_id' => 1,
            'categoria_caja_chica_id' => 1,
            'para_costo' => false
        ]);
        DetalleCajaChica::create([
            'ingreso' => 5.0,
            'glosa' => "none",
            'tipo_comprobante' => 'F',
            'nro_comprobante' => 127,
            'caja_chica_id' => 1,
            'categoria_caja_chica_id' => 2,
            'para_costo' => false
        ]);
        DetalleCajaChica::create([
            'ingreso' => 8.0,
            'glosa' => "none",
            'tipo_comprobante' => 'F',
            'nro_comprobante' => 128,
            'caja_chica_id' => 1,
            'categoria_caja_chica_id' => 3,
            'para_costo' => false
        ]);
    }
}
