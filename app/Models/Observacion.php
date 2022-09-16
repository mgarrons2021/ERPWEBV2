<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;
    protected $table='observaciones';
    protected $fillable=['foto','fecha_observacion','descripcion','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detalleObservacion(){
        return $this->hasOne(DetalleObservacion::class);
    }

}
