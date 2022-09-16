<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garante extends Model
{
    use HasFactory;
    protected $table = 'garantes';

    protected $fillable = ['nombre','apellido','direccion','letra_cambio','foto','user_id'];

    public function user(){
        return $this-> belongsTo (User::class);
    }
}
