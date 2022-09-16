<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarea;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tarea::create([
            'nombre' => 'Registrar Inv. Diario',
            
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Ingreso',
            'dia_semana' => 'Lunes',
            'cargo_id' => 1,
            'sucursal_id' => 1
           
        ]);

        Tarea::create([
            'nombre' => 'Encender los pcs',
            
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Post Turno',
            'dia_semana' => 'Martes',
            'cargo_id' => 1,
            'sucursal_id' => 1
           
        ]);

        Tarea::create([
            'nombre' => 'Encender el ventilador',
            
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Pre Turno',
            'dia_semana' => 'Miercoles',
            'cargo_id' => 1,
            'sucursal_id' => 1
           
        ]);
        Tarea::create([
            'nombre' => 'Bajar los insumos del taxi',
            
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Despacho',
            'dia_semana' => 'Lunes',
            'cargo_id' => 1,
            'sucursal_id' => 1
           
        ]);
        Tarea::create([
            'nombre' => 'Almorzar en el comedor',
            
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Turno',
            'dia_semana' => 'Lunes',
            'cargo_id' => 1,
            'sucursal_id' => 1
           
        ]);
        Tarea::create([
            'nombre' => 'Revisar las redes y programar',
            'hora_inicio' => '10:30:20',
            'hora_fin' => '10:40:20',
            'turno' => 'Post Turno',
            'dia_semana' => 'Lunes',
            'cargo_id' => 1,
            'sucursal_id' => 1
           
        ]);
    }
}
