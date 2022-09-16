<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionUser extends Model
{
    use HasFactory;
    protected $table= 'evaluaciones_user';
    protected $fillable= ['user_id','evaluacion_id', 'puntaje'];

    public function evaluacion(){
        return $this->belongsTo(Evaluacion::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
