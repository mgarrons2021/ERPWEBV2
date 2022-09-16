<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    use HasFactory;
    protected $table = 'experiencias_laborales';
    protected $fillable = ['cargo','nombre_empresa','descripcion','user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
