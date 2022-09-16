<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::Create([
            'nombre'=> 'Produccion'
        ]);
        Categoria::Create([
            'nombre'=> 'Abarrotes'
        ]);
        Categoria::Create([
            'nombre'=> 'Alimentos'
        ]);
        Categoria::Create([
            'nombre'=> 'Bebidas'
        ]);
        Categoria::Create([
            'nombre'=> 'Material de Limpieza'
        ]);
        Categoria::Create([
            'nombre'=> 'Plasticos'
        ]);
        Categoria::Create([
            'nombre'=> 'Zumos'
        ]);
        Categoria::Create([
            'nombre'=> 'Verduras'
        ]);
        Categoria::Create([
            'nombre'=> 'Insumos Para Refrescos'
        ]);
        Categoria::Create([
            'nombre'=> 'Pollos'
        ]);
        Categoria::Create([
            'nombre'=> 'Carnes'
        ]);
        Categoria::Create([
            'nombre'=> 'Insumos Procesados'
        ]);

        Categoria::Create([
            'nombre'=> 'Lacteos y Fiambres'
        ]);
        Categoria::Create([
            'nombre'=> 'Salzas'
        ]);
    }
}
