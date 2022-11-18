<?php

namespace App\Models\Siat;

use App\Models\Venta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeyendaFactura extends Model
{
    use HasFactory;
    protected $table = 'siat_leyendas_facturas';
    protected $fillable = ['fecha', 'codigo_actividad', 'descripcion_leyenda'];

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function getLeyenda()
    {
        $numero_random = rand(1, 8);
        $eventos_significativos = LeyendaFactura::find($numero_random);
        return $eventos_significativos;
    }

    public function getLeyendaSale($leyenda_id){
        $leyenda = LeyendaFactura::find($leyenda_id);
        return $leyenda;
    }
}
