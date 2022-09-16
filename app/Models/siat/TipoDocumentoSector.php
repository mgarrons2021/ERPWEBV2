<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentoSector extends Model
{
    use HasFactory;

    protected $table = "siat_tipos_documentos_sector";

    protected $fillable=[
        'codigoClasificador',
        'descripcion',
    ];
}
