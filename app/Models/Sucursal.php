<?php

namespace App\Models;

use App\Models\FacturacionOnline\RegistroPuntoVenta;
use App\Models\FacturacionOnline\SiatCui;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;
    protected $table='sucursals';
    protected $fillable=['nombre','direccion','correo','nro_fiscal','codigo_fiscal'];

    public function productos_proveedores(){
        return $this->hasMany(Producto_Proveedor::class); 
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function autorizaciones(){
        return $this->hasMany(Autorizacion::class);
    }

    public function horarios(){
        return $this->hasMany(Horario::class);
    }

    public function cargos_sucursales(){
        return $this->hasMany(Cargos_sucursales::class);
    }

    public function Horario(){
        return $this->hasMany(Horario::class);
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }

    public function usuario_sucursal(){
        return $this->hasMany(UsuarioSucursal::class);
    }

    public function pagos(){
        return $this->hasMany(Pago::class);
    }
   
    public function registro_asistencias(){
        return $this->hasMany(RegistroAsistencia::class);
    }

    public function platos_sucursales(){
        return $this->hasMany(PlatoSucursal::class);
    }

    public function pedidos(){
        return $this->hasmany(Pedido::class);
    }

    public function pedidos_produccion(){
        return $this->hasMany(Sucursal::class);
    }

    public function partes_producciones(){
        return $this->hasMany(ParteProduccion::class);
    }

    public function asignar_stock(){
        return $this->hasMany(Asignar_Stock::class);
    }

    public function menu_calificacion(){
        return $this->belongsToMany(MenuCalificacion::class);
    }

    public function manos_obras(){
        return $this->hasMany(ManoObra::class);
    }

    public function ventas_manos_obras(){
        return $this->hasMany(VentaManoObra::class);
    }

    public function puntas_ventas(){
        return $this->hasMany(RegistroPuntoVenta::class);
    }
    public function siat_cuis(){
        return $this->hasMany(SiatCui::class);
    }

    public function siat_cufds(){
        return $this->hasMany(SiatCufd::class);
    }

}
