<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetGastoAdm extends Model
{
    use HasFactory;
    protected $table='det_gasto_adm';
    protected $fillable=[
        'fecha',
        'egreso',
        'glosa',
        'tipo_comprobante',
        'nro_comprobante',
        'gastos_administrativos_id',
        'categoria_gasto_id',
    ];

    public function categoria_gasto(){
        return $this->belongsTo(CategoriaGastosAdministrativos::class);
    }

    public function sub_categoria(){
        return $this->hasMany(CategoriaGastosAdministrativos::class);
    }
}
