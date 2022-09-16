<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleTraspaso extends Model
{
    use HasFactory;
    protected $table="detalles_traspaso";

    protected $fillable=[
        'cantidad',
        'subtotal',
        'producto_id',
        'traspaso_id'
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function traspaso(){
        return $this->belongsTo(Traspaso::class);
    }
}
