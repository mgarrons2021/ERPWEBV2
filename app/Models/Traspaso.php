<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Traspaso extends Model
{
    use HasFactory;
    protected $table="traspasos";
    protected $fillable = 
    [
        'fecha',
        'total',
        'estado',
        'user_id',
        'inventario_principal_id',
        'inventario_secundario_id',
        'sucursal_principal_id',
        'sucursal_secundaria_id',
    ];

    public function detalles_traspaso(){
        return $this->hasMany(DetalleTraspaso::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function inventario_principal(){
        return $this->belongsTo(Inventario::class);
    }

    public function inventario_sucundario(){
        return $this->belongsTo(Inventario::class);
    }

    public function sucursal_principal(){
        return $this->belongsTo(Sucursal::class);
    }

    public function sucursal_secundaria(){
        return $this->belongsTo(Sucursal::class);
    }   
}