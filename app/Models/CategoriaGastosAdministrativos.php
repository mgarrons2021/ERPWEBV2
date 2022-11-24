<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGastosAdministrativos extends Model
{
    use HasFactory;
    protected $table = "categorias_gasto_admin";
    protected $fillable = [
        'codigo',
        'nombre',
        'sub_categoria_id'
    ];
    public function sub_categoria()
    {
        return $this->belongsTo(SubCategoria::class);
    }
    
    // public function categoria_gasto(){
    //     return $this->hasMany(DetGastoAdm::class);
    // }

    public function categoria_gasto(){
        return $this->hasMany(DetalleGastosAdministrativos::class);
    }
    public function nombre(){
        return $this->hasMany(CategoriaCajaChica::class);
    }

    // public function categoria_gastos_administrativos(){
    //     return $this->belongsTo(DetalleGastosAdministrativos::class);
    // }
    


    

}
