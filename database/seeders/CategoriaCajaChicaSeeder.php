<?php

namespace Database\Seeders;

use App\Models\CategoriaCajaChica;
use Illuminate\Database\Seeder;

class CategoriaCajaChicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaCajaChica::create([
            'nombre'=>"Gastos Por Prueba de Producto",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Trasporte de Adm",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Material de Limpieza",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Refrigerio y Alimentacion",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Gastos Generales",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Papeleria y Material de Oficina.",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Legales, Notariales y Tramites",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Anuncio en Periodico",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Mtto. Y Reparaciones de Oficina",
        ]);

        CategoriaCajaChica::create([
            'nombre'=>"Transporte de Insumos",
        ]);
    }
}
