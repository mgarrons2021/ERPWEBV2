<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProduccion extends Model
{
    use HasFactory;
    protected $table = 'pedidos_produccion';
    protected $fillable = 
    [
    'fecha',
    'fecha_pedido',
    'total_solicitado',
    'total_enviado',
    'estado',
    'user_id',
    'sucursal_usuario_id',
    'sucursal_pedido_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function menu_semanal(){
        return $this->belongsTo(MenuSemanal::class);
    }

    public function sucursal_usuario(){
        return $this->belongsTo(Sucursal::class);
    }

    public function sucursal_pedido(){
        return $this->belongsTo(Sucursal::class);
    }

    public function detalle_pedido_produccion(){
        return $this->hasMany(DetallePedidoProduccion::class);
    }
}
