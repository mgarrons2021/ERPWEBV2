<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleContrato extends Model
{
    use HasFactory;
    protected $table='detalle_contratos';

    protected $fillable=[
        'fecha_inicio_contrato',
        'fecha_fin_contrato',
        'disponibilidad',
        'contrato_id',
        'user_id',
    ];

    public function contrato(){
        return $this->belongsTo(Contrato::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
