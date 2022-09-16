<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatoSucursal extends Model
{
    use HasFactory;
    
    protected $table = 'platos_sucursales';

    protected $fillable = ['precio','precio_delivery','costo_plato','plato_id','sucursal_id','categoria_plato_id'];

    public function plato(){
        return $this->belongsTo(Plato::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function categoria_plato(){
        return $this->belongsTo(CategoriaPlato::class);
    }

    public function allCategorias($sucursal_id){
        return $this->selectRaw('categorias_plato.id, categorias_plato.nombre')
        ->join('categorias_plato','categorias_plato.id','=','platos_sucursales.categoria_plato_id')
        ->groupBy(['categorias_plato.id','categorias_plato.nombre'])
        ->where('sucursal_id',$sucursal_id)->get();
    }
}
