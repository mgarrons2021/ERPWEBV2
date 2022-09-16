<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargos';
    protected $fillable = ['nombre','departamento_id','sucursal_id'];

    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function cargo_sucursal(){
        return $this->hasMany(Cargos_sucursal::class);
    }

    
}
