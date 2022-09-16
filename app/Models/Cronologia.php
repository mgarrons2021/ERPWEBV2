<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cronologia extends Model
{
    use HasFactory;
    protected $table='cronologias';
    protected $fillable=['fecha_cronologia','descripcion','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function detalle_Cronologia(){
        return $this->hasOne(DetalleCronologia::class);
    }
}
