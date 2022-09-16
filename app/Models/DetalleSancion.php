<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleSancion extends Model
{
    use HasFactory;
    protected $table="detalles_sanciones";

    protected $fillable = ["user_id","sanciones_id"];

    public function sancion(){
        return $this->belongsTo(Sanciones::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
