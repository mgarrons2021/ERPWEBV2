<?php

namespace Database\Seeders;
use App\Models\TipoUsuario;
use Illuminate\Database\Seeder;

class TipoUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoUsuario::Create([
            'tipo'=>'Admin', //Dpto de Sistemas
        ]);
        TipoUsuario::Create([
            'tipo'=>'Encargado', //Encargados de Sucursales
        ]);

        TipoUsuario::Create([
            'tipo'=>'Trabajador', //Personal de rrhh y contabilidad
        ]);
      
    }
}
