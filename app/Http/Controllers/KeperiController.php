<?php

namespace App\Http\Controllers;

use App\Models\Keperi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeperiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keperis= Keperi::latest()->take(5)->get();
        
        return view('keperis.index',compact('keperis'));
    }

    public function filtrarKeperis(Request $request){
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $keperis = Keperi::whereBetween('fecha',[$fecha_inicial,$fecha_final])->get();

        return view('keperis.index',compact('keperis'));    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keperis.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $keperi = new Keperi();
        $keperi->fecha = Carbon::now()->toDateString();
        $keperi->cantidad_kilos = $request->cantidad_kilos;
        $keperi->cantidad_crudo = $request->cantidad_crudo;
        $keperi->cantidad_marinado = $request->cantidad_marinado;
        $keperi->cantidad_enviado = $request->cantidad_enviado;
        $keperi->cantidad_cocido = $request->cantidad_cocido;
        $keperi->cantidad_sellado = $request->cantidad_sellado;
        $keperi->nombre_usuario = $request->nombre_usuario;
        $keperi->save();
        return redirect()->route('keperis.index');
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
        $keperi = Keperi::find($id);

        return view('keperis.edit', compact('keperi'));
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
        $keperi = Keperi::find($id);
        $keperi->fecha = $request->fecha;
        $keperi->cantidad_kilos = $request->cantidad_kilos;
        $keperi->cantidad_crudo = $request->cantidad_crudo;
        $keperi->cantidad_marinado = $request->cantidad_marinado;
        $keperi->cantidad_enviado = $request->cantidad_enviado;
        $keperi->cantidad_cocido = $request->cantidad_cocido;
        $keperi->cantidad_sellado = $request->cantidad_sellado;
        $keperi->nombre_usuario = $request->nombre_usuario;

        $keperi->save();

        return redirect()->route('keperis.index');

        


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

       
    
    public function reporteCentroProduccion (){
        return view('keperis.reporte');
    }
}
