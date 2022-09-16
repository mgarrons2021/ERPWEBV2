<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use App\Models\Sucursal;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departamentos = Departamento::all();
        return view('departamentos.index')->with('departamentos',$departamentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('departamentos.create');
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
            'descripcion' => 'required',
          
            
        ]);

        $departamento= new Departamento();
        $departamento->nombre =$request->get('nombre');
        $departamento->descripcion =$request->get('descripcion');
        
        
        $departamento->save();  
        return redirect()->route('departamentos.index');
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
        $departamento = Departamento::find($id);
        return view ('departamentos.edit',compact('departamento'));
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
        
        $departamento=  Departamento::find($id);
 
        $departamento->nombre =$request->get('nombre');
        $departamento->descripcion =$request->get('descripcion');
        $departamento->save();
       
        return redirect()->route('departamentos.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $departamento= Departamento::find($id);
        $departamento->delete();
        return redirect()->route('departamentos.index')->with('eliminar','ok');
    }
}
