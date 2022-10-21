<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCajaChica extends Model
{
    use HasFactory;

    protected $table = "detalles_caja_chica";

    protected $fillable = [
        'egreso',
        'glosa',
        'tipo_comprobante',
        'nro_comprobante',
        'categoria_caja_chica_id',
        'caja_chica_id',
        'para_costo'
    ];

    public function caja_chica(){
        return $this->belongsTo(CajaChica::class);
    }

    public function categoria_caja_chica(){
        return $this->belongsTo(CategoriaCajaChica::class);
    }

}
