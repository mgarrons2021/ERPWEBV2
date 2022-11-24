<?php

namespace App\Models\Siat;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EventoSignificativo extends Model
{

    use HasFactory;
    protected $table = 'siat_eventos_significativos';

    protected $fillable = ['codigo_clasificador','descripcion'];

    public function ventas(){
        return $this->hasMany(Venta::class);
    }
    
    public function getSignifficantEvents(){
        $eventos_significativos = EventoSignificativo::all();
        return $eventos_significativos;
    }

    public function contingencia(){
        return $this->hasOne(Contingencia::class);
    }

}
