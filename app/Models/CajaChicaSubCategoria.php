<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChicaSubCategoria extends Model
{
    use HasFactory;
    protected $table = 'caja_chica_sub_categoria';
    protected $fillable = ['sub_categoria'];

    public function categoriaCajaChica(){
        return $this->hasMany(CategoriaCajaChica::class);
    }
    public function cajaChicaSubCategoria(){
        return $this->hasMany(CajaChicaSubCategoria::class);
    }

}