<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder\Function_;

class DetalleAsignarStock extends Model
{
    use HasFactory;
    protected $table='detalles_stock_ideal';

    protected $fillable=['fecha','cantidad','producto_id','asignar__stock_id'];

    public function asignar_stock(){
        return $this->belongsTo(Asignar_Stock::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
