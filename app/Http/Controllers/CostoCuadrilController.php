<?php

namespace App\Http\Controllers;

use App\Models\CostoCuadril;
use App\Models\DetalleCostoCuadril;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CostoCuadrilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costos_cuadriles = CostoCuadril::all();
        return view('costos_cuadriles.index', compact('costos_cuadriles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('costos_cuadriles.create', compact('fecha_actual'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (session('lista_costo_cuadril') != null) {
            $costo_cuadril = new CostoCuadril();
            $costo_cuadril->fecha = Carbon::now()->toDateString();
            $costo_cuadril->peso_inicial = $request->peso_inicial;
            $costo_cuadril->nombre_usuario = $request->nombre_usuario;
            $costo_cuadril->save();

            $total_cantidad_lomo = 0;
            $total_cantidad_eliminado = 0;
            $total_cantidad_recorte = 0;
            $total_cantidad_cuadril = 0;

            if ($costo_cuadril->save()){

            foreach (session('lista_costo_cuadril') as $id => $item) {
                $total_cantidad_lomo += $item['cantidad_lomo'];
                $total_cantidad_eliminado += $item['cantidad_eliminado'];
                $total_cantidad_recorte += $item['cantidad_recorte'];
                $total_cantidad_cuadril += $item['cantidad_cuadril'];
                $detalle_costo_cuadril = new DetalleCostoCuadril();
                $detalle_costo_cuadril->cantidad_lomo = $item['cantidad_lomo'];
                $detalle_costo_cuadril->cantidad_eliminado = $item['cantidad_eliminado'];
                $detalle_costo_cuadril->cantidad_recortado = $item['cantidad_recorte'];
                $detalle_costo_cuadril->cantidad_cuadril = $item['cantidad_cuadril'];
                $detalle_costo_cuadril->cantidad_ideal_cuadril = $item['cantidad_ideal_cuadril'];
                $detalle_costo_cuadril->costo_cuadril_id = $costo_cuadril->id;
                $detalle_costo_cuadril->save();
            }
        }
            $costo_cuadril->update([
                'total_lomo' => $total_cantidad_lomo,
                'total_eliminacion' => $total_cantidad_eliminado,
                'total_recorte' => $total_cantidad_recorte,
                'total_unidad_cuadril' => $total_cantidad_cuadril,
            ]);
            session()->forget('lista_costo_cuadril');
            return response()->json(
                [
                    'success' => true
                ]
            );
        }
        return response()->json(
            [
                'success' => false
            ]
        );
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $costo_cuadril = CostoCuadril::find($id);
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('costos_cuadriles.show', compact('costo_cuadril', 'fecha_actual'));
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
        CostoCuadril::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function agregarDetalle(Request $request)
    {
        $detalle_costo_cuadril = [
            "cantidad_lomo" => $request->detalleCostoCuadril['cantidad_lomo'],
            "cantidad_eliminado" => $request->detalleCostoCuadril['cantidad_eliminado'],
            "cantidad_recorte" => $request->detalleCostoCuadril['cantidad_recorte'],
            "cantidad_cuadril" => $request->detalleCostoCuadril['cantidad_cuadril'],
            "cantidad_ideal_cuadril" => $request->detalleCostoCuadril['cantidad_ideal_cuadril'],
        ];

        session()->get('lista_costo_cuadril');
        session()->push('lista_costo_cuadril', $detalle_costo_cuadril);

        return response()->json([
            'lista_costo_cuadril' => session()->get('lista_costo_cuadril'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_costo_cuadril = session('lista_costo_cuadril');
        unset($detalle_costo_cuadril[$request->data]);
        session()->put('lista_costo_cuadril', $detalle_costo_cuadril);
        return response()->json(
            [
                'lista_costo_cuadril' => session()->get('lista_costo_cuadril'),
                'success' => true
            ]
        );
    }

    public function filtrarCortes(Request $request){
        $fecha_actual = Carbon::now()->toDateString();
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $costos_cuadriles = CostoCuadril::whereBetween('fecha',[$fecha_inicial,$fecha_final])->get();

        $cortes = CostoCuadril::whereBetween('fecha',[$fecha_inicial,$fecha_final])->get();

        return view('costos_cuadriles.index', compact('cortes', 'fecha_inicial','costos_cuadriles'));   
     }
}
