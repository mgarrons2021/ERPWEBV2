<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table='productos';
    protected $fillable=[
        'codigo',
        'nombre',
        'estado',
        'categoria_id',
        'unidad_medida_compra_id',
        'unidad_medida_venta_id'
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function productos_proveedores(){
        return $this->hasMany(Producto_Proveedor::class); //No me reconoce el Model producto_proveedor
    }

    public function detalleCompra(){
        return $this->hasOne(DetalleCompra::class);
    }

    public function productos_insumos(){
        return $this->hasMany( ProductosInsumos::class);
    }

    public function unidad_medida_compra(){
        return $this->belongsTo(UnidadMedidaCompra::class);
    }

    public function unidad_medida_venta(){
        return $this->belongsTo(UnidadMedidaVenta::class);
    }

    public function detalle_inventarios(){
        return $this->hasMany(DetalleInventario::class);
    }

    public function detalle_pedidos(){
        return $this->hasMany(DetallePedido::class);
    }

    public function detalle_partes_producciones(){
        return $this->hasMany(DetalleParteProduccion::class);
    }

    public function asignar_stock(){
        return $this->hasMany(DetalleAsignarStock::class);
    }

}
