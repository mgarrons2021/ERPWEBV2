<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encargado extends Model
{
    use HasFactory;
    protected $table= 'encargados';
    protected $fillable = ['nombre','codigo','celular','estado','sucursal_id'];

    public function horarios(){
        return $this->hasMany(Horario::class);
    }

    
}
