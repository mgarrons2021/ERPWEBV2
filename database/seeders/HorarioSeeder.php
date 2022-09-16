<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
        Horario::create([
            'hora_ingreso'=> '08:30',
            'hora_salida_fija'=> '16:30',
            'turno'=>'AM',
            'sucursal_id' =>3,
            'user_id'=> 1,
           
        ]);
        Horario::create([
            'hora_ingreso'=> '08:30',
            'hora_salida_fija'=> '16:30',
            'turno'=>'AM',
            'sucursal_id' =>4,
            'user_id'=> 2,

        ]);
        Horario::create([
            'hora_ingreso'=> '16:30',
            'hora_salida_fija'=> '23:30',
            'turno'=>'PM',
            'sucursal_id' =>5,
            'user_id'=> 3,

        ]);

        Horario::create([
            'hora_ingreso'=> '16:30',
            'hora_salida_fija'=> '23:30',
            'turno'=>'PM',
            'sucursal_id' =>6,
            'user_id'=> 4,

        ]);
    }
}
