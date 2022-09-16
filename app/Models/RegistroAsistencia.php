<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAsistencia extends Model
{
    use HasFactory;

    protected $table = 'registro_asistencia';
    protected $fillable = ['fecha','hora_entrada','hora_salida','turno','user_id','sucursal_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
