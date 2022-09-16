<?php

namespace Database\Seeders;

use App\Models\Contrato;
use Illuminate\Database\Seeder;

class ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contrato::create([
            'tipo_contrato'=>'Contrato Basico',
            'sueldo'=>2122,
            'duracion_contrato'=>'Tres meses',
        ]);
        Contrato::create([
            'tipo_contrato'=>'Contrato Medio',
            'sueldo'=>2122,
            'duracion_contrato'=>'Una gestion',
        ]);
        Contrato::create([
            'tipo_contrato'=>'Contrato Avanzado',
            'sueldo'=>2122,
            'duracion_contrato'=>'Cinco gestiones',
        ]);
    }
}
