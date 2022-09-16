<?php

namespace Database\Seeders;

use App\Models\Turno;
use Illuminate\Database\Seeder;

class TurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Turno::create([
            'turno'=>'AM',
            'hora_inicio'=>'08:00:00',
            'hora_fin'=>'16:00:00',
            
        ]);
        Turno::create([
            'turno'=>'PM',
            'hora_inicio'=>'16:00:00',
            'hora_fin'=>'23:00:00',
            
        ]);
        
    }
}
