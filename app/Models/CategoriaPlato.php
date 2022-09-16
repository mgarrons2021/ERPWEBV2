<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaPlato extends Model
{
    use HasFactory;
    protected $table = 'categorias_plato';
    protected $fillable = ['nombre','estado'];

    public function platos(){
        return $this->hasMany(Plato::class);
    }

    public function platos_sucursales(){
        return $this->hasMany(PlatoSucursal::class);
    } 
    
    public function allCategorias(){

        return $this->all();
    }
}
