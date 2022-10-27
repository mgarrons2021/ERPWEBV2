<?php

namespace Database\Seeders;

use App\Models\DetallePedido;
use Illuminate\Database\Seeder;

class DetallePedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetallePedido::create([
            'cantidad_solicitada' => 2.0,
            'cantidad_enviada' => 2.0,
            'precio' => 4.0,
            'subtotal_solicitado' => 4.0,
            'subtotal_enviado' =>  4.0,
            'pedido_id' => 1,
            'producto_id' => 5
        ]);
        DetallePedido::create([
            'cantidad_solicitada' => 3.0,
            'cantidad_enviada' => 3.0,
            'precio' => 2.0,
            'subtotal_solicitado' => 2.0,
            'subtotal_enviado' =>  2.0,
            'pedido_id' => 1,
            'producto_id' => 13
        ]);
        DetallePedido::create([
            'cantidad_solicitada' => 1.0,
            'cantidad_enviada' => 1.0,
            'precio' => 5.0,
            'subtotal_solicitado' => 5.0,
            'subtotal_enviado' =>  5.0,
            'pedido_id' => 1,
            'producto_id' => 9
        ]);

        DetallePedido::create([
            'cantidad_solicitada' => 3.0,
            'cantidad_enviada' => 3.0,
            'precio' => 2.0,
            'subtotal_solicitado' => 2.0,
            'subtotal_enviado' =>  2.0,
            'pedido_id' => 2,
            'producto_id' => 10
        ]);
        DetallePedido::create([
            'cantidad_solicitada' => 1.0,
            'cantidad_enviada' => 1.0,
            'precio' => 4.0,
            'subtotal_solicitado' => 4.0,
            'subtotal_enviado' =>  4.0,
            'pedido_id' => 2,
            'producto_id' => 4
        ]);
        DetallePedido::create([
            'cantidad_solicitada' => 3.0,
            'cantidad_enviada' => 3.0,
            'precio' => 8.0,
            'subtotal_solicitado' => 8.0,
            'subtotal_enviado' =>  8.0,
            'pedido_id' => 2,
            'producto_id' => 2
        ]);
       
    }
}
