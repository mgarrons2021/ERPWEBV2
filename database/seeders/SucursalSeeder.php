<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sucursal;

class SucursalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sucursales = [
            array ('nombre' => 'Sin Definir','direccion'=> 'sin definir ','correo'=>'sindefinir@gmail.com','nro_fiscal'=>'7777F', 'estado'=>1,'codigo_fiscal'=>35),
            array ('nombre' => 'Bodega Principal','direccion'=> '2do anillo ','correo'=>'donesco@gmail.com','nro_fiscal'=>'7777F', 'estado'=>1,'codigo_fiscal'=>36),

            array ('nombre' => 'Suc. 3 pasos','direccion'=> 'Av. Tres Pasos al Frente, Edif. hipermaxi','correo'=>'SUCPASOS@gmail.com','nro_fiscal'=>'2504A', 'estado'=>1,'codigo_fiscal'=>3),
            array ('nombre' => 'Suc. Plan 3000','direccion'=>'Av. Paurito Zona PLan 3000','correo'=>'plan@gmail.com','nro_fiscal'=>'4433B', 'estado'=>1 , 'codigo_fiscal'=>8),

            array ('nombre' => 'Suc. Cine Center','direccion'=>'Av. El trompillo edif. cine center' ,'correo'=>'','nro_fiscal'=>'7645C', 'estado'=>1, 'codigo_fiscal'=>13),
            
            array ('nombre' => 'Suc. Villa','direccion'=> 'Av.Principal 1ero de Mayo Edif. Hipermax','correo'=>'','nro_fiscal'=>'7856F', 'estado'=>1, 'codigo_fiscal'=>11),
            array ('nombre' => 'Suc. Villa 2','direccion'=> 'Calle 5, Frente a la plaza principal villa 1ero','correo'=>'','nro_fiscal'=>'8763G', 'estado'=>1, 'codigo_fiscal'=>17),
            array ('nombre' => 'Suc. Roca','direccion'=> 'Av. Roca y Coronado, Edif. hipermaxi','correo'=>'','nro_fiscal'=>'9836H', 'estado'=>1, 'codigo_fiscal'=>10),
            array ('nombre' => 'Suc. Palmas','direccion'=> 'Av. 4to Anillo, Edif. hipermaxi Las palmas','correo'=>'','nro_fiscal'=>'1297I', 'estado'=>1, 'codigo_fiscal'=>2),
            array ('nombre' => 'Suc. Mutualista','direccion'=>'Edif. Hipermaxi Mutualista Piso Patio Comidas ','correo'=>'','nro_fiscal'=>'8372J', 'estado'=>1, 'codigo_fiscal'=>12),
            array ('nombre' => 'Suc. Pampa','direccion'=> 'Av. 4to Anillo, Zona Pampa de la isla','correo'=>'','nro_fiscal'=>'0283K', 'estado'=>1, 'codigo_fiscal'=>4),
            array ('nombre' => 'Suc. Sur','direccion'=>'Av. 3er anillo externo y Av. Santos Dumont','correo'=>'','nro_fiscal'=>'8235L', 'estado'=>1, 'codigo_fiscal'=>0),
            array ('nombre' => 'Suc. Bajio' ,'direccion'=> 'Doble Via la Guardia Km.6 Zona El bajio','correo'=>'','nro_fiscal'=>'9273M', 'estado'=>1, 'codigo_fiscal'=>7),
            array ('nombre' => 'Suc. Radial 26' ,'direccion'=> 'Av. 4to Anillo, Edif. hipermaxi Radial 26','correo'=>'','nro_fiscal'=>'8362N', 'estado'=>1, 'codigo_fiscal'=>5)
        
        ];
        Sucursal::insert($sucursales);
    }
}
