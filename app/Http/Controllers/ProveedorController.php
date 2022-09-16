<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index')->with('proveedores',$proveedores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedores.create');
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
            'celular' => 'required',
          
            'direccion' => 'required',
            'nit' => 'required',
        ]);

        $proveedores= new Proveedor();
        $proveedores->nombre =$request->get('nombre');
        $proveedores->celular =$request->get('celular');
      
        $proveedores->direccion =$request->get('direccion');
        $proveedores->nit =$request->get('nit');
        $proveedores->estado =$request->get('estado');
        $proveedores->save();
       
        return redirect()->route('proveedores.index');

        /*$userfind= User::find($id);*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $proveedores = Proveedor::find($id);
        return view('proveedores.show', ['proveedor'=>$proveedores]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        return view ('proveedores.edit',compact('proveedor')) ;
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
        $proveedor= Proveedor::find($id);
        $proveedor->nombre =$request->get('nombre');
        $proveedor->celular =$request->get('celular');
        $proveedor->direccion =$request->get('direccion');
        $proveedor->nit =$request->get('nit');
        $proveedor->estado =$request->get('estado');
        $proveedor->save();

        return redirect()->route('proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $proveedor= Proveedor::find($id);
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('eliminar','ok');
    }
}
