<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMantenimiento extends Model
{
    use HasFactory;

    protected $table = "detalles_mantenimiento";

    protected $fillable = [
        'egreso',
        'glosa',
        'foto',
        'categoria_caja_chica_id',
        'mantenimiento_id',
    ];

    public function mantenimiento(){
        return $this->belongsTo(Mantenimiento::class);
    }

    public function categoria_caja_chica(){
        return $this->belongsTo(CategoriaCajaChica::class);
    }

}
