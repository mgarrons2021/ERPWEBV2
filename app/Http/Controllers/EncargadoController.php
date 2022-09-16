<?php

namespace App\Http\Controllers;

use App\Models\Encargado;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class EncargadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$encargados = Encargado::all();
        return view('encargados.index')->with('encargados',$encargados);*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales= Sucursal::all();
        return view('encargados.create')->with('sucursales',$sucursales);
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
            'codigo' => 'required',
            'celular' => 'required',
        ]);

        $encargado= new Encargado();
        
        $encargado->nombre =$request->get('nombre');
        $encargado->codigo =$request->get('codigo');
        $encargado->celular =$request->get('celular');
        $encargado->estado=$request->get('estado');
        
        $encargado->sucursal_id =$request->get('sucursal_id');
    
        $encargado->save();
       
        return redirect()->route('productos.index');
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
        $sucursales= Sucursal::all();
        $encargado = Encargado::find($id);
        return view ('encargados.edit',compact('encargado','sucursales'));
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
        $encargado= Encargado::find($id);
        $encargado->nombre =$request->get('nombre');
        $encargado->codigo =$request->get('codigo');
        $encargado->celular =$request->get('celular');
        $encargado->estado=$request->get('estado');
     
        $encargado->sucursal_id =$request->get('sucursal_id');
        $encargado->save();
        return redirect()->route('encargados.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $encargado= Encargado::find($id);
        $encargado->delete();
        return redirect()->route('encargados.index')->with('eliminar','ok');
    }
}
