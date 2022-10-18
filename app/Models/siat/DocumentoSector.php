<?php

namespace App\Models\Siat;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoSector extends Model
{
    use HasFactory;
    protected $table ='siat_tipos_documentos_sector';
    protected $fillable = ['codigoClasificador','descripcion'];

   

    /* Api Obtener documentos Sectores */

    public function getSectorDocuments(){
        $documentoSectores = DocumentoSector::all();

        return $documentoSectores;
    }

    
}
