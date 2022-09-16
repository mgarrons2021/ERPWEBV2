<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioSemanal extends Model
{
    use HasFactory;
    protected $table='horarios_semanales';

    protected $fillable=[
        'fecha_inicio_horarios',
        'fecha_fin_horarios',
    ];
}
