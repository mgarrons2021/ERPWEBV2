<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    use HasFactory;

    protected $table = "siat_tipos_habitaciones";

    protected $fillable =[
        'codigoClasificador',
        'descripcion',
    ];
}
