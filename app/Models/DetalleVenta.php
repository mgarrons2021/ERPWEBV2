<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalles_ventas';

    protected $fillable = ['cantidad','precio','subtotal','plato_id','venta_id'];

    public function plato(){
        return $this->belongsTo(Plato::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

}
