<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeServicio extends Model
{
    use HasFactory;
    protected $table = 'siat_mensajes_servicios';

    protected $fillable = ['codigo_clasificador','descripcion'];
}
