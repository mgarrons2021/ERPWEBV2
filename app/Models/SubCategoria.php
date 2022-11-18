<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    use HasFactory;
    protected $table='caja_chica_sub_categoria';
    protected $fillable=['sub_categoria'];

    public function sub_categoria(){
        return $this->hasMany(CategoriaGastosAdministrativos::class);
    }
}
