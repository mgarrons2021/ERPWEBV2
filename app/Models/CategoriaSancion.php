<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaSancion extends Model
{
    use HasFactory;
    protected $table='categoria_sancion';
    protected $fillable=['nombre'];

    public function sanciones(){
        return $this->hasMany(Sanciones::class);
    }
}
