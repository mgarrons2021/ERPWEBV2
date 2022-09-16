<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto_Proveedor extends Model
{
    use HasFactory;
    protected $table = 'producto_proveedor';
    protected $fillable = [
        'producto_id',
        'proveedor_id',
        'sucursal_id',
        'precio',
        'fecha',
        'estado',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function solicitudes_cambios_precio(){
        return $this->hasMany(SolicitudCambioPrecio::class);
    }
}
