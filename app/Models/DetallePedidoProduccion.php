<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedidoProduccion extends Model
{
    use HasFactory;
    protected $table= 'detalle_pedidos_produccion';

    protected $fillable = [
        'precio',
        'cantidad_solicitada',
        'cantidad_enviada',
        'subtotal_solicitado',
        'subtotal_enviado',
        'pedido_produccion_id',
        'plato_id'
    ];

    public function plato(){
        return $this->belongsTo(Plato::class);
    }

    public function pedido_produccion(){
        return $this->belongsTo(PedidoProduccion::class);
    }

}
