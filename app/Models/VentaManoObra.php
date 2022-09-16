<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaManoObra extends Model
{
    use HasFactory;
    protected $table ='ventas_manos_obras';
    protected $fillable =['ventas','sucursal_id'];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
