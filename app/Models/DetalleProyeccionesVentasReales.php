<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;

class DetalleProyeccionesVentasReales extends Model
{
    use HasFactory;
    protected $table='proyeccion_ventas_reales';

    protected $fillable=[
    'fecha',
    'venta_real_am',
    'venta_real_pm',
    'venta_real_subtotal',
    'proyecciones_ventas_id'];

    public function asignar_stock(){
        return $this->belongsTo(ProyeccionesVentas::class);
    }
}
