<?php

namespace Database\Seeders;

use App\Models\CajaChica;
use Illuminate\Database\Seeder;

class CajaChicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CajaChica::create([
            'fecha_compra' => '2022-11-01',
            'total_egreso' => 20,
            'user_id' => 3,
            'sucursal_id'=> 9,
        ]);
        CajaChica::create([
            'fecha_compra' => '2022-11-02',
            'total_egreso' => 50,
            'user_id' => 3,
            'sucursal_id'=> 9,
        ]);
        CajaChica::create([
            'fecha_compra' => '2022-11-03',
            'total_egreso' => 30,
            'user_id' => 3,
            'sucursal_id'=> 9,
        ]);     
    }
}
