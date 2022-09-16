<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleManoObra extends Model
{
    use HasFactory;
    protected $table ='detalle_manos_obras';
    protected $fillable =['cantidad_horas','subtotal_costo','user_id','mano_obra_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function mano_obra(){
        return $this->belongsTo(ManoObra::class);
    }

    
}
