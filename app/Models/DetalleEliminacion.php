<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleEliminacion extends Model
{
    use HasFactory;
    protected $table = "detalles_eliminacion";

    protected $fillable = [
        'precio',
        'cantidad',
        'subtotal',
        'observacion',
        'producto_id',
        'plato_id',
        'eliminacion_id',
    ];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function eliminacion(){
        return $this->belongsTo(Eliminacion::class);
    }

    public function plato(){
        return $this->belongsTo(Plato::class);
    }

}
