<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plato extends Model
{
    use HasFactory;
    protected $table = 'platos';

    protected $fillable =  ['nombre','imagen','estado', 'costo_plato','unidad_medida_compra_id','unidad_medida_venta_id'];

    public function platos_sucursales(){
        return $this->hasMany(PlatoSucursal::class);
    }
    public function detalle_menu_calificado(){
        return $this->hasOne(DetalleMenuCalificacion::class);
    }
    public function detalle_menus_semanales(){
        return $this->hasMany(DetalleMenuSemanal::class);
    }

    public function detalle_pedidos_produccion(){
        return $this->hasMany(DetallePedidoProduccion::class);
    }

    public function unidad_medida_venta(){
        return $this->belongsTo(UnidadMedidaVenta::class);
    }

    public function unidad_medida_compra(){
        return $this->belongsTo(UnidadMedidaCompra::class);
    }

    public function detalle_inventario(){
        return $this->hasMany(DetalleInventario::class);
    }

    public function detalle_inventario_sistema(){
        return $this->hasMany(DetalleInventarioSistema::class);
    }
                                                                                                            
    public function detalle_eliminacion(){
        return $this->hasMany(DetalleEliminacion::class);
    }

    public function getPlates($categoria_plato_id,$sucursal_id){
        $sql = "select platos.id, platos.nombre as Plato, platos.imagen,categorias_plato.nombre as CategoriaNombre ,platos_sucursales.precio as Precio,categorias_plato.id as idCategoria, platos_sucursales.precio_delivery as PrecioDelivery, platos_sucursales.sucursal_id 
        from platos 
        inner join platos_sucursales on platos_sucursales.plato_id =  platos.id
        inner join categorias_plato on categorias_plato.id = platos_sucursales.categoria_plato_id
        where platos_sucursales.categoria_plato_id = $categoria_plato_id and platos_sucursales.sucursal_id=$sucursal_id";
        $plates = DB::select($sql);
        return $plates; 

    }
                    
    public function getPlatos(){
        $sql = "select *  from platos ";
        $platos = DB::select($sql);
        return $platos; 

    }



    

}
