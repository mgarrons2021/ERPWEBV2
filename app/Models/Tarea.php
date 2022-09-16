<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $fillable = [
        'nombre',
        'hora_inicio',
        'hora_fin',
        'turno',
        'dia_semana',
        'cargo_id',
        'sucursal_id',
    ];

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('created_at');
    }

    public function cargo(){
        return $this->belongsTo(CargoSucursal::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
