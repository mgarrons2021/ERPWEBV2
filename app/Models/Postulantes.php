<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postulantes extends Model
{
    use HasFactory;
    protected $table='postulantes';
    protected $fillable=['name','apellido','celular_personal','observacion', 'estado'];

}
