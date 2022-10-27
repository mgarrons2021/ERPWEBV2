<?php

namespace Database\Seeders;

use App\Models\Compra;
use App\Models\DetalleCompra;
use Illuminate\Database\Seeder;

class DetalleCompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetalleCompra::create([
            'cantidad' => 2.0,
            'precio_compra' => 14.0,
            'subtotal' => 14.0,
            'compra_id' => 1,
            'producto_id' => 5
        ]);
        DetalleCompra::create([
            'cantidad' => 1.0,
            'precio_compra' => 10.00,
            'subtotal' => 10.00,
            'compra_id' => 1,
            'producto_id' => 13
        ]);
        DetalleCompra::create([
            'cantidad' => 1.0,
            'precio_compra' => 5.00,
            'subtotal' => 5.00,
            'compra_id' => 2,
            'producto_id' => 10
        ]);
        DetalleCompra::create([
            'cantidad' => 5.0,
            'precio_compra' => 8.00,
            'subtotal' => 8.00,
            'compra_id' => 2,
            'producto_id' => 4
        ]);
        DetalleCompra::create([
            'cantidad' => 3.0,
            'precio_compra' => 25.00,
            'subtotal' => 25.00,
            'compra_id' => 1,
            'producto_id' => 15
        ]);
        DetalleCompra::create([
            'cantidad' => 4.0,
            'precio_compra' => 9.00,
            'subtotal' => 9.00,
            'compra_id' => 2,
            'producto_id' => 2
        ]);
        DetalleCompra::create([
            'cantidad' => 1.0,
            'precio_compra' => 12.00,
            'subtotal' => 12.00,
            'compra_id' => 1,
            'producto_id' => 12
        ]);
        DetalleCompra::create([
            'cantidad' => 2.0,
            'precio_compra' => 7.00,
            'subtotal' => 7.00,
            'compra_id' => 1,
            'producto_id' => 14
        ]);
    }
}
