<?php

namespace App\Models\siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListadoPais extends Model
{
    use HasFactory; 
    protected $table = 'siat_listados_paises';

    protected $fillable = ['codigo_clasificador','descripcion'];
}
