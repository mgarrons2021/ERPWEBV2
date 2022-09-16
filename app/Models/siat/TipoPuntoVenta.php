<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPuntoVenta extends Model
{
    use HasFactory;

    protected $table = "siat_tipos_puntos_ventas";

    protected $fillable = [
        'codigoClasificador',
        'descripcion',
    ];
}
