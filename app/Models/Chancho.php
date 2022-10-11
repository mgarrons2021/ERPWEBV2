<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chancho extends Model
{
    use HasFactory;

    protected $table = 'chanchos';

    protected $fillable = [
        'fecha',
        'usuario',
        'costilla_kilos',
        'costilla_marinado',
        'costilla_horneado',
        'costilla_cortado',

        'pierna_kilos',
        'pierna_marinado',
        'pierna_horneado',
        'pierna_cortada',
        'lechon_cortado',
        'chancho_enviado'
    ];
}
