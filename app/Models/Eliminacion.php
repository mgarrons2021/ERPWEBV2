<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eliminacion extends Model
{
    use HasFactory;
    protected $table = "eliminaciones";

    protected $fillable = [
        'fecha',
        'total',
        'user_id',
        'turno_id',
        'sucursal_id',
        'inventario_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function turno(){
        return $this->belongsTo(Turno::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function inventario(){
        return $this->belongsTo(Inventario::class);
    }

    public function detalles_eliminacion(){
        return $this->hasMany(DetalleEliminacion::class);
    }
}
