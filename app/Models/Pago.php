<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;
    protected $table = 'pagos';
    protected $fillable = ['fecha','banco','nro_cuenta','tipo_pago','total','nro_comprobante','nro_cheque','proveedor_id','compra_id'];

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

    public function detallePagos(){
        return $this->hasMany(DetallePago::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

}
