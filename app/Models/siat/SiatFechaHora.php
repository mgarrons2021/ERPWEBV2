<?php

namespace App\Models\siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiatFechaHora extends Model
{
    use HasFactory;
    protected $table = 'siat_fechas_horas';
    protected $fillable =['fecha_hora'];
}
