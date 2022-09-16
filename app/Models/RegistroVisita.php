<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVisita extends Model
{
    use HasFactory;
    protected $table = 'registros_visitas';

    protected $fillable =['fecha','registro_contador','cliente_id','venta_id'];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }
}
