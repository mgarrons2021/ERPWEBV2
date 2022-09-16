<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoDepartamento extends Model
{
    use HasFactory;

    protected $table = 'cargos_departamento';
    protected $fillable =['cargo_id','departamento_id'];

    public function cargo(){
        return $this->belongsTo(Cargo::class);
    }

    
    public function departamento(){
        return $this->belongsTo(Departamento::class);
    }
}
