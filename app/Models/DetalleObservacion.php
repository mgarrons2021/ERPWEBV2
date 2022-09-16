<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleObservacion extends Model
{
    use HasFactory;

    protected $table = "detalles_observaciones";
    
    protected $fillable = [
        "user_id",
        "observacion_id"
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function observacion(){
        return $this->belongsTo(Observacion::class);
    }
}
