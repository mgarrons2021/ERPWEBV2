<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsumosDias extends Model
{
    use HasFactory;
    protected $table='insumos_dias';
    protected $fillable=['dia', 'tipo'];

    public function producto_insumos(){
        return $this->hasMany(ProductosInsumos::class);
    }


}
