<?php

namespace Database\Seeders;

use App\Models\Eliminacion;
use App\Models\Inventario;
use Illuminate\Database\Seeder;

class EliminacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eliminacion::create([
            'fecha' => '2022-10-03',
            'total' => 15.000,
            'estado' =>'Con Eliminacion',
            'user_id'=>3,
            'sucursal_id' => 11,
            'inventario_id' => 1,
            'turno_id' => 1
        ]);
        Eliminacion::create([
            'fecha' => '2022-10-03',
            'total' => 25.000,
            'estado' =>'Con Eliminacion',
            'user_id'=>3,
            'sucursal_id' => 11,
            'inventario_id' => 2,
            'turno_id' => 1
        ]);
        Eliminacion::create([
            'fecha' => '2022-10-04',
            'total' => 2.000,
            'estado' =>'Con Eliminacion',
            'user_id'=>3,
            'sucursal_id' => 11,
            'inventario_id' => 2,
            'turno_id' => 1
        ]);
    }
}
