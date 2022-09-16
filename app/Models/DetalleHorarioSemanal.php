<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleHorarioSemanal extends Model
{
    use HasFactory;
    protected $table='detalle_horarios_semanales';

    protected $fillable=[
        'fecha',
        'dia',
        'horario_semanale_id',
        'usuario_id',
    ];
}
