<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCambioPrecio extends Model
{
    use HasFactory;
    protected $table="solicitudes_cambio_precio";

    protected $fillable = [
        'fecha',
        'estado',
        'motivo_cambio',
        'producto__proveedor_id',
    ];

    public function Producto_Proveedor(){
        return $this->belongsTo(Producto_Proveedor::class);
    }
}
