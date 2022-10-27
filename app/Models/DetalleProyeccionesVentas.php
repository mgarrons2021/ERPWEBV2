<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;

class DetalleProyeccionesVentas extends Model
{
    use HasFactory;
    protected $table='detalles_proyecciones_ventas';

    protected $fillable=['fecha_registro',
    'fecha_proyeccion',
    'venta_proyeccion_am',
    'venta_proyeccion_pm',
    'venta_proyeccion_subtotal',
    'venta_real_am',
    'venta_real_pm',
    'venta_real_subtotal',
    'proyecciones_ventas_id'];

    public function asignar_stock(){
        return $this->belongsTo(ProyeccionesVentas::class);
    }


}
