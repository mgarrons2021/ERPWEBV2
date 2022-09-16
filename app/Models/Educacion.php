<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Educacion extends Model
{
    use HasFactory;
    protected $table="educaciones";

    protected $fillable=[
        'nombre_institucion',
        'nombre_carrera',
        'fecha_inicio_educacion',
        'fecha_fin_educacion',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
