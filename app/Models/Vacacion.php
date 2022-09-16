<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacacion extends Model
{
    use HasFactory;
    protected $table='vacaciones';
    protected $fillable=['fecha_inicio','fecha_fin','estado','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detalleVacacion(){
        return $this->hasOne(DetalleVacacion::class);
    }
}
