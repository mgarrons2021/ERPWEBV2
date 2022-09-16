<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleInventarioSistema extends Model
{
    use HasFactory;
    protected $table = "detalles_inventario_sistema";
    protected $fillable = [
        'stock',
        'precio',
        'subtotal',
        'producto_id',
        'inventario_sistema_id',
        'plato_id',
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function inventario_sistema(){
        return $this->belongsTo(Inventario::class);
    }

    public function plato(){
        return $this->belongsTo(Plato::class);
    }

}
