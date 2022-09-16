<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEmision extends Model
{
    use HasFactory;

    protected $table = "siat_tipos_emisiones";
    
    protected $fillable=[
        'codigoClasificador',
        'descripcion',
    ];
}
