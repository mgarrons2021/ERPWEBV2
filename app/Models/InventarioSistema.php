<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventarioSistema extends Model
{
    use HasFactory;
    protected $table = 'inventarios_sistema';
    protected $fillable = [
        'fecha',
        'total',
        'tipo_inventario',
        'sucursal_id',
        'user_id',
        'turno_id',
        'inventario_id'
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
        return $this->hasMany(DetalleInventarioSistema::class);
    }
}
