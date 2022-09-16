<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sucursal;
class RegistroPuntoVenta extends Model
{
    use HasFactory;
    protected $table="siat_registro_punto_venta";

    protected $fillable = [
        'codigo_punto_venta',
        'sucursal_id',
    ];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
