<?php

namespace App\Http\Controllers;

use App\Models\CargoSucursal;
use App\Models\Sucursal;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tareas = Tarea::all();
        return view('tareas.index', compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        $usuarios = User::all();
        $tareas = Tarea::all();
        $cargos = CargoSucursal::all();

        return view('tareas.create', compact('usuarios', 'tareas', 'cargos', 'sucursales'));
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
            'turno' => 'required',
        ]);

        $tareas = new Tarea();
        $tareas->nombre = $request->get('nombre');  /*Mandar directamente las variables sin llevar a la view*/

        $tareas->hora_inicio = $request->get('hora_inicio');
        $tareas->hora_fin = $request->get('hora_fin');
        $tareas->turno = $request->get('turno');
        $tareas->dia_semana = $request->get('dia_semana');

        $tareas->cargo_id = $request->get('cargo_id');
        $tareas->sucursal_id = $request->get('sucursal_id');


        $tareas->save();
        return redirect()->route('tareas.index');
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
        $sucursales = Sucursal::all();
        $tareas = Tarea::find($id);
        $cargos = CargoSucursal::all();
        return view('tareas.edit', compact('tareas', 'cargos', 'sucursales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar(Request $request, $id)
    {
        /* dd($request); */
        $request->validate([
            'turno' => 'required',
        ]);

        $tarea = Tarea::find($id);
        $tarea->nombre = $request->get('nombre');
        $tarea->hora_inicio = $request->get('hora_inicio');
        $tarea->hora_fin = $request->get('hora_fin');
        $tarea->turno = $request->get('turno');
        $tarea->dia_semana = $request->get('dia_semana');
        $tarea->cargo_id = $request->get('cargo_id');
        $tarea->sucursal_id = $request->get('sucursal_id');

        $tarea->save();

        return redirect()->route('tareas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        return response()->json(['success' => true], 200);
    }
}
