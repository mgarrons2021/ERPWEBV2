<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AjusteInventario extends Model
{
  use HasFactory;
  //protected $table='stock_ideal'; 
  protected $fillable = ['item', 'inventario_ini','precio', 'compras', 'pedido', 'eliminacion', 'inventario_sis', 'inventario_fin', 'diferencia','total_diferencia_bs'];

  // public function detalle_asignar_stock(){
  //     return $this->hasMany(DetalleAsignarStock::class);
  // }

  // public function sucursal(){
  //     return $this->belongsTo(Sucursal::class);
  // }
  public function getPocision(Collection $array, $value)
  {
    for ($i = 0; $i < count($array); $i++) {
      if ($array[$i]->item === $value) {
        return $i;
      }
    }
    return -1;
  }
}
