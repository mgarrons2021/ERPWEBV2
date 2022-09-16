<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create ([
            'nombre'=>'Departamento de Sistemas',
            'descripcion'=>'Dpto encargadado de implementar el sistema para la empresa',
        ]);
        Departamento::create ([
            'nombre'=>'Departamento de Contabilidad',
            'descripcion'=>'Dpto encargado de llevar la contabilidad de la empresa',
        ]);
        Departamento::create ([
            'nombre'=>'Departamento de RRHH',
            'descripcion'=>'Dpto encargadado de gestionar contratacion de nuevo personal',
        ]);
        Departamento::create ([
            'nombre'=>'Departamento de Comercio',
            'descripcion'=>'Dpto encargado de publicidad',
        ]);
    }
}
