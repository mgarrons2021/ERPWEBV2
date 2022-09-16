<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;
    protected $table = "siat_unidades_medidas";

    protected $fillable = [
        'codigoClasificador',
        'descripcion',
    ];
}
