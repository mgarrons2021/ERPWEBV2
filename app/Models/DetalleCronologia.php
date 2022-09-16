<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCronologia extends Model
{
    use HasFactory;
    protected  $table = 'detalles_cronologias';

    protected $fillable = ['user_id','cronologia_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function cronologia(){
        return $this->belongsTo(Cronologia::class);
    }
}
