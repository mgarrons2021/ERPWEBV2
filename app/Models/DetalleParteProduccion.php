<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleParteProduccion extends Model
{
    use HasFactory;

    protected $table = 'detalle_partes_producciones';

    protected $fillable = ['precio','cantidad','subtotal','producto_id','parte_producciones_id'];

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function parte_produccion(){
        return $this->belongsTo(ParteProduccion::class);
    }
}
