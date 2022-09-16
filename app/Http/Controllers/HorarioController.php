<?php

namespace App\Http\Controllers;

use App\Models\CargoSucursal;
use App\Models\Encargado;
use App\Models\Horario;
use App\Models\Sucursal;
use App\Models\Turno;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $horarios = Horario::all();
        return view('horarios.index', compact('horarios'));
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios = User::all();
        $sucursales = Sucursal::all();
        return view('horarios.create')->with('usuarios', $usuarios)->with('sucursales', $sucursales);
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        
            'hora_ingreso' => 'required',
            'hora_salida_fija' => 'required',
        ]);

        $horarios = new Horario();
        $horarios->fecha = Carbon::now();
        $horarios->hora_ingreso = $request->get('hora_ingreso');
        $horarios->hora_salida_fija = $request->get('hora_salida_fija');

        $horarios->hora_entrada = $request->get('hora_entrada');
        $horarios->hora_salida = $request->get('hora_salida');
        $horarios->horas_trabajadas = $request->get('horas_trabajadas');
        $horarios->turno= $request->get('turno');
    
        $horarios->user_id = $request->get('user_id');
        $horarios->sucursal_id = $request->get('sucursal_id');

    

        $horarios->save();

        return redirect()->route('horarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function reporteHorario(Request $request)
    {
        $horarios = Horario::all();
        $usuarios = User::all();
        $sucursales = Sucursal::all();
        $fecha = Carbon::now();
        $hora_ent = Carbon::now();
        $hora_sal = '16:45:45';
        $horas_trab = $hora_ent->diffInHours($hora_sal);
        $total_pagar = $horas_trab * 9;

        return view('horarios.reporteHorario')->with('usuarios', $usuarios)->with('sucursales', $sucursales)->with('fecha', $fecha)->with('hora_ent', $hora_ent)->with('hora_sal', $hora_sal)->with('horas_trab', $horas_trab)->with('total_pagar', $total_pagar)->with('horarios',$horarios);
       
    }

    public function funcionarios(Request $request)
    {
        if (isset($request->texto)) {
            $funcionarios2 = User::where('sucursal_id', $request->texto)->get();
            return response()->json(
                [
                    'lista' => $funcionarios2,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    public function planillaHorarios()
{
        $sucursales = Sucursal::all();
        $cargos_sucursales = CargoSucursal::all();
        /*  $cargo_sucursal=CargoSucursal::find(1); */
        $user = User::find(1);
        $turnos = Turno::all();
        /* dd($cargo_sucursal->users); */
        return view('horarios.planillaHorarios', compact('sucursales', 'cargos_sucursales', 'turnos'));
    }

    public function cargarHorarios(Request $request)
    {

        /* dd($request); */
        if (isset($request->fecha_inicial, $request->fecha_final)) {
            User::where('sucursal_id', $request->sucursal_id)->whereBetween('points', [1, 150]);
        }
    }

    public function obtenerFuncionarios(Request $request)
    {
        if (isset($request->texto)) {
            $funcionarios = User::where('sucursal_id', $request->texto)->get();
            $sucursal = Sucursal::find($request->texto);
            return response()->json(
                [
                    'nombre_sucursal' => $sucursal->nombre,
                    'lista' => $funcionarios,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
}
