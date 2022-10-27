<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyeccionesVentas extends Model
{
    use HasFactory;
    protected $table='proyecciones_ventas'; 
    protected $fillable=['fecha_registro',
    'mes_proyeccion',
    'proyeccion_subtotal_am',
    'proyeccion_subtotal_pm',
    'total_proyeccion',
    'venta_subtotal_am',
    'venta_subtotal_pm',
    'total_ventas_real',
    'diferencias',
    'user_id',
    'sucursal_id'];

    public function detalle_asignar_stock(){
        return $this->hasMany(DetalleProyeccionesVentas::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
   

}
