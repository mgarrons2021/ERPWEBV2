<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Evaluacion;
use App\Models\User;
use App\Models\CargoSucursal;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evaluaciones = Evaluacion::all();
        return view('evaluaciones.index', compact('evaluaciones'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios= User::all();
        $evaluaciones= Evaluacion::all();
        $cargos= CargoSucursal::all();

        return view('evaluaciones.create',compact('usuarios','evaluaciones','cargos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required',
            'categoria'=>'required',         
        ]);
        $evaluaciones = new Evaluacion(); 
        $evaluaciones->nombre = $request->get('nombre'); 
        $evaluaciones->categoria= $request->get('categoria');
        $evaluaciones->cargo_id = $request->get('cargo_id');
        $evaluaciones->save();
        return back()->with('evaluaciones', 'registrado');
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
        $evaluaciones =  Evaluacion::find($id);
        $cargos= CargoSucursal::all();
        return view('evaluaciones.edit', compact('evaluaciones', 'cargos'));


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
        $evaluaciones = Evaluacion::findOrFail($id);
        $evaluaciones->nombre = $request->nombre;
        $evaluaciones->categoria = $request->categoria;
        $evaluaciones->cargo_id = $request->cargo_id;
        $evaluaciones->save();
        return redirect()->back()->with('editar', 'success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Evaluacion::destroy($id);
        return response()->json(['success' => true],200);
    }
}
