<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosInsumos extends Model
{
    use HasFactory;
    protected $table='productos_insumos';
    protected $fillable=['cantidad', 'producto_id', 'insumos_dias_id'];

    public function insumos_dias(){
        return $this->belongsTo(InsumosDias::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

}
