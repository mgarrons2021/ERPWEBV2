<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = [
        'fecha_actual',
        'fecha_pedido',
        'total_solicitado',
        'total_enviado',
        'estado',
        'estado_impresion',
        'sucursal_principal_id',
        'sucursal_secundaria_id',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal_principal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function sucursal_secundaria(){
        return $this->belongsTo(Sucursal::class);
    }

    public function detalle_pedidos(){
        return $this->hasMany(DetallePedido::class);
    }
}
