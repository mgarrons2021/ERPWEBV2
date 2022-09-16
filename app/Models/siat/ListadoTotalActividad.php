<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListadoTotalActividad extends Model
{
    use HasFactory;

    protected $table = 'siat_listados_actividades';

    protected $fillable = ['codigo_caeb','descripcion','tipo_actividad'];
}
