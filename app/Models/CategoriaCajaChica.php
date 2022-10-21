<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaCajaChica extends Model
{
    use HasFactory;
    protected $table = "categorias_caja_chica";

    protected $fillable = [
        'nombre',
        'para_costo',
    ];
    public function para_costo(){
        return $this->hasMany(DetalleCajaChica::class);
    } 

}
