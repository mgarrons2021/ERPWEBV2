<?php

namespace App\Http\Controllers;

use App\Models\Keperi;
use App\Models\PedidoProduccion;
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
        $fecha = Carbon::now()->toDateString();

        $keperis= Keperi::latest()
        ->take(5)
        ->get();

        $keperi_bufetera = PedidoProduccion::selectRaw('platos.nombre, detalle_pedidos_produccion.cantidad_solicitada')
        ->join('detalle_pedidos_produccion','detalle_pedidos_produccion.pedido_produccion_id','=','pedidos_produccion.id')
        ->join('platos','platos.id','=',' detalle_pedidos_produccion.plato_id')
        ->where('detalle_pedidos_produccion.plato_id',17)
        ->where('fecha',$fecha)
        ->first();

        $keperi_120 = PedidoProduccion::selectRaw('platos.nombre, detalle_pedidos_produccion.cantidad_solicitada')
        ->join('detalle_pedidos_produccion','detalle_pedidos_produccion.pedido_produccion_id','=','pedidos_produccion.id')
        ->join('platos','platos.id','=',' detalle_pedidos_produccion.plato_id')
        ->where('detalle_pedidos_produccion.plato_id',49)
        ->where('fecha',$fecha)
        ->first();




        return view('keperis.index',compact('keperis','keperi_bufetera','keperi_120'));
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
        $keperi->cantidad_cortado = $request->cantidad_cortado;
        $keperi->descuentos_bandejas = $request->descuentos_bandejas;
        
        $keperi->nombre_usuario = $request->nombre_usuario;
        $keperi->temperatura_maxima = $request->temperatura_maxima;
        $keperi->veces_volcado = $request->veces_volcado;

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
        $keperi->descuentos_bandejas = $request->descuentos_bandejas;

        $keperi->cantidad_cortado = $request->cantidad_cortado;
    
        $keperi->nombre_usuario = $request->nombre_usuario;
        $keperi->temperatura_maxima = $request->temperatura_maxima;
        $keperi->veces_volcado = $request->veces_volcado;

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
        $keperi = Keperi::find($id);
        $keperi->delete();

        return redirect()->route('keperis.index')->with('eliminar','ok');
    }

       
    
    public function reporteCentroProduccion (){
        return view('keperis.reporte');
    }
}
