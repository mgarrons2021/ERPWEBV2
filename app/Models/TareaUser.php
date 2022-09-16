<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TareaUser extends Model
{
    use HasFactory;

    protected $table= 'tarea_user';
    protected $fillable= ['user_id','tarea_id'];

    public $timestamps = true;

    public function tarea(){
        return $this->belongsTo(Tarea::class);
    }

   
}
