<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGastosAdministrativos extends Model
{
    use HasFactory;

    protected $table = "detalles_gasto_admin";

    protected $fillable = [
        'fecha',
        'egreso',
        'glosa',
        'tipo_comprobante',
        'nro_comprobante',
        'categoria_gasto_id',
        'gasto_administrativo_id',
        'para_costo'
    ];

    // public function gasto_administrativo(){
    //     return $this->belongsTo(GastosAdministrativos::class);
    // }
    // public function categoria_gastos_administrativos(){
    //     return $this->belongsTo(CategoriaGastosAdministrativos::class);
    // }

}
