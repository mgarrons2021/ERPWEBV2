<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoSucursal extends Model
{
    use HasFactory;
    protected $table = 'cargos_sucursales';
    protected $fillable =['nombre_cargo','descripcion'];

    public function users(){    
        return $this->belongsToMany(User::class);
    }

    public function tareas(){
        return $this->hasMany(Tarea::class);
    }
    
}
