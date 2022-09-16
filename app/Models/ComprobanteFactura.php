<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteFactura extends Model
{
    use HasFactory;
    protected $table= 'comprobantes_facturas';
    protected $fillable = ['numero_factura','numero_autorizacion','codigo_control','compra_id'];

    public function compra(){
        return $this->belongsTo(Compra::class);
    }

}
