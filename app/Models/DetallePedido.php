<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;
    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'cantidad_solicitada',
        'cantidad_enviada',
        'precio',
        'subtotal_solicitado',
        'subtotal_enviado',
        'pedido_id',
        'producto_id'
    ];

    /* u havent done the Inverse relationship yet */
    
    public function detalle_pedidos(){
        return $this->hasMany(DetallePedido::class);
    }
    public function pedido(){
        return $this->belongsTo(Pedido::class);

    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
