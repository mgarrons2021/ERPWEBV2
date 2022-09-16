<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReciclaje extends Model
{
    use HasFactory;
    protected $table = "detalles_reciclaje";
    protected $fillable = [
        'precio',
        'cantidad',
        'subtotal',
        'observacion',
        'producto_id',
        'plato_id',
        'reciclaje_id',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function reciclaje()
    {
        return $this->belongsTo(Reciclaje::class);
    }

    public function plato()
    {
        return $this->belongsTo(Plato::class);
    }
}
