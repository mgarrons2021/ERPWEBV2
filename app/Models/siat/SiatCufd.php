<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sucursal;

class SiatCufd extends Model
{
    use HasFactory;
    protected $table = 'siat_cufds';

    protected $fillable =['codigo','codigo_control','direccion','fecha_generado','fecha_vigencia','estado','numero_factura','sucursal_id'];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
