<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePago extends Model
{
    use HasFactory;

    protected $table= "detalles_pago";

    protected $fillable=[
        'pago_id',
        'compra_id',
        'subtotal',
    ];

    public function pago(){
        return $this->belongsTo(Pago::class);
    }

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

}
