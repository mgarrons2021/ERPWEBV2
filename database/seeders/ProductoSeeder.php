<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Producto::Create([
            'codigo' => 1010,
            'nombre' => 'Alitas de Pollo',
            'estado' => 1,
            'categoria_id' => 10,
            'unidad_medida_compra_id' => 3,
            'unidad_medida_venta_id' => 3,
        ]);
        Producto::Create([
            'codigo' => 1011,
            'nombre' => 'Albondigas',
            'estado' => 1,
            'categoria_id' => 2,
            'unidad_medida_compra_id' => 3,
            'unidad_medida_venta_id' => 3,
        ]);
        Producto::Create([
            'codigo' => 1012,
            'nombre' => 'Ace Patito',
            'estado' => 1,
            'categoria_id' => 5,
            'unidad_medida_compra_id' => 6,
            'unidad_medida_venta_id' => 8,
        ]);
        Producto::Create([
            'codigo' => 1013,
            'nombre' => 'Aquarius Pomelo 2lts',
            'estado' => 1,
            'categoria_id' => 4,
            'unidad_medida_compra_id'=>6,
            'unidad_medida_venta_id'=>8,
        ]);
        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Bolsa Arrobera',
            'estado' => 1,
            'categoria_id' => 6,
            'unidad_medida_compra_id'=>2,
            'unidad_medida_venta_id'=>8,
        ]);

        
        /* Para reporte de Zumos y salzas */
        Producto::Create([
            'codigo' => 2022,
            'nombre' => 'Zumo de Limon de Licuar',
            'estado' => 1,
            'categoria_id' => 7,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        Producto::Create([
            'codigo' => 2023,
            'nombre' => 'Zumo de Naranja',
            'estado' => 1,
            'categoria_id' => 7,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Llajwa',
            'estado' => 1,
            'categoria_id' => 6,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Salsa Verde',
            'estado' => 1,
            'categoria_id' => 14,
            'unidad_medida_compra_id'=>5,
            'unidad_medida_venta_id'=>5,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Salsa Blanca',
            'estado' => 1,
            'categoria_id' => 14,
            'unidad_medida_compra_id'=>5,
            'unidad_medida_venta_id'=>5
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Salsa Roja',
            'estado' => 1,
            'categoria_id' => 14,
            'unidad_medida_compra_id'=>5,
            'unidad_medida_venta_id'=>5,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Limon de Licuar',
            'estado' => 1,
            'categoria_id' => 7,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Naranja',
            'estado' => 1,
            'categoria_id' => 7,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Chimichurri',
            'estado' => 1,
            'categoria_id' => 7,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        Producto::Create([
            'codigo' => 1014,
            'nombre' => 'Lima',
            'estado' => 1,
            'categoria_id' => 7,
            'unidad_medida_compra_id'=>3,
            'unidad_medida_venta_id'=>3,
        ]);

        
    }
}
