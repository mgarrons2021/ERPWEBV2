<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMenuCalificacion extends Model
{
    use HasFactory;

    protected $table= 'detalles_menucalificacion';

    protected $fillable = [
        'sabor',
        'estado',
        'observacion',
        'presentacion',
        'plato_id',
        'menu_calificacion_id'
    ];

    public function menu_semanal_calificacion(){
        return $this->hasMany(MenuCalificacion::class);
    }
      
    public function plato(){
        return $this->belongsTo(Plato::class);
    }

}
