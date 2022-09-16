<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMenuSemanal extends Model
{
    use HasFactory;

    protected $table = 'detalle_menus_semanales';
    protected $fillable = ['plato_id','menu_semanal_id'];

    public function plato(){
        return $this->belongsTo(Plato::class);
    }

    public function menu_semanal(){
        return $this->belongsTo(MenuSemanal::class);
    }
}
