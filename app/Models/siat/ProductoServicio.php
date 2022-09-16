<?php

namespace App\Models\Siat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoServicio extends Model
{
    use HasFactory;
    protected $table = 'siat_productos_servicios';

    protected $fillable = ['codigo_actividad','codigo_producto','descripcion_producto'];
}
