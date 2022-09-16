<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParteProduccion extends Model
{
    use HasFactory;

    protected $table = 'partes_producciones';
    protected $fillable = ['fecha','total','user_id','sucursal_usuario_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal_usuario(){
        return $this->belongsTo(Sucursal::class);
    }

    public function detalle_partes_producciones(){
        return $this->hasMany(DetalleParteProduccion::class);
    }
}
