<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuCalificacion extends Model
{
    use HasFactory;
    protected $table= 'menucalificaciones';
    protected $fillable = ['menu_semanal_id','usuario_id','promedio'];

    public function menu_semanal(){
        return $this->belongsTo(MenuSemanal::class);
    }

    public function usuarios(){
        return $this->belongsTo(User::class);
    }
    public function menu_calificacion_detalle(){
        return $this->hasMany(DetalleMenuCalificacion::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}                                                                           
