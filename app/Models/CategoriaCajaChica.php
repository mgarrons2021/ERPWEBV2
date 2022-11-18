<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CajaChicaSubCategoria;
use App\Models\SubCategoria;
class CategoriaCajaChica extends Model
{
    use HasFactory;
    protected $table = "categorias_caja_chica";

    protected $fillable = [
        'nombre',    
        'sub_categoria_id'
    ];
    public function sub_categoria(){
        return $this->belongsTo(SubCategoria::class);
    }
    public function nombre(){
        return $this->hasMany(CategoriaCajaChica::class);
    }
    public function nombres(){
        return $this->hasMany(DetalleCajaChica::class);
    }

    

    // public function cajaChicaSubCategoria(){
    //     return $this->hasMany(CajaChicaSubCategoria::class);
    // }

    
}
