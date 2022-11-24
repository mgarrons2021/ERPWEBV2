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
        'gastos_administrativos_id',
     
    ];
    public function sub_categoria(){
        return $this->hasMany(CategoriaGastosAdministrativos::class);
    }

    // public function categoria_gasto_adm(){
    //     return $this->belongsTo(CategoriaGastosAdministrativos::class);
    // }
    public function categoria_gasto(){
        return $this->belongsTo(CategoriaGastosAdministrativos::class);
    }
}
