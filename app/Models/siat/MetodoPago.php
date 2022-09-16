<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    use HasFactory;

    protected $table = "siat_metodos_pagos";

    protected $fillable = [
        'codigoClasificador',
        'descripcion',
    ];

}
