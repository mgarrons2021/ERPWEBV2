<?php

namespace App\Models\siat;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoIdentidad extends Model
{
    use HasFactory;

    protected $table ='siat_documentos_identidad';

    protected $fillable = ['codigo_clasificador','descripcion'];

    public function ventas(){
        return $this->hasOne(Venta::class);
    }

    public function getIdentityDocuments(){

        $documento_identidad = DocumentoIdentidad::all();
        return $documento_identidad;
    }
}
