<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManoObra extends Model
{
    use HasFactory;
    protected $table ='manos_obras';

    protected $fillable =['fecha','ventas','total_horas','total_costo','sucursal_id','turno_id'];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function turno(){
        return $this->belongsTo(Turno::class);
    }

    public function detalle_manos_obras(){
        return $this->hasMany(DetalleManoObra::class);
    }
}
