<?php

namespace App\Http\Controllers;

use App\Models\Garante;
use App\Models\User;
use Illuminate\Http\Request;

class GaranteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users= User::all();
        return view('garante.create',compact('users'));
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
            'nombre' => 'required',
            'direccion' => 'required',    
        ]);

        $garante = new Garante();
        $garante->nombre =$request->get('nombre');
        $garante->apellido =$request->get('apellido');
        $garante->direccion =$request->get('direccion');
        $garante->celular = $request->get('celular');
        $garante->ocupacion =$request->get('ocupacion');
        $garante->letra_cambio =$request->get('letra_cambio');
        if($request->hasFile('foto')){
            $file= $request->file(('foto'));
            $destinationPath ='img/garantes/';
            $filename = time() .'-'. $file->getClientOriginalName();
            $uploadsucess = $request->file('foto')->move($destinationPath, $filename);
            $garante->foto = $destinationPath.$filename;
        }

        $garante->user_id = $request->get('user_id');
        
        $garante->save();  
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
       /*  dd($id); */
        $garante= Garante::find($id);
        $users = User::find($garante->user_id);
        return view('garantes.show',compact('users','garante'));


    
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
}
