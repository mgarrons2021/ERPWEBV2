<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;
    protected $table = "mantenimientos";

    protected $fillable=[
        'fecha',
        'total_egreso',
        'user_id',
        'sucursal_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function detalles_mantenimiento(){
        return $this->hasMany(DetalleMantenimiento::class);
    }
}
