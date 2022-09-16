<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\User;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnos = Turno::all();
        return view('turnos.index')->with('turnos',$turnos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios= User::all();
        return view('turnos.create')->with('usuarios',$usuarios);
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
            'turno'=>'required',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
           
        ]);

        $turno= new Turno();
        $turno->turno =$request->get('turno');
        $turno->hora_inicio =$request->get('hora_inicio');
        $turno->hora_fin =$request->get('hora_fin');
        $turno->usuario_id =$request->get('usuario_id');
    
        $turno->save();
       
        return redirect()->route('turnos.index');
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
        $usuarios= User::all();
        $turno = Turno::find($id);
        return view ('turnos.edit',compact('turno','usuarios'));
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
        $turno= Turno::find($id);
        $turno->turno =$request->get('turno');
        $turno->hora_inicio =$request->get('hora_inicio');
        $turno->hora_fin =$request->get('hora_fin');
     
        $turno->categoria_id =$request->get('usuario_id');
        $turno->save();
        return redirect()->route('turnos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $turno= Turno::find($id);
        $turno->delete();
        return redirect()->route('turnos.index')->with('eliminar','ok');
    }
}
