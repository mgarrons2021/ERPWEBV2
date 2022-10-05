<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keperi extends Model
{
    use HasFactory;
    protected $table = 'keperis';
    protected $fillable = [
    'fecha',
    'cantidad_kilos',
    'cantidad_crudo',
    'cantidad_marinado',
    'cantidad_enviado',
    'cantidad_cocido',
    'cantidad_cortado',
    'descuentos_bandejas',
    'nombre_usuario',
    'temperatura_maxima',
    'veces_volcado',

];
}
