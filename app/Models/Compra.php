<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Compra extends Model
{
    use HasFactory;
    protected $table='compras';

    protected $fillable = [
        'total',
        'fecha_compra',
        'estado',
        'glosa',
        'tipo_comprobante',
        'user_id',
        'sucursal_id',
        'proveedor_id',
    ];

    public function detalleCompras(){
        return $this->hasMany(DetalleCompra::class);
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

/*     public function pagos(){
        return $this->hasMany(Pago::class);
    } */

    public function comprobante_recibo(){
        return $this->hasOne(ComprobanteRecibo::class);
    }

    public function comprobante_factura(){
        return $this->hasOne(ComprobanteFactura::class);
    }

    public function detallePago(){
        return $this->hasOne(DetallePago::class);
    }

    public function getCompras (){
        $sql="Select * from compras";
        $compras = DB::select($sql);
        return $compras;

    }

    public function ComprasProveedores(){
        $sql= "Select * from compras c 
        inner join proveedores p on p.id = c.proveedor_id
        group by proveedor.id";
    }

}
