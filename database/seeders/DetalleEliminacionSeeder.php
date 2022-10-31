<?php

namespace Database\Seeders;

use App\Models\DetalleEliminacion;
use Illuminate\Database\Seeder;

class DetalleEliminacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetalleEliminacion::create([
            'precio' => 12.0,
            'cantidad' => 1.0,
            'subtotal' => 23.0,
            'observacion' => "none",
            'producto_id' => 5,

            'eliminacion_id' => 1
        ]);
        DetalleEliminacion::create([
            'precio' => 13.0,
            'cantidad' => 1.0,
            'subtotal' => 13.0,
            'observacion' => "none",
            'producto_id' => 13,

            'eliminacion_id' => 1
        ]);
        DetalleEliminacion::create([
            'precio' => 2.0,
            'cantidad' => 1.0,
            'subtotal' => 2.0,
            'observacion' => "none",
            'producto_id' => 7,

            'eliminacion_id' => 1
        ]);
        DetalleEliminacion::create([
            'precio' => 12.0,
            'cantidad' => 2.0,
            'subtotal' => 12.0,
            'observacion' => "none",
            'producto_id' => 10,

            'eliminacion_id' => 2
        ]);
        DetalleEliminacion::create([
            'precio' => 10.0,
            'cantidad' => 1.0,
            'subtotal' => 10.0,
            'observacion' => "none",
            'producto_id' => 4,

            'eliminacion_id' => 2
        ]);
        DetalleEliminacion::create([
            'precio' => 8.0,
            'cantidad' => 1.0,
            'subtotal' => 8.0,
            'observacion' => "none",
            'producto_id' => 7,

            'eliminacion_id' => 2
        ]);
    }
}
