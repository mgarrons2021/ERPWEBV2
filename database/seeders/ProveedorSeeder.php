<?php

namespace Database\Seeders;

use App\Models\Producto_Proveedor;
use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use Carbon\Carbon;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proveedor::Create([
            'nombre' => 'Sofia',
            'estado' =>1
        ]);
        Proveedor::Create([
            'nombre' => 'Frigor',
            'estado' =>1

        ]);
        Proveedor::Create([
            'nombre' => 'Impastas S.A.',
            'estado' =>1

        ]);
        Proveedor::Create([
            'nombre' => 'EMBOL SA',
            'estado' =>1

        ]);
        Proveedor::Create([
            'nombre' => 'MAXIMILIANA',
            'estado' =>1

        ]);
        Producto_Proveedor::create([
            'precio' => 10.35,
            'fecha' => Carbon::now(),
            'producto_id' => 1,
            'proveedor_id' => 2,
            'sucursal_id' => 2,
        ]);
        Producto_Proveedor::create([
            'precio' => 3.35,
            'fecha' => Carbon::now(),
            'producto_id' => 1,
            'proveedor_id' => 3,
            'sucursal_id' => 2,
        ]);
        Producto_Proveedor::create([
            'precio' => 3.35,
            'fecha' => Carbon::now(),
            'producto_id' => 1,
            'proveedor_id' => 1,
            'sucursal_id' => 2,
        ]);
        Producto_Proveedor::create([
            'precio' => 6.5,
            'fecha' => Carbon::now(),
            'producto_id' => 2,
            'proveedor_id' => 3,
            'sucursal_id' => 2,
        ]);
        Producto_Proveedor::create([
            'precio' => 8.5,
            'fecha' => Carbon::now(),
            'producto_id' => 4,
            'proveedor_id' => 4,
            'sucursal_id' => 2,
        ]);
        Producto_Proveedor::create([
            'precio' => 8.5,
            'fecha' => Carbon::now(),
            'producto_id' => 3,
            'proveedor_id' => 4,
            'sucursal_id' => 2,
        ]);
        Producto_Proveedor::create([
            'precio' => 15.6,
            'fecha' => Carbon::now(),
            'producto_id' => 5,
            'proveedor_id' => 3,
            'sucursal_id' => 2,
        ]);
    }
}
