<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuSemanal extends Model
{
    use HasFactory;
    protected $table= 'menus_semanales';

    protected $fillable = ['fecha','dia'];

    public function detalle_menus_semanales(){
        return $this->hasMany(DetalleMenuSemanal::class);
    }
    public function pedidos_produccion(){
        return $this->hasMany(PedidoProduccion::class);
    }
    public function menu_calificacion(){
        return $this->hasMany(MenuCalificacion::class);
    }
}
