<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;
    protected $table = 'inventarios';
    protected $fillable = [
        'fecha',
        'total',
        'tipo_inventario',
        'sucursal_id',
        'user_id',
        'turno_id'
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function detalle_inventarios(){
        return $this->hasMany(DetalleInventario::class);
    }


}
