<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InsumosDias;

class DiasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()//dia', 'tipo'
    {
        InsumosDias::create([
            'dia'=> 'todos',
            'tipo'=> 'I',           
        ]);        
        InsumosDias::create([
            'dia'=> 'lunes',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'martes',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'miercoles',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'jueves',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'viernes',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'sabado',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'domingo',
            'tipo'=> 'I',           
        ]);
        InsumosDias::create([
            'dia'=> 'indefinido',
            'tipo'=> 'I',           
        ]);
    }
}
