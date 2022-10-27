<?php

namespace Database\Seeders;

use App\Models\Pedido;
use Illuminate\Database\Seeder;

class PedidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pedido::Create([
            'id' => 1,
            'fecha_actual' => '2022-10-03',
            'fecha_pedido' => '2022-10-03',
            'total_solicitado' => 10,
            'total_enviado' => 10,
            'estado' => 'A',
            'estado_impresion' => 'N',
            'user_id' =>1,
            'sucursal_principal_id' => 11,
            'sucursal_secundaria_id' => 2
        ]);
        Pedido::Create([
            'id' => 2,
            'fecha_actual' => '2022-10-04',
            'fecha_pedido' => '2022-10-04',
            'total_solicitado' => 25,
            'total_enviado' => 20,
            'estado' => 'A',
            'estado_impresion' => 'N',
            'user_id' =>1,
            'sucursal_principal_id' => 11,
            'sucursal_secundaria_id' => 2
        ]);
    }
}
