<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    use HasFactory;
    protected $table="autorizaciones";

    protected $fillable = [
        'nro_autorizacion',
        'fecha_inicial',
        'fecha_fin',
        'nro_factura',
        'llave',
        'estado',
        'nit',
        'sucursal_id',
    ];
    public function ventas(){
        return $this->hasMany(Venta::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
