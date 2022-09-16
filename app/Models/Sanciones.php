<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sanciones extends Model
{
    use HasFactory;
    protected $table='sanciones';
    protected $fillable=['imagen','fecha','descripcion','sucursal_id','categoria_sancion_id', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function categoriaSancion(){
        return $this->belongsTo(CategoriaSancion::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function detalleSancion(){
        return $this->hasOne(DetalleSancion::class);
    }

}
