<?php

namespace Database\Seeders;

use App\Models\Inventario;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inventario::create([
            'fecha' => '2022-10-03',
            'total' => 500.0000,
            'tipo_inventario' => 'D',
            'sucursal_id' => 11,
            'user_id'=>3,
            'turno_id' => 1
        ]);
        Inventario::create([
            'fecha' => '2022-10-03',
            'total' => 300.0000,
            'tipo_inventario' => 'D',
            'sucursal_id' => 11,
            'user_id'=>4,
            'turno_id' => 2
        ]);
        Inventario::create([
            'fecha' => '2022-10-04',
            'total' => 120.0000,
            'tipo_inventario' => 'D',
            'sucursal_id' => 11,
            'user_id'=>3,
            'turno_id' => 1
        ]);
        Inventario::create([
            'fecha' => '2022-10-04',
            'total' => 130.0000,
            'tipo_inventario' => 'D',
            'sucursal_id' => 11,
            'user_id'=>2,
            'turno_id' => 2
        ]);
    }
}
