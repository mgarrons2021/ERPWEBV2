<?php

namespace App\Http\Controllers;

use App\Models\DetalleManoObra;
use App\Models\ManoObra;
use App\Models\RegistroAsistencia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sucursal;
use App\Models\TurnoIngreso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class ManoObraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manos_obras = ManoObra::all();
        return view('manos_obras.index', compact('manos_obras'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        
        $user = auth()->user();
        $sucursal_usuario_id = $user->sucursals[0]->id;
        $fecha_actual= Carbon::now()->toDateString();

        $users=  User::selectRaw('users.id ,users.name, users.apellido')
        ->join('sucursal_user','sucursal_user.user_id','=','users.id')
        ->where('sucursal_user.sucursal_id','=',$sucursal_usuario_id)
        ->get();



        return view('manos_obras.create',compact('users','user','fecha_actual'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        
        $user = auth()->user();
        $user_sucursal_id = $user->sucursals[0]->id;
        $user_turno_id = $user->turnos[0]->id;
    
         $mano_obra = new ManoObra();
         $mano_obra->fecha = $request->fecha;
         $mano_obra->ventas = $request->ventas;

         $mano_obra->sucursal_id = $user_sucursal_id;
         $mano_obra->turno_id = $user_turno_id;
        
         $mano_obra->save();

         $total_horas = 0;
         $total_costo =0;
         foreach (session('manos_obras_sucursales') as $id => $item) {
            

             $detalle_mano_obra = new  DetalleManoObra();
             $total_horas += $item['cantidad_horas'];
             $total_costo += $item['subtotal_costo'];
             
             $detalle_mano_obra->cantidad_horas = $item['cantidad_horas'];
             
             $detalle_mano_obra->subtotal_costo = $item['subtotal_costo'];
             $detalle_mano_obra->user_id = $item['usuario'];
             $detalle_mano_obra->mano_obra_id = $mano_obra->id;
             $detalle_mano_obra->save();
         }
         $mano_obra->update([
             'total_horas' =>  $total_horas,
             'total_costo' =>  $total_costo,
         ]);
         session()->forget('manos_obras_sucursales');
         session()->get('manos_obras_sucursales_asignados');
         session()->put('manos_obras_sucursales_asignados', 'ok');

         return response()->json(
             [
                 'success' => true
             ]
         );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mano_obra = ManoObra::find($id);
        return view('manos_obras.show',compact('mano_obra'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function agregarFuncionario(Request $request){
        

        $user = User::find($request->detalleManoObra["usuario"]);
        $mano_obra_sucursal_array = [

            "cantidad_horas" => $request->detalleManoObra['cantidad_horas'],
            
            "subtotal_costo" => $request->detalleManoObra['cantidad_horas']*8.84,
            "usuario" => $user->id,
            "user_name"=> $user->name,
        

        ];
        /* dd($mano_obra_sucursal_array); */

        session()->get('manos_obras_sucursales');
        session()->push('manos_obras_sucursales', $mano_obra_sucursal_array);
        return response()->json([
            'manos_obras_sucursales' => session()->get('manos_obras_sucursales'),
            'success' => true,
        ]);
    }


    
    public function eliminarFuncionario(Request $request)
    {
        $funcionarios_asignados= session('manos_obras_sucursales');
        unset($funcionarios_asignados[$request->data]);

        session()->put('manos_obras_sucursales', $funcionarios_asignados);

        return response()->json([
            'manos_obras_sucursales' => session()->get('manos_obras_sucursales'),
            'success' => true,
        ]);
    }

    public function reporteManoObraSucursal(){

        $fecha = Carbon::now()->toDateString();
        $sucursales = Sucursal::all();

        return view('manos_obras.reporteManoObraSucursal',compact('sucursales','fecha'));
    }

    public function detalle_mo_sucursal($sucursal_id, Request $request){

        $fecha = Carbon::now()->toDateString();
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;

        if(isset($request->fecha_inicial) && isset($request->fecha_final)){
            
                    $detalles_manos_obras_am = RegistroAsistencia::selectRaw('sum(horas_trabajadas) as horas_trabajadas_am, sucursals.nombre as sucursal_nombre')
                    ->join('sucursals','sucursals.id','=','registro_asistencia.sucursal_id')
                    ->whereBetween('fecha', [$fecha_inicial,$fecha_final])
                    ->where('turno',0)
                    ->where('sucursal_id','=',$sucursal_id)
                    ->groupBy('sucursals.nombre')
                    ->get();

                    $ventas_dia_am = TurnoIngreso::selectRaw('sum(ventas)')
                    ->whereBetween('fecha',[$fecha_inicial,$fecha_final])
                    ->where('turno',0)
                    ->where('sucursal_id',$sucursal_id)
                    ->get();
                    
                    $detalles_manos_obras_pm = RegistroAsistencia::selectRaw('sum(horas_trabajadas) as horas_trabajadas_pm')
                    ->whereBetween('fecha', [$fecha_inicial,$fecha_final])
                    ->where('turno',1)
                    ->where('sucursal_id','=',$sucursal_id)
                    ->get();

                    
                    $ventas_dia_pm = TurnoIngreso::selectRaw('sum(ventas)')
                    ->whereBetween('fecha',[$fecha_inicial,$fecha_final])
                    ->where('turno',1)
                    ->where('sucursal_id',$sucursal_id)
                    ->get();

        }else{
                    $detalles_manos_obras_am = RegistroAsistencia::selectRaw('sum(horas_trabajadas) as horas_trabajadas_am, sucursals.nombre as sucursal_nombre')
                    ->join('sucursals','sucursals.id','=','registro_asistencia.sucursal_id')
                    ->whereBetween('fecha', [$fecha,$fecha])
                    ->where('turno',0)
                    ->where('sucursal_id','=',$sucursal_id)
                    ->groupBy('sucursals.nombre')
                    ->get();

                    $ventas_dia_am = TurnoIngreso::selectRaw('sum(ventas) as ventas_am')
                    ->whereBetween('fecha',[$fecha,$fecha])
                    ->where('turno',0)
                    ->where('sucursal_id',$sucursal_id)
                    ->get();
                    
                    
                    $detalles_manos_obras_pm = RegistroAsistencia::selectRaw('sum(horas_trabajadas) as horas_trabajadas_pm')
                    ->whereBetween('fecha', [$fecha,$fecha])
                    ->where('turno',1)
                    ->where('sucursal_id','=',$sucursal_id)
                    ->get();

                    $ventas_dia_pm = TurnoIngreso::selectRaw('sum(ventas) as ventas_pm')
                    ->whereBetween('fecha',[$fecha,$fecha])
                    ->where('turno',1)
                    ->where('sucursal_id',$sucursal_id)
                    ->get();
        }

        return view('manos_obras.detalle_mo_sucursal',compact(
            'fecha',
            'detalles_manos_obras_am',
            'detalles_manos_obras_pm',
            'ventas_dia_am',
            'ventas_dia_pm',
           
        )
    );
    }


    
}
