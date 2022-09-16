<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionUser2 extends Model
{
    use HasFactory;
    protected $table= 'evaluaciones_user2';
    protected $fillable= ['evaluacion_user', 'user_id'];

    public function evaluacion_user(){
        return $this->belongsTo(EvaluacionUser::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
