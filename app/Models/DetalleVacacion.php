<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleVacacion extends Model
{
    use HasFactory;

    protected $table='detalles_vacaciones';
    protected $fillable=['imagen','vacacion_id','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function vacacion(){
        return $this->belongsTo(vacacion::class);
    }
}
