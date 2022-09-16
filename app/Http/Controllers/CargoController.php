<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\CargoSucursal;
use App\Models\Departamento;
use App\Models\Sucursal;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargos = CargoSucursal::all();
        return view('cargos.index',compact('cargos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('cargos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'nombre_cargo'=>'required',
           
        ]);

        $cargo= new CargoSucursal();
        $cargo->nombre_cargo =$request->nombre_cargo;
        $cargo->descripcion = $request->descripcion;
        $cargo->save();
        return redirect()->route('cargos.index');
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
        
        $cargo = CargoSucursal::find($id);
        return view ('cargos.edit',compact('cargo'));
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
        $cargo= CargoSucursal::find($id);
        $cargo->nombre_cargo =$request->get('nombre_Cargo');
        $cargo->descripcion =$request->get('descripcion');
    
        
        $cargo->save();
        return redirect()->route('cargos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cargo= CargoSucursal::find($id);
        $cargo->delete();
        return redirect()->route('cargos.index')->with('eliminar','ok');
        
    }
}
