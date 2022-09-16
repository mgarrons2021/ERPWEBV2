<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\DetallePago;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $pagos = Pago::all();
        $proveedores = Proveedor::all();
        return view('pagos.index', compact('pagos', 'proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $compras = Compra::all();
        return view('pagos.create', compact('compras', $compras));
    }
    public function filtrarPagos(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;
        $proveedor_id = $request->proveedor_id;

        $proveedor_id = $request->proveedor_id;
        if (isset($proveedor_id) && isset($sucursal_id)) {
            $pagos = Pago::whereBetween('fecha', [$fecha_inicial, $fecha_fin])
                ->where([
                    ['proveedor_id', '=', $proveedor_id],
                ])->get();
        } else {
            $pagos = Pago::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();
        }
        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();
        return view('pagos.index', compact('pagos', 'proveedores', 'sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $user_id = Auth::id();
        $user = User::find($user_id);
        $sucursal_id = $user->sucursals[0]->id;
        $primer_compra_id = $request->compras_id[0];
        $compra = Compra::find($primer_compra_id);
        try {
            if (isset($compra->detallePago)) {
                $pago = Pago::find($compra->detallePago->pago->id);
                $pago->tipo_pago = $request->get('tipo_pago');
                $pago->nro_comprobante = $request->get('nro_comprobante');
                $pago->save();

                $pago_proveedor = 0;
                $total_pago = 0;
                for ($i = 0; $i < sizeof($request->compras_id); $i++) {
                    $compra = Compra::find($request->compras_id[$i]);
                    $compra->estado = 'P';
                    $compra->save();
                    $pago_proveedor = $compra->proveedor_id;
                    $total_pago += $compra->total;
                }
                $pago->update(['proveedor_id' => $pago_proveedor, 'total' => $total_pago]);
            } else {
                $pago = new Pago();
                $pago->fecha = Carbon::now()->toDateString();
                $pago->banco = $request->get('banco');
                $pago->nro_cuenta = $request->get('nro_cuenta');
                $pago->tipo_pago = $request->get('tipo_pago');
                $pago->nro_comprobante = $request->get('nro_comprobante');
                $pago->nro_cheque = $request->get('nro_cheque');
                $pago->user_id =  $user_id;
                $pago->sucursal_id = $sucursal_id;
                $pago->save();

                $pago_proveedor = 0;
                $total_pago = 0;
                for ($i = 0; $i < sizeof($request->compras_id); $i++) {
                    $compra = Compra::find($request->compras_id[$i]);
                    $compra->estado = 'P';
                    $compra->save();

                    $detalle_pago = new DetallePago();
                    $detalle_pago->pago_id = $pago->id;
                    $detalle_pago->compra_id = $compra->id;
                    $detalle_pago->subtotal = $compra->total;
                    $detalle_pago->save();

                    $pago_proveedor = $compra->proveedor_id;
                    $total_pago += $compra->total;
                }
                $pago->update(['proveedor_id' => $pago_proveedor, 'total' => $total_pago]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }


        return response()->json(
            [
                'success' => true
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
        $pago = Pago::find($id);
        $detalle_compra = DetalleCompra::where('compra_id', $id)->get();
        return view('pagos.show', ['pago' => $pago], ['detalle_compra' => $detalle_compra]);
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

    public function downloadPDF($id)
    {
        $pago = Pago::find($id);

        view()->share('pagos.detalleCompra-PDF', $pago);

        $pdf = PDF::loadView('pagos.detallePago-PDF', ['pago' => $pago])
            ->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream('Detalle-Pago-' . $pago->id . '.pdf', ['Attachment' => false]);
    }

    public function reporteProveedores()
    {
        $proveedores = Proveedor::all();

        $collection = Proveedor::selectRaw(' proveedores.id,proveedores.nombre, sum(total) totalCompra,sum(subtotal) as totalPagado ')
            ->leftJoin('compras', 'proveedores.id', '=', 'compras.proveedor_id')
            ->leftJoin('detalles_pago', 'compras.id', '=', 'detalles_pago.compra_id')
            ->groupBy(['proveedores.id', 'proveedores.nombre'])
            ->whereBetween('fecha_compra', [Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->format('Y-m-d')])
            ->get();

        $fecha_inicial = Carbon::now()->locale('es')->startOfMonth()->format('Y-m-d');
        $fecha_final = Carbon::now()->locale('es')->format('Y-m-d');




        return view('contabilidad.reportes.reporteProveedores', compact('collection', 'fecha_inicial', 'fecha_final'));
    }

    public function filtrarComprasyPagos(Request $request)
    {
        $fecha_inicial = new Carbon($request->get('fecha_inicial'));
        $fecha_final = new Carbon($request->get('fecha_final'));

        $collection = Proveedor::selectRaw('proveedores.id,proveedores.nombre, sum(total) totalCompra,sum(subtotal) as totalPagado ')
            ->leftJoin('compras', 'proveedores.id', '=', 'compras.proveedor_id')
            ->leftJoin('detalles_pago', 'compras.id', '=', 'detalles_pago.compra_id')
            ->groupBy(['proveedores.id', 'proveedores.nombre'])
            ->whereBetween('fecha_compra', [$request->get('fecha_inicial'), $request->get('fecha_final')])
            ->get();

        return view('contabilidad.reportes.reporteProveedores', compact('collection', 'fecha_inicial', 'fecha_final'));
    }

    public function detalleComprasyPagos($id, $fecha_inicial, $fecha_final)
    {
        $proveedor = Proveedor::find($id);
        $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_final])
            ->where('proveedor_id', $id)
            ->get();

        $pagos = Pago::whereBetween('fecha', [$fecha_inicial, $fecha_final])
            ->where('proveedor_id', $id)
            ->get();

        return view('contabilidad.reportes.detalleReporteCyP', compact('fecha_inicial', 'fecha_final', 'compras', 'pagos', 'proveedor'));
    }
}
