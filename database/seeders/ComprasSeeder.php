<?php

namespace Database\Seeders;

use App\Models\Compra;
use Illuminate\Database\Seeder;

class ComprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Compra::create([
            'fecha_compra' => '2022-10-03',
            'tipo_comprobante' => 'none',
            'estado' => 'none',
            'glosa' => 'none',
            'total' => 25.0,
            'user_id' => 2,
            'sucursal_id'=> 11,
            'proveedor_id' => 4,
        ]);
        Compra::create([
            'fecha_compra' => '2022-10-04',
            'tipo_comprobante' => 'none',
            'estado' => 'none',
            'glosa' => 'none',
            'total' => 39.0,
            'user_id' => 3,
            'sucursal_id'=> 11,
            'proveedor_id' => 3,
        ]);
        Compra::create([
            'fecha_compra' => '2022-10-03',
            'tipo_comprobante' => 'none',
            'estado' => 'none',
            'glosa' => 'none',
            'total' => 27.0,
            'user_id' => 2,
            'sucursal_id'=> 11,
            'proveedor_id' => 5,
        ]);
    }
}
