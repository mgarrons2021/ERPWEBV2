<?php

namespace Database\Seeders;

use App\Models\CargoSucursal;
use App\Models\CargoSucursalUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class CargoSucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoSucursal::create([
            'nombre_cargo'=>'Cajero Encargado',
            'descripcion'=>'Funcionario Encargado de la sucursal',
        ]);
        CargoSucursal::create([
            'nombre_cargo'=>'Cajero',
            'descripcion'=>'Cajero de la sucursal',
        ]);
        CargoSucursal::create([
            'nombre_cargo'=>'Cocinero',
            'descripcion'=>'Funcionario Encargado de la cocina',
        ]);
        CargoSucursal::create([
            'nombre_cargo'=>'Parrilla',
            'descripcion'=>'Funcionario Encargado de la parilla',
        ]);
        CargoSucursal::create([
            'nombre_cargo'=>'Atencion',
            'descripcion'=>'Funcionario Encargado de la atencion al cliente',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Jefe de Sistemas',
            'descripcion'=>'Funcionario encargado del sistema de la Empresa',
        ]);

        
        CargoSucursal::create([
            'nombre_cargo'=>'Jefe de Mantenimiento',
            'descripcion'=>'Funcionario encargado de preservar la infraestructura de la empresa',
        ]);
        
      
        CargoSucursal::create([
            'nombre_cargo'=>'Jefe de Compras',
            'descripcion'=>'Funcionario encargado de gestionar proveedores y compras',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Jefe de Contabilidad',
            'descripcion'=>'Funcionario encargado de llevar la contabilidad de la empresa',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Jefe Comercial',
            'descripcion'=>'Funcionario encargado de la Brand de la Empresa',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Auxiliar Contable',
            'descripcion'=>'Funcionario encargado de apoyar en contabilidad  ',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Auxiliar de Sistemas',
            'descripcion'=>'Funcionario encargado de apoyar al sistema',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Programador',
            'descripcion'=>'Programador de la empresa',
        ]);


        CargoSucursal::create([
            'nombre_cargo'=>'Gerente General',
            'descripcion'=>'Funcionario encargado de administrar la empresa',
        ]);


       

        CargoSucursal::create([
            'nombre_cargo'=>'Encargado/a de RRHH',
            'descripcion'=>'Funcionario encargado de gestionar personal',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Cheff Corporativo',
            'descripcion'=>'Funcionario encargado de la elaboracion y produccion en la empresa',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Encargado de Almacen',
            'descripcion'=>'Funcionario encargado del almacen de la Empresa',
        ]);

        CargoSucursal::create([
            'nombre_cargo'=>'Auxiliar de Almacen',
            'descripcion'=>'Auxiliar de Almacen Funcionario encargado del sistema de la Empresa',
        ]);
        CargoSucursal::create([
            'nombre_cargo'=>'Encargada de Limpieza',
            'descripcion'=> 'Encargada de Limpieza de la empresa',
        ]);


        








        $user=User::find(1);
        $user->cargosucursals()->sync([1]);

        $user=User::find(2);
        $user->cargosucursals()->sync([2]);

        $user=User::find(3);
        $user->cargosucursals()->sync([3]);

        $user=User::find(4);
        $user->cargosucursals()->sync([4]);
    }
}
