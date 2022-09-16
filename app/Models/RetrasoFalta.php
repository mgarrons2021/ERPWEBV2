<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetrasoFalta extends Model
{
    use HasFactory;
    protected $table = "retrasos_faltas";
    protected $fillable = [
        "fecha",
        "hora",
        "descripcion",
        "justificativo",
        "tipo_registro",
        "sucursal_id",
        "user_id"
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function detalleRetrasoFalta(){
        return $this->hasOne(DetalleRetrasoFalta::class);
    }
    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

}
