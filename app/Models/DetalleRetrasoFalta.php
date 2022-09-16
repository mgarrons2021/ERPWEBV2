<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRetrasoFalta extends Model
{
    use HasFactory;
    protected $table = "detalles_retrasos_faltas";
    
    protected $fillable = [
        "user_id",
        "retraso_falta_id"
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function retraso_falta(){
        return $this->belongsTo(RetrasoFalta::class);
    }
}
