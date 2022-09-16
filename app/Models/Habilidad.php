<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habilidad extends Model
{
    use HasFactory;
    protected $table = 'habilidades';
    protected $fillable = ['habilidad','user_id'];
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
