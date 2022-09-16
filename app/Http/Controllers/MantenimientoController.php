<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\CategoriaCajaChica;
use App\Models\Sucursal;
use App\Models\DetalleMantenimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class MantenimientoController extends Controller
{
    public function index()
    {
        $mantenimiento = Mantenimiento::all();
        return view('mantenimiento.index', compact('mantenimiento'));
    }

    public function create()
    {

        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        $categorias_caja_chica = CategoriaCajaChica::all();
        return view('mantenimiento.create', compact('categorias_caja_chica', 'fecha_actual'));
    }

    public function edit($id)
    {
        $caja_chica = Mantenimiento::find($id);

        return view('mantenimiento.edit', compact('mantenimiento'));
    }

    public function agregarDetalle(Request $request)
    {
        if ($request->hasFile('imagen')) {
            $file = $request->file(('imagen'));
            $destinationPath = 'img/mantenimientos/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadsucess = $request->file('imagen')->move($destinationPath, $filename);
        }
        $detalle_mantenimiento = [
            "egreso" => $request->egreso,
            "glosa" => $request->glosa,
            "categoria_nombre" => $request->tipo_egreso_nombre,
            "categoria_id" => $request->tipo_egreso_id,
            "imagen" => $destinationPath.$filename,
        ];

        session()->get('lista_egreso');
        session()->push('lista_egreso', $detalle_mantenimiento);

        return response()->json([
            'lista_egreso' => session('lista_egreso'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_egreso = session('lista_egreso');
        /* dd($detalle_egreso[$request->data]['imagen']); */
        unlink($detalle_egreso[$request->data]['imagen']);
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
        $mantenimiento = Mantenimiento::find($id);
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('mantenimiento.show', compact('mantenimiento', 'fecha_actual'));
    }

    public function registrarCajaChica()
    {
        if (session('lista_egreso') != null) {
            $caja_chica = new Mantenimiento();
            $caja_chica->fecha = Carbon::now()->toDateString();
            $caja_chica->user_id = Auth::id();
            $caja_chica->sucursal_id = Auth::user()->sucursals[0]->id;
            $caja_chica->save();

            $total_cajachica = 0;
            foreach (session('lista_egreso') as $id => $item) {
                $total_cajachica += $item['egreso'];
                $detalle_caja_chica = new DetalleMantenimiento();
                $detalle_caja_chica->egreso = $item['egreso'];
                $detalle_caja_chica->glosa = $item['glosa'];
                $detalle_caja_chica->foto = $item['imagen'];
                $detalle_caja_chica->categoria_caja_chica_id = $item['categoria_id'];
                $detalle_caja_chica->mantenimiento_id = $caja_chica->id;
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
        Mantenimiento::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function reporteCajaChica()
    {
        $fecha_marcado_inicial = Carbon::now()->startOfDay();
        $fecha_marcado_final = Carbon::now()->endOfDay();
        $registros = Mantenimiento::whereBetween('fecha', [Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->get();
        return view('contabilidad.reportes.reporteCajaChica', compact('registros', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }

    public function filtrarCajaChica(Request $request)
    {
        $fecha_marcado_inicial = $request->get('fecha_inicial');
        $fecha_marcado_final = $request->get('fecha_final');
        $registros = Mantenimiento::whereBetween('fecha', [$fecha_marcado_inicial, $fecha_marcado_final])->get();
        return view('contabilidad.reportes.reporteCajaChica', compact('registros', 'fecha_marcado_inicial', 'fecha_marcado_final'));
    }
}
