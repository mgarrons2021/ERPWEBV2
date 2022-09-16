<?php

namespace App\Http\Controllers;

use App\Models\Descuento;
use App\Models\User;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $descuentos = Descuento::all();
        $usuarios= User::all();
        return view('descuentos.index')->with('descuentos',$descuentos)->with('usuarios',$usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios= User::all();
        return view('descuentos.create')->with('usuarios',$usuarios);
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

        $descuento= new Descuento();
        $descuento->monto =$request->get('monto');
        $descuento->motivo =$request->get('motivo');
        $descuento->fecha =$request->get('fecha');
        $descuento->user_id =$request->get('user_id');
       
        $descuento->save();
        return redirect()->route('personales.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $descuento = Descuento::find($id);
        $usuario = User::find($descuento->user_id);
        return view('descuentos.show', ['descuento'=>$descuento, 'usuario'=> $usuario ]);
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
        $descuento= Descuento::find($id);
        $descuento->delete();
        return redirect()->route('descuentos.index')->with('eliminar','ok');
    }
}
