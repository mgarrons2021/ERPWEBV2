<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMoneda extends Model
{
    use HasFactory;

    protected $table="siat_tipos_monedas";

    protected $fillable =[
        'codigoClasificador',
        'descripcion',
    ];
}
