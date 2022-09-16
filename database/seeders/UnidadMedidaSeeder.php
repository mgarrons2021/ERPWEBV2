<?php

namespace Database\Seeders;

use App\Models\UnidadMedidaCompra;
use App\Models\UnidadMedidaVenta;
use Illuminate\Database\Seeder;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UnidadMedidaCompra::create([
            'nombre'=> 'Am',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Cj',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Kg',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Lb',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Lt',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Pqt',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Racimo',   
        ]);
        UnidadMedidaCompra::create([
            'nombre'=> 'Und',   
        ]);

        UnidadMedidaVenta::create([
            'nombre'=> 'Am',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Cj',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Kg',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Lb',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Lt',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Pqt',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Racimo',
        ]);
        UnidadMedidaVenta::create([
            'nombre'=> 'Und',
        ]);
    }
}
