<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostoCuadril extends Model
{
    use HasFactory;
    protected $table = 'costos_cuadriles';

    protected $fillable = ['peso_inicial','nombre_usuario','fecha','total_lomo','total_eliminacion','total_recorte','total_unidad_cuadril','costo_total'];
    
    public function detalles_costos_cuadriles(){
        return $this->hasMany(DetalleCostoCuadril::class);
    }


}
