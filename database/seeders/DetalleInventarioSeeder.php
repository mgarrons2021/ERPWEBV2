<?php

namespace Database\Seeders;

use App\Models\DetalleInventario;
use Illuminate\Database\Seeder;

class DetalleInventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetalleInventario::create([
            'stock' => 3,
            'precio' => 15.0,
            'subtotal' => 15.0,
            'producto_id' => 5,
            'inventario_id' => 1,
      
        ]);
        DetalleInventario::create([
            'stock' => 4,
            'precio' => 55.0,
            'subtotal' => 55.0,
            'producto_id' => 13,
            'inventario_id' => 1,
      
        ]);  DetalleInventario::create([
            'stock' => 1,
            'precio' => 10.0,
            'subtotal' => 10.0,
            'producto_id' => 10,
            'inventario_id' => 2,
 
        ]);  DetalleInventario::create([
            'stock' => 2,
            'precio' => 22.0,
            'subtotal' => 22.0,
            'producto_id' => 4,
            'inventario_id' => 2,
      
        ]);  DetalleInventario::create([
            'stock' => 1,
            'precio' => 10.0,
            'subtotal' => 10.0,
            'producto_id' => 15,
            'inventario_id' => 1,
 
        ]);  DetalleInventario::create([
            'stock' => 3,
            'precio' => 12.0,
            'subtotal' => 12.0,
            'producto_id' => 2,
            'inventario_id' => 2,
 
        ]);  DetalleInventario::create([
            'stock' => 2,
            'precio' => 13.0,
            'subtotal' => 13.0,
            'producto_id' => 1,
            'inventario_id' => 1,
 
        ]);  DetalleInventario::create([
            'stock' => 5,
            'precio' => 7.0,
            'subtotal' => 7.0,
            'producto_id' => 6,
            'inventario_id' => 2,
      
        ]);
    }
}
