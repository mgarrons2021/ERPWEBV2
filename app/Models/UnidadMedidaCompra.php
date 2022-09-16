<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedidaCompra extends Model
{
    use HasFactory;

    protected $table="unidades_medidas_compras";

    protected $fillable=["nombre"];

    public function producto(){
        return $this->hasOne(Producto::class);   
    }
}
