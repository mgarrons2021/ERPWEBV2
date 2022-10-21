<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostoTotal extends Model
{
    use HasFactory;
   // protected $table = 'departamentos';
    protected $fillable = [
                            'fecha',
                            'ventas',
                            'produccion_enviada',
                            'porcentaje_produccion_enviada',
                            'parte_de_produccion',
                            'porcentaje_parte_de_prudcuccion',
                            'compras_de_insumos',
                            'porcentaje_compras_de_insumo',
                            'eliminaciones',
                            'porcentaje_eliminaciones',
                            'comida_personal',
                            'porcentaje_comida_personal',
                            'total_uso',
                            'total_uso_pp',
                            'porcentaje_total_uso',
                            'porcentaje_total_uso_pp',
                        ];

}
