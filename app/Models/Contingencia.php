<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Siat\EventoSignificativo;

class Contingencia extends Model
{
    use HasFactory;
    public $protected = "contingencias";
    public $fillable = [
        'fecha_inicio_contigencia',
        'fecha_fin_contigencia',
        'hora_ini',
        'hora_fin',
        'estado',
        'evento_significativo_id'
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function evento_significativo(){
        return $this->belongsTo(EventoSignificativo::class);

    }
}
