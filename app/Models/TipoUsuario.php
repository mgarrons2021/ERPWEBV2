<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;
    protected $table= 'tipo_usuarios';
    
    protected $fillable=['tipo'];

    public function usuarios(){
        return $this->hasOne(User::class);
    }

}
