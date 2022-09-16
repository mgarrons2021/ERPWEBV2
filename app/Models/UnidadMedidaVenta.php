<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedidaVenta extends Model
{
    use HasFactory;

    protected $table="unidades_medidas_ventas";

    protected $fillable=["nombre"];

    public function producto(){
        return $this->hasOne(Producto::class);
    }
}
