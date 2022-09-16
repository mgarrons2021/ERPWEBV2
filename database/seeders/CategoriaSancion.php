<?php

namespace Database\Seeders;

use App\Models\CategoriaSancion as ModelsCategoriaSancion;
use Illuminate\Database\Seeder;

class CategoriaSancion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsCategoriaSancion::create ([
            'nombre'=>'Llamada de atención',
        ]);
        ModelsCategoriaSancion::create ([
            'nombre'=>'Sancion con descuento',
        ]);
        ModelsCategoriaSancion::create ([
            'nombre'=>'Sancion grave',
        ]);
    }
}
