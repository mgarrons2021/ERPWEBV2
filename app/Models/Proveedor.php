<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $table='proveedores';
    protected $fillable=['nombre','celular','direccion','nit','estado'];

    public function productos_proveedores(){
        return $this->hasMany(Producto_Proveedor::class); 
    }

    public function compras(){
        return $this->hasMany(Compra::class);
    }
    
    public function pagos(){
        return $this->hasMany(Pago::class);
    }
}
