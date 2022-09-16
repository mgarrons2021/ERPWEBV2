<?php

namespace App\Models\siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoIdentidad extends Model
{
    use HasFactory;

    protected $table ='siat_documentos_identidad';

    protected $fillable = ['codigo_clasificador','descripcion'];
}
