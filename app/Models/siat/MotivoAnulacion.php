<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MotivoAnulacion extends Model
{
    use HasFactory;

    protected $table = 'siat_motivos_anulaciones';

    protected $fillable = ['codigo_clasificador','descripcion'];


}
