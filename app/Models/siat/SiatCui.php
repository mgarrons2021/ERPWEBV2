<?php

namespace App\Models\Siat;

use App\Models\Sucursal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiatCui extends Model
{
    use HasFactory;

    protected $table = 'siat_cuis';
    protected $fillable = ['fecha_generado','fecha_expiracion','codigo_cui','estado','sucursal_id'];

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
