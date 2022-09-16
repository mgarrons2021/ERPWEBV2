<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table ='clientes';

    protected $fillable =['nombre','ci_nit','empresa','telefono','contador_visitas']; 


    public function ventas(){
        return $this->hasMany(Venta::class);
    }

    public function registros_visitas(){
        return $this->hasMany(RegistroVisita::class);
    }

}
