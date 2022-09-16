<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    use HasFactory;
    protected $table = 'evaluaciones';
    protected $fillable = ['nombre', 'categoria', 'cargo_id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function cargo(){
        return $this->belongsTo(CargoSucursal::class);
    }

}
