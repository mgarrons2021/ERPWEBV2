<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;

class DetalleCompra extends Model
{
    use HasFactory;
    protected $table='detalles_compra';

    protected $fillable=[
        'cantidad',
        'subtotal',
        'producto_id',
        'precio_producto',
        'compra_id',
    ];

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
