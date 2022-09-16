<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoFactura extends Model
{
    use HasFactory;
    protected $table = "siat_tipos_facturas";

    protected $fillable = [
        'codigoClasificador',
        'descripcion',
    ];
}
