<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;
    protected $table='salidas';
    protected $fillable=[
        'foto',
        'motivo',
        'fecha_salida',
        'descripcion',
        'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
