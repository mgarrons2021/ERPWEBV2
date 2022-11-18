<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    use HasFactory;
    protected $table = "cajas_chicas";

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
    public function categoria_caja_chica(){
        return $this->belongsTo(CategoriaCajaChica::class);
    }

    public function detalles_caja_chica(){
        return $this->hasMany(DetalleCajaChica::class);
    }
}
