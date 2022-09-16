<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioSucursal extends Model
{
    use HasFactory;
    protected $table ='users_sucursales';
    protected $fillable = ['user_id', 'sucursal_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }
}
