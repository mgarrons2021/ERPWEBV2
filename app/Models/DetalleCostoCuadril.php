<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCostoCuadril extends Model
{
    use HasFactory;

    protected $table ='detalles_costos_cuadriles';
    protected $fillable = [
        'cantidad_lomo',
        'cantidad_eliminado',
        'cantidad_recortado',
        'cantidad_cuadril',
        'cantidad_ideal_cuadril',
        'costo',
        'costo_cuadril_id'
    ];

    public function costo_cuadril(){
        return $this->belongsTo(CostoCuadril::class);
    }
}
