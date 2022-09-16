<?php

namespace App\Http\Controllers;

use App\Models\DetalleMenuCalificacion;
use Illuminate\Http\Request;
use App\Models\MenuCalificacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class MenuCalificacionController extends Controller
{
    //
    public function agregarCalificacion(Request $request)
    {
        $idmenu=$request->idMenusemanal;
        $user=User::find(Auth::id());
        $menu= MenuCalificacion::where('menu_semanal_id',$idmenu)
                ->where('sucursal_id' , $user->sucursals[0]->id)
                ->first();
        //dd( is_null($menu) );
        if( is_null($menu) ){ 
            //creamos el menucalificacion x unica vez para el dia del menu , luego ya no se volvera a crear
            $menu= new MenuCalificacion();
            $menu->usuario_id = $user->id;
            $menu->sucursal_id = $user->sucursals[0]->id;
            $menu->menu_semanal_id=$idmenu;
            $menu->promedio = 0;
            $menu->save();
        }else{
            /* $res=$menu[0];
            dd($res);
            $res= $menu[0]->id; */
        }
        //dd($menu);
        $listas=$request->lista;
        $cantidad=count($listas);
        $sabor=0;                               
        $presentacion=0;
        foreach($listas as $producto){
            $sabor+=$producto['sabor'];
            $presentacion+=$producto['presentacion'];
            //creamos el detalle de calificacion del plato
            $detallecalificacion=new DetalleMenuCalificacion();
            $detallecalificacion->sabor=$producto['sabor'];
            $detallecalificacion->estado=$producto['tipollegada'];
            $detallecalificacion->presentacion=$producto['presentacion'];
            $detallecalificacion->observacion=$producto['observacion'];
            $detallecalificacion->plato_id=$producto['id'];
            $detallecalificacion->menu_calificacion_id=$menu->id;        
            $detallecalificacion->save();    
        }
        $total= (($sabor/$cantidad) + ($presentacion/$cantidad))/2;
        $menu->promedio= $total;
        $menu->update();

        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function verEvaluados(Request $request){
        $id = $request->id;
        $menucalificacion = MenuCalificacion::find($id);
        
        $dia = $menucalificacion->menu_semanal->dia;
        //dd( count($menucalificacion->menu_calificacion_detalle) );
        $cantidad = count($menucalificacion->menu_calificacion_detalle);
        //dd($menucalificacion->menu_calificacion_detalle[0]->plato);
        return view( 'menus_semanales.menu_evaluado',compact( 'menucalificacion','dia' ,'cantidad' ) );
    }

    public function menuGeneral(Request $request){    
        
        $calificados = MenuCalificacion::selectRaw('
            sucursals.nombre, count(menucalificaciones.sucursal_id),
            sum(case when menus_semanales.dia="LUNES"   then menucalificaciones.promedio  else 0 end) as Lunes,
            SUM(case when menus_semanales.dia="MARTES" then menucalificaciones.promedio else 0 end) as Martes,
            SUM(case when menus_semanales.dia="MIERCOLES" then menucalificaciones.promedio else 0 end) as Miercoles,
            SUM(case when menus_semanales.dia="JUEVES" then menucalificaciones.promedio else 0 end) as Jueves,
            SUM(case when menus_semanales.dia="VIERNES" then menucalificaciones.promedio else 0 end) as Viernes,
            SUM(case when menus_semanales.dia="SABADO" then menucalificaciones.promedio else 0 end) as Sabado,
            SUM(case when menus_semanales.dia="DOMINGO" then menucalificaciones.promedio else 0 end) as Domingo '
            )
            ->rightJoin('sucursals' , 'sucursals.id', '=', 'menucalificaciones.sucursal_id')
            ->leftJoin('menus_semanales', 'menus_semanales.id', '=', 'menucalificaciones.menu_semanal_id')
            ->groupBy(['sucursals.nombre'])
            ->get(); 
       
        //dd($detalles_pedido);
        //$menu = MenuCalificacion::  ;

        return view('menus_semanales.menuevaluado_general', compact('calificados') );
    
    }

}