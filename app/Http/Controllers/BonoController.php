<?php

namespace App\Http\Controllers;

use App\Models\Bono;
use App\Models\User;
use Illuminate\Http\Request;

class BonoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bonos = Bono::all();
     
        return view('bonos.index')->with('bonos',$bonos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $usuarios= User::all();
        return view('bonos.create')->with('usuarios',$usuarios);
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
            'monto'=>'required',
            'motivo'=>'required',
            'fecha'=>'required',
           
        ]);

        $bono= new Bono();
        $bono->monto =$request->get('monto');
        $bono->motivo =$request->get('motivo');
        $bono->fecha =$request->get('fecha');
        $bono->user_id =$request->get('user_id');
       
        $bono->save();
        return back()->with('bono', 'registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bono = Bono::find($id);
        $usuario = User::find($bono->user_id);
        return view('bonos.show', ['bono'=>$bono, 'usuario'=> $usuario ]);
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
        $bono= Bono::find($id);
        $bono->delete();
        return redirect()->route('bonos.index')->with('eliminar','ok');
    }
}
