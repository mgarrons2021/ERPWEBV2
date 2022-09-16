<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteRecibo extends Model
{
    use HasFactory;
    protected $table="comprobantes_recibos";

    protected $fillable = ["nro_recibo","compra_id"];

    public function Compra(){
        return $this->belongsTo(Compra::class);
    }
}
