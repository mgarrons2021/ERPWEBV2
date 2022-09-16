<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\CategoriaCajaChica;
use App\Models\DetalleCajaChica;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CajaChicaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        if ($user->roles[0]->id == 3) {
            $cajas_chicas = CajaChica::where('sucursal_id', $user->sucursals[0]->id)->get();
        } else {
            $cajas_chicas = CajaChica::all();
        }
        return view('cajas_chicas.index', compact('cajas_chicas'));
    }

    public function filtrarIndexCajaChica(Request $request)
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');
        
        if($user->roles[0]->id==3){
            $cajas_chicas = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id',$user->sucursals[0]->id)->get();
        }else{
           
                //dd('true');
                $cajas_chicas = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
        }

        return view('cajas_chicas.index', compact('cajas_chicas') );
    }

    public function create()
    {
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        $categorias_caja_chica = CategoriaCajaChica::all();
        return view('cajas_chicas.create', compact('categorias_caja_chica', 'fecha_actual'));
    }

    public function edit($id)
    {
        $caja_chica = CajaChica::find($id);

        return view('cajas_chicas.edit', compact('caja_chica'));
    }

    public function agregarDetalle(Request $request)
    {
        $tipo_egreso = CategoriaCajaChica::find($request->detalleCajaChica['tipo_egreso']);
        $detalle_egreso = [
            "egreso" => $request->detalleCajaChica['egreso'],
            "tipo_egreso_nombre" => $tipo_egreso->nombre,
            "tipo_egreso_id" => $tipo_egreso->id,
            "glosa" => $request->detalleCajaChica['glosa'],
            "tipo_comprobante" => $request->detalleCajaChica['tipo_comprobante'],
            "nro" => $request->detalleCajaChica['nro'],
        ];

        session()->get('lista_egreso');
        session()->push('lista_egreso', $detalle_egreso);

        return response()->json([
            'lista_egreso' => session()->get('lista_egreso'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_egreso = session('lista_egreso');
        unset($detalle_egreso[$request->data]);
        session()->put('lista_egreso', $detalle_egreso);
        return response()->json(
            [
                'lista_egreso' => session()->get('lista_egreso'),
                'success' => true
            ]
        );
    }

    public function show($id)
    {
        $caja_chica = CajaChica::find($id);
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('cajas_chicas.show', compact('caja_chica', 'fecha_actual'));
    }

    public function registrarCajaChica()
    {
        if (session('lista_egreso') != null) {
            $caja_chica = new CajaChica();
            $caja_chica->fecha = Carbon::now()->toDateString();
            $caja_chica->user_id = Auth::id();
            $caja_chica->sucursal_id = Auth::user()->sucursals[0]->id;
            $caja_chica->save();

            $total_cajachica = 0;
            foreach (session('lista_egreso') as $id => $item) {
                $total_cajachica += $item['egreso'];
                $detalle_caja_chica = new DetalleCajaChica();
                $detalle_caja_chica->egreso = $item['egreso'];
                $detalle_caja_chica->glosa = $item['glosa'];
                $detalle_caja_chica->tipo_comprobante = $item['tipo_comprobante'];
                $detalle_caja_chica->nro_comprobante = $item['nro'];
                $detalle_caja_chica->categoria_caja_chica_id = $item['tipo_egreso_id'];
                $detalle_caja_chica->caja_chica_id = $caja_chica->id;
                $detalle_caja_chica->save();
            }
            $caja_chica->update(['total_egreso' => $total_cajachica]);
            session()->forget('lista_egreso');
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

    public function destroy($id)
    {
        CajaChica::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function reporteCajaChica()
    {
        $sucursales = Sucursal::all();
        $fecha_marcado_inicial = Carbon::now()->startOfDay();
        $fecha_marcado_final = Carbon::now()->endOfDay();
        $registros = CajaChica::whereBetween('fecha', [Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->get();
        return view('contabilidad.reportes.reporteCajaChica', compact('sucursales','registros', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }

    public function filtrarCajaChica(Request $request)
    {
        $user = Auth::user();
        $sucursales = Sucursal::all();
        $sucursal = $request->get('sucursal_id');
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');
        
        if($user->roles[0]->id==3){
            $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id',$user->sucursals[0]->id)->get();
        }else{
            if($sucursal=='x'){
                //dd('true');
                $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
            }else{
                //dd('false');
                $registros = CajaChica::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->where('sucursal_id', $sucursal )->get();
            }
        }

        return view('contabilidad.reportes.reporteCajaChica', compact('sucursales' ,'registros', 'fecha_marcado_inicial', 'fecha_marcado_final') );
    }
}
