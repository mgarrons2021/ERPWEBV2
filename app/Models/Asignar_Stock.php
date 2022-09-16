<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignar_Stock extends Model
{
    use HasFactory;
    protected $table='stock_ideal'; 
    protected $fillable=['fecha','user_id','sucursal_id'];

    public function detalle_asignar_stock(){
        return $this->hasMany(DetalleAsignarStock::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
   

}
