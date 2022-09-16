<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $table='contratos';
    protected $fillable=['tipo_contrato','sueldo','duracion_contrato'];

    public function detalleContratos(){
        return $this->hasMany(DetalleContrato::class);
    }
}
