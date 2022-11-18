<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GastosAdministrativos extends Model
{
    use HasFactory;
    protected $table = "gastos_administrativo";

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
    public function categoria_gasto_administrativo(){
        return $this->belongsTo(CategoriaGastosAdministrativos::class);
    }

    public function detalles_gastos_administrativos(){
        return $this->hasMany(DetalleGastosAdministrativos::class);
    }
}
