<?php

namespace App\Http\Controllers;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales = Sucursal::all();
        return view('sucursales.index')->with('sucursales',$sucursales);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sucursales.create');
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
            'correo' => 'required',
            'nro_fiscal' => 'required'
            
        ]);

        $sucursal= new Sucursal();
        $sucursal->nombre =$request->get('nombre');
        $sucursal->direccion =$request->get('direccion');
        $sucursal->correo =$request->get('correo');
        $sucursal->nro_fiscal =$request->get('nro_fiscal');
        
        if($request->get('estado')=="activo"){
            $sucursal->estado =1;
        }else if ($request->get('estado')=="inactivo"){
            $sucursal->estado =0;
        }
        $sucursal->save();  
        return redirect()->route('sucursales.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sucursal =  Sucursal::find($id);
        return view('sucursales.show', ['sucursal'=>$sucursal]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sucursal = Sucursal::find($id);
        return view ('sucursales.edit',compact('sucursal')) ;
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
        
        $sucursal=  Sucursal::find($id);
 
        $sucursal->nombre =$request->get('nombre');
        $sucursal->direccion =$request->get('direccion');
        $sucursal->correo =$request->get('correo');
        $sucursal->nro_fiscal =$request->get('nro_fiscal');
        
        if($request->get('estado')=="activo"){
            $sucursal->estado =1;
        }else if ($request->get('estado')=="inactivo"){
            $sucursal->estado =0;
        }
        $sucursal->save();
       
        return redirect()->route('sucursales.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sucursal= Sucursal::find($id);
        $sucursal->delete();
        return redirect()->route('sucursales.index')->with('eliminar','ok');
    }
}
