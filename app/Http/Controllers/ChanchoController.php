<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Chancho;
use App\Models\PedidoProduccion;
use Illuminate\Http\Request;

class ChanchoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chanchos = Chancho::all();
        $fecha_anterior = Carbon::now()->subDay(1)->toDateString();

        $chanchoSolicitado = PedidoProduccion::selectRaw('sum(detalle_pedidos_produccion.cantidad_solicitada) as total_chancho_solicitado')
        ->join('detalle_pedidos_produccion','detalle_pedidos_produccion.pedido_produccion_id','=','pedidos_produccion.id')
        ->where('fecha',$fecha_anterior)
        ->where('detalle_pedidos_produccion.plato_id',3)
        ->first();

         /* dd($chanchoSolicitado->total_chancho_solicitado);  */

        return view('chanchos.index', compact('chanchos','chanchoSolicitado'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chanchos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* dd($request); */
        $chancho = new Chancho();
        $chancho->fecha = Carbon::now()->toDateString();
        $chancho->usuario = $request->usuario;
        $chancho->costilla_kilos = $request->costilla_kilos;
        $chancho->costilla_marinado = $request->costilla_marinado;
        $chancho->costilla_horneado = $request->costilla_horneado;
        $chancho->costilla_cortado = $request->costilla_cortado;

        $chancho->pierna_kilos = $request->pierna_kilos;
        $chancho->pierna_marinado = $request->pierna_marinado;
        $chancho->pierna_horneado = $request->pierna_horneado;
        $chancho->pierna_cortada = $request->pierna_cortada;

        $chancho->lechon_cortado = $request->lechon_cortado;
        $chancho->chancho_enviado = $request->chancho_enviado;

        $chancho->save();

        return redirect()->route('chanchos.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chancho = Chancho::find($id);
        return view('chanchos.show', compact('chancho'));
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

    public function filtrarChanchos(Request $request){
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;

        $chanchos = Chancho::whereBetween('fecha',[$fecha_inicial,$fecha_final])->get();

        return view('chanchos.index',compact('chanchos'));
    }
}
