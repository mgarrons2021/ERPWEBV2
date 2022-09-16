<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatoProducto extends Model
{
    use HasFactory;
    protected $table='platos_productos';
    protected $fillable=['plato_id', 'producto_proveedor_id', 'cantidad', 'subtotal'];

    public function plato(){
        return $this->belongsTo(Plato::class);
    }
    public function productoProveedor(){
        return $this->belongsTo(Producto_Proveedor::class);
    }
}
