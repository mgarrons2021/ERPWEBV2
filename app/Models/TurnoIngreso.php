<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TurnoIngreso extends Model
{
    use HasFactory;

    protected $table ='turnos_ingresos';

    protected $fillable = ['fecha','turno','estado','hora_inicio','hora_fin','ventas','user_id','sucursal_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sucursal(){
        return $this->belongsTo(Sucursal::class);
    }  

    public function getSaleTurn($turnos_ingreso_id){

        //0 : ANULADO 1:VIGENTE
        $fecha = Carbon::now()->toDateString();
        $sql = "select sum(ventas.total_venta) as total_ventas from ventas
        where  turnos_ingreso_id = $turnos_ingreso_id and fecha_venta = '$fecha' and estado = 1";
        $sales = DB::select($sql);
        /* dd($sales); */ 
        return $sales[0]->total_ventas; 


    }

    public function getListTurn($fecha_inicio,$fecha_fin , $sucursal ){
        $fecha = Carbon::now()->toDateString();

        if(isset($fecha_inicio) && isset($fecha_fin)){
            $sql = "select (@rownum:=@rownum+1) AS nro_registro,turnos_ingresos.id, sucursals.nombre as sucursal_nombre, users.name as nombre_usuario,turnos_ingresos.fecha, turnos_ingresos.turno, turnos_ingresos.estado, turnos_ingresos.ventas 
            FROM (SELECT @rownum:=0) r,turnos_ingresos 
            JOIN sucursals on sucursals.id = turnos_ingresos.sucursal_id
            JOIN users on users.id = turnos_ingresos.user_id
            WHERE turnos_ingresos.fecha BETWEEN $fecha_inicio and $fecha_fin 
            and sucursals.id = $sucursal ";
            $lists_turns = DB::select($sql);
            return $lists_turns; 
            
        }else{
            $sql = "select  (@rownum:=@rownum+1) AS nro_registro,sucursals.nombre as sucursal_nombre, users.name as nombre_usuario,turnos_ingresos.fecha, turnos_ingresos.turno, turnos_ingresos.estado, turnos_ingresos.ventas 
            FROM (SELECT @rownum:=0) r,turnos_ingresos 
            JOIN sucursals on sucursals.id = turnos_ingresos.sucursal_id
            JOIN users on users.id = turnos_ingresos.user_id
            WHERE turnos_ingresos.fecha BETWEEN $fecha and $fecha 
            and sucursals.id = $sucursal ";
            $lists_turns = DB::select($sql);
            return $lists_turns; 
        }     

    }
    public  function close_turn($id_turn,$id_sucursal){
        
            $ventas= $this->getSaleTurn($id_turn);
            $turno = TurnoIngreso::find($id_turn);
            $hora_fin = Carbon::now()->format('H:i:s');
            $turno->hora_fin = $hora_fin;
            $turno->ventas = $ventas;
            $turno->estado = 0;
            $turno->save();
            return true;

    }
}
