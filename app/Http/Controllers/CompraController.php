<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Compra;
use App\Models\ComprobanteFactura;
use App\Models\ComprobanteRecibo;
use App\Models\DetalleCompra;
use App\Models\DetalleInventarioSistema;
use App\Models\DetallePago;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Producto_Proveedor;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use \Yajra\Datatables\Datatables;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{

    public function downloadPDF($id)
    {
        $compra = Compra::find($id);
        $detalle_compra = DetalleCompra::where('compra_id', $id)->get();

        view()->share('compras.detalleCompra-PDF', $compra);
        view()->share('compras.detalleCompra-PDF', $detalle_compra);

        $pdf = PDF::loadView('compras.detalleCompra-PDF', ['compra' => $compra, 'detalle_compra' => $detalle_compra])->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream('Detalle-Compra-' . $compra->id . '.pdf', ['Attachment' => false]);
    }

    public function index()
    {
        //dd($compras);
        $user = Auth::user();
        $proveedores = Proveedor::all();
        $sucursales = Sucursal::all();
        if ($user->roles[0]->id == 3) {
            $compras = Compra::where('sucursal_id', $user->sucursals[0]->id)->where('fecha_compra', Carbon::now()->format('Y-m-d'))->get();
        } else {
            $compras = Compra::where('fecha_compra', Carbon::now()->format('Y-m-d'))->get();

            /* dd($compras[0]->detallePago); */
        }
        return view('compras.index', compact('compras', 'proveedores', 'sucursales', 'user'));
    }

    public function filtrarCompras(Request $request)
    {
        $user = Auth::user();
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;
        $proveedor_id = $request->proveedor_id;
        $sucursal_id = $request->sucursal_id;
        if ($user->roles[0]->id != 3) {
            if (isset($proveedor_id) && isset($sucursal_id)) {
                $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])
                    ->where([
                        ['proveedor_id', '=', $proveedor_id],
                        ['sucursal_id', '=', $sucursal_id]
                    ])->get();
            } elseif (isset($proveedor_id)) {
                $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])
                    ->where([
                        ['proveedor_id', '=', $proveedor_id]
                    ])->get();
            } elseif (isset($sucursal_id)) {
                $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])
                    ->where([
                        ['sucursal_id', '=', $sucursal_id]
                    ])->get();
            } else {
                $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])->get();
            }
        } else {
            $compras = Compra::whereBetween('fecha_compra', [$fecha_inicial, $fecha_fin])->where('sucursal_id', $user->sucursals[0]->id)->get();
        }

        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();
        //return redirect()->route('compras.index')->with('compras', $compras); 
        return view('compras.index', compact('compras', 'proveedores', 'sucursales', 'user'));
    }


    public function create()
    {

        /*  dd(session('lista_compra')); */
        $user = Auth::user();
        $fecha_actual = Carbon::now()->toDateString();
        $proveedores = Proveedor::all();
        $sucursales = Sucursal::all();
        return view('compras.create', compact("proveedores", "fecha_actual", "sucursales", "user"));
    }


    public function obtenerProductos(Request $request)
    {

        if (isset($request->proveedor_id)) {
            $productos = Producto_Proveedor::where('proveedor_id', $request->proveedor_id)
                ->join('productos', 'productos.id', '=', 'producto_proveedor.producto_id')->get();
            //dd($productos);
            return response()->json(
                [
                    'lista' => $productos,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    public function obtenerPrecios(Request $request)
    {
        if (isset($request->producto_id)) {
            $precio = Producto_Proveedor::where('producto_id', $request->producto_id)
                ->where('proveedor_id', $request->proveedor_id)
                ->where('estado', 'Habilitado')
                ->first();
            if (!isset($precio)) {
                return response()->json(
                    [
                        'success' => false
                    ]
                );
            }

            return response()->json(
                [
                    'precio' => $precio,
                    'success' => true
                ]
            );
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }
    public function guardarDetalle(Request $request)
    {
        $producto_nombre = Producto::find($request->detalleCompra["producto_id"]);
        $detalle_compra = [
            "producto_id" => $request->detalleCompra['producto_id'],
            "producto_nombre" => $producto_nombre,
            "precio" => $request->detalleCompra['precio'],
            "cantidad" => $request->detalleCompra['cantidad'],
            "subtotal" => $request->detalleCompra['subtotal'],
        ];

        session()->get('lista_compra');
        session()->push('lista_compra', $detalle_compra);

        return response()->json([
            'lista_compra' => session()->get('lista_compra'),
            'success' => true
        ]);
    }
    public function eliminarDetalle(Request $request)
    {
        $detalle_compra = session('lista_compra');
        unset($detalle_compra[$request->data]);
        session()->put('lista_compra', $detalle_compra);
        return response()->json(
            [
                'lista_compra' => session()->get('lista_compra'),
                'success' => true
            ]
        );
    }
    public function registrarCompra(Request $request)
    {
        /* dd($request); */
        $user = Auth::user();
        try {
            DB::beginTransaction();

            $compra = new Compra();
            $compra->total = $request->compra_total;
            $compra->glosa = $request->glosa;
            $compra->fecha_compra = Carbon::now()->toDateString();
            $compra->user_id = Auth::id();
            $compra->sucursal_id = $request->sucursal_id;
            $compra->proveedor_id = $request->proveedor_id;
            $compra->tipo_comprobante = $request->t_comprobante;
            $compra->estado = 'N';
            $compra->save();
            $user = Auth::user();
            $inventario = Inventario::where('sucursal_id', $request->sucursal_id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();

            if ($inventario != null) {
                $inventario_sistema = InventarioSistema::where('inventario_id', $inventario->id)->first();
            } else {
                $inventario_sistema = null;
            }

            if ($request->t_comprobante === "R") {
                $comprobante_recibo = new ComprobanteRecibo();
                $comprobante_recibo->nro_recibo = $request->recibo;
                $comprobante_recibo->compra_id = $compra->id;
                $comprobante_recibo->save();
            }

            if ($request->t_comprobante === "F") {
                $comprobante_factura = new ComprobanteFactura();
                $comprobante_factura->numero_factura = $request->factura;
                $comprobante_factura->numero_autorizacion = $request->autorizacion;
                $comprobante_factura->codigo_control = $request->control;
                $comprobante_factura->compra_id = $compra->id;
                $comprobante_factura->save();
            }
            if ($inventario_sistema != null) {
                $total_inventario_actualizado = $inventario_sistema->total;
            }

            foreach (session('lista_compra') as $id => $item) {
                $detalle_compra = new DetalleCompra();
                $detalle_compra->cantidad = $item['cantidad'];
                $detalle_compra->precio_compra = $item['precio'];
                $detalle_compra->subtotal = $item['subtotal'];
                $detalle_compra->compra_id = $compra->id;
                $detalle_compra->producto_id = $item['producto_id'];
                $detalle_compra->save();

                if ($inventario_sistema != null) {
                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $item['producto_id'])->first();
                    if ($detalle_inventario_sistema != null) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + $detalle_compra->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    } else {
                        $detalle_inventario_sistema = new DetalleInventarioSistema();
                        $detalle_inventario_sistema->stock = $item['cantidad'];
                        $detalle_inventario_sistema->precio = $item['precio'];
                        $detalle_inventario_sistema->subtotal = $item['subtotal'];
                        $detalle_inventario_sistema->producto_id = $item['producto_id'];
                        $detalle_inventario_sistema->inventario_sistema_id = $inventario_sistema->id;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    }
                }
            }

            if ($user->roles[0]->id == 5) {
                $pago = new Pago();
                $pago->fecha = Carbon::now()->toDateString();
                $pago->banco = $request->get('banco');
                $pago->nro_cuenta = $request->get('nro_cuenta');
                $pago->nro_cheque = $request->get('nro_cheque');
                $pago->user_id =  $user->id;
                $pago->sucursal_id = $user->sucursals[0]->id;
                $pago->save();

                $detalle_pago = new DetallePago();
                $detalle_pago->pago_id = $pago->id;
                $detalle_pago->compra_id = $compra->id;
                $detalle_pago->subtotal = $compra->total;
                $detalle_pago->save();
            }

            DB::commit();
            session()->forget('lista_compra');
            if ($inventario_sistema != null) {
                $inventario_sistema->update(['total' => $total_inventario_actualizado]);
                if ($inventario_sistema->update()) {
                    return response()->json(
                        [
                            'success' => true
                        ]
                    );
                } else {
                    return response()->json(
                        [
                            'success' => false

                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'success' => true
                    ]
                );
            }
        } catch (\Exception $e) {
            DB::rollback();
            /* return $e->getMessage(); */
            return response()->json(
                [
                    'success' => false,
                    'msg' => $e->getMessage()
                ]
            );
        }
    }

    public function show($id)
    {
        $compra = Compra::find($id);
        $detalle_compra = DetalleCompra::where('compra_id', $id)->get();
        return view('compras.detalleCompra', ['compra' => $compra], ['detalle_compra' => $detalle_compra]);
    }

    public function getCompras()
    {
        $sql = "Select * from compras";
        $compras = DB::select($sql);
        return $compras;
    }

    public function destroy($id)
    {
        $compra = Compra::find($id);
        $compra->delete();
        return response()->json(['success' => true], 200);
    }

    public function obtenerDetallePago()
    {
    }
}
