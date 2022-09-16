<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleInventario;
use App\Models\DetalleInventarioSistema;
use App\Models\DetalleTraspaso;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use App\Models\Producto;
use App\Models\Producto_Proveedor;
use App\Models\Sucursal;
use App\Models\Traspaso;
use App\Models\UnidadMedidaVenta;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TraspasoController extends Controller
{
    public function index()
    {
        $traspasos = Traspaso::whereDate('fecha', Carbon::now()->toDateString())->get();
        return view('traspasos.index', compact('traspasos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');
        $sucursales = Sucursal::all();
        $last_traspaso = Traspaso::where('sucursal_principal_id', Auth::user()->sucursals[0]->id)->orderBy('id', 'desc')->count();
        if ($last_traspaso == null) {
            $last_traspaso = 1;
        } else {
            $last_traspaso = $last_traspaso + 1;
        }

        return view('traspasos.create', compact('fecha_actual', 'categorias', 'last_traspaso', 'sucursales'));
    }

    public function edit($id)
    {
        $traspasos = Traspaso::find($id);

        $categorias =   Categoria::all();
        return view('traspasos.edit', compact('traspasos', 'categorias'));
    }

    public function show($id)
    {
        $traspaso = Traspaso::find($id);
        return view('traspasos.show', compact('traspaso'));
    }

    public function destroy($id)
    {
        Traspaso::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function obtenerDatosProducto(Request $request)
    {
        if (isset($request->producto_id)) {
            $producto = Producto::find($request->producto_id);
            //dd($producto);
            $producto_proveedor = Producto_Proveedor::where('producto_id', $request->producto_id)->first();
            //dd($producto_proveedor);
            if (is_null($producto_proveedor)) {
                return response()->json(
                    [
                        'success' => false
                    ]
                );
            } else {
                return response()->json(
                    [
                        'producto_id' => $producto->id,
                        'producto_nombre' => $producto->nombre,
                        'unidad_medida' => $producto->unidad_medida_compra->nombre,
                        'precio' => $producto_proveedor->precio,
                        'success' => true
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    /* public function obtenerDatosProducto(Request $request)
    {
        $producto = Producto::find($request->producto_id);
        $user = Auth::user();
        $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        if ($inventario != null) {
            $detalleInventario = DetalleInventario::where('inventario_id', $inventario->id)->where('producto_id', $producto->id)->first();
            if ($detalleInventario != null) {
                return response()->json([
                    'inventario_id' => $inventario->id,
                    'stock' => $detalleInventario->stock,
                    'precio' => $detalleInventario->precio,
                    'unidad_medida' => $detalleInventario->producto->unidad_medida_compra->nombre,
                ]);
            } else {
                return response()->json(['status' => false]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    } */

    public function agregarDetalle(Request $request)
    {
        $producto = Producto::find($request->detalleTraspaso["producto_id"]);
        $producto_id = $producto->id;
        $ultimo_indice = sizeof($producto->productos_proveedores);

        if (isset($producto->productos_proveedores[$ultimo_indice - 1]->precio)) {
            $costo = $producto->productos_proveedores[$ultimo_indice - 1]->precio;
            $subtotal = $producto->productos_proveedores[$ultimo_indice - 1]->precio * $request->detalleTraspaso['cantidad_traspaso'];
        } else {
            $costo = 0;
            $subtotal = 0;
        }
        /* dd($producto_id); */
        /*FILETES*/
        $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
        $nueva_subtotal =  $subtotal;
        $nuevo_precio =  $costo;
        $nueva_UM_nombre = $producto->unidad_medida_venta->nombre;
        $nueva_UM_id = $producto->unidad_medida_venta->id;
        if ($producto_id == 3) {
            $filete_en_unidades = $request->detalleTraspaso['cantidad_traspaso'] / 0.18;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
            $json = [$filete_en_unidades, $precio_por_unidad_filete, $nuevo_precio, $nueva_cantidad, $nueva_subtotal];
            /*  dd($json); */
        }

        /*CHULETA DE CERDO DE 200 GR*/
        if ($producto_id == 21) {
            $filete_en_unidades = $request->detalleTraspaso['cantidad_traspaso'] / 0.200;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }
        /*CHORIZOS*/

        if ($producto_id == 195 || $producto_id == 240) {
            $filete_en_unidades = $request->detalleTraspaso['cantidad_traspaso'] * 10;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }
        /*ALITAS DE POLLO*/

        if ($producto_id == 201) {
            $filete_en_unidades = $request->detalleTraspaso['cantidad_traspaso'] * 8;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete + 1.8;
            $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

        /*POLLO BRASA*/

        if ($producto_id == 200) {
            $filete_en_unidades = $request->detalleTraspaso['cantidad_traspaso'] * 8;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = 26.49;
            $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

    
        /*PLATANOS*/
        if ($producto_id == 45) {
            $filete_en_unidades = $request->detalleTraspaso['cantidad_traspaso'] * 64;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }
        $detalle_traspaso = [
            "precio" => $nuevo_precio,
            "cantidad" =>  $nueva_cantidad = $request->detalleTraspaso['cantidad_traspaso'],
            "subtotal" =>  $nueva_subtotal,
            "unidad_medida" => $nueva_UM_nombre,
            "producto_id" => $producto->id,
            "producto_nombre" => $producto->nombre,
        ];
        session()->get('lista_traspaso');
        session()->push('lista_traspaso', $detalle_traspaso);
        return response()->json([
            'lista_traspaso' => session()->get('lista_traspaso'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_traspaso = session('lista_traspaso');
        unset($detalle_traspaso[$request->data]);
        session()->put('lista_traspaso', $detalle_traspaso);
        return response()->json(
            [
                'lista_traspaso' => session()->get('lista_traspaso'),
                'success' => true
            ]
        );
    }

    public function actualizarTraspaso(Request $request)
    {


        $traspaso = Traspaso::find($request->traspaso_id);

        $inventario_principal = Inventario::where('sucursal_id', $traspaso->sucursal_principal_id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema_principal = InventarioSistema::where('inventario_id', $inventario_principal->id)->first();

        $inventario_secundario = Inventario::where('sucursal_id', $traspaso->sucursal_secundaria_id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema_secundario = InventarioSistema::where('inventario_id', $inventario_secundario->id)->first();

        $total_inventario_principal_actualizado = $inventario_sistema_principal->total;
        $total_inventario_secundario_actualizado = $inventario_sistema_secundario->total;
        $total_eliminado = 0;
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_traspaso = DetalleTraspaso::find($detalleEditar);

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_principal->id)->where('producto_id', $detalle_traspaso->producto_id)->first();
                $total_inventario_principal_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + ($detalle_traspaso->cantidad - $request->stocks[$index]);
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_principal_actualizado += $detalle_inventario_sistema->subtotal;

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_secundario->id)->where('producto_id', $detalle_traspaso->producto_id)->first();
                $total_inventario_secundario_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - ($detalle_traspaso->cantidad - $request->stocks[$index]);
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema->subtotal;

                $detalle_traspaso->cantidad = $request->stocks[$index];
                $detalle_traspaso->subtotal = $request->subtotales[$index];
                $detalle_traspaso->save();
            }
        }

        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_traspaso = DetalleTraspaso::find($detalleEliminar);
                if ($detalle_traspaso != null) {
                    $total_eliminado += $detalle_traspaso->subtotal;

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_principal->id)->where('producto_id', $detalle_traspaso->producto_id)->first();
                    $total_inventario_principal_actualizado -= $detalle_inventario_sistema->subtotal;
                    $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + $detalle_traspaso->cantidad;
                    $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                    $detalle_inventario_sistema->save();
                    $total_inventario_principal_actualizado += $detalle_inventario_sistema->subtotal;

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_secundario->id)->where('producto_id', $detalle_traspaso->producto_id)->first();
                    $total_inventario_secundario_actualizado -= $detalle_inventario_sistema->subtotal;
                    $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_traspaso->cantidad;
                    $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                    $detalle_inventario_sistema->save();
                    $total_inventario_secundario_actualizado += $detalle_inventario_sistema->subtotal;


                    $detalle_traspaso->delete();
                }
            }
        }

        if (sizeof($request->detallesAAgregar_datos) != 0) {
            foreach ($request->detallesAAgregar_datos as $index => $detalleAgregar) {
                $detalle =  new DetalleTraspaso();
                $detalle->traspaso_id = $request->traspaso_id;
                $detalle->producto_id = $detalleAgregar['idInsumo'];
                $detalle->subtotal = ($detalleAgregar['stock'] * $detalleAgregar['precio']);
                $detalle->cantidad = $detalleAgregar['stock'];
                $detalle->save();

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_principal->id)->where('producto_id', $detalle_traspaso->producto_id)->first();
                $total_inventario_principal_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle->cantidad;
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_principal_actualizado += $detalle_inventario_sistema->subtotal;

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_secundario->id)->where('producto_id', $detalle_traspaso->producto_id)->first();
                $total_inventario_secundario_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + $detalle->cantidad;
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema->subtotal;
            }
        }

        $traspaso->total = $request->total_traspaso - $total_eliminado;
        $inventario_sistema_principal->update(['total' => $total_inventario_principal_actualizado]);
        $inventario_sistema_secundario->update(['total' => $total_inventario_secundario_actualizado]);
        $traspaso->save();
        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function registrarTraspaso(Request $request)
    {
        $traspaso = new Traspaso();
        $traspaso->fecha = Carbon::now()->toDateString();
        $traspaso->estado = 'P';
        $traspaso->user_id = Auth::id();

        $inventario_principal = Inventario::where('sucursal_id', Auth::user()->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        if ($inventario_principal != null) {
            $inventario_sistema_principal = InventarioSistema::where('inventario_id', $inventario_principal->id)->first();
        }


        $inventario_secundario = Inventario::where('sucursal_id', $request->sucursal)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        if ($inventario_secundario != null) {
            $inventario_sistema_secundario = InventarioSistema::where('inventario_id', $inventario_secundario->id)->first();
        } else {
            $inventario_secundario = new Inventario();
            $inventario_secundario->fecha = Carbon::now()->format('Y-m-d');
            $inventario_secundario->tipo_inventario = "D";
            $inventario_secundario->sucursal_id = $request->sucursal;
            $inventario_secundario->save();

            $inventario_sistema_secundario = new InventarioSistema();
            $inventario_sistema_secundario->fecha = Carbon::now()->format('Y-m-d');
            $inventario_sistema_secundario->tipo_inventario = "D";
            $inventario_sistema_secundario->sucursal_id = $request->sucursal;
            $inventario_sistema_secundario->inventario_id = $inventario_secundario->id;
            $inventario_sistema_secundario->save();
        }

        if ($inventario_principal != null) {
            $traspaso->inventario_principal_id = $inventario_principal->id;
        }
        $traspaso->inventario_secundario_id = $inventario_secundario->id;
        $traspaso->sucursal_principal_id = Auth::user()->sucursals[0]->id;
        $traspaso->sucursal_secundaria_id = $request->sucursal;
        $traspaso->save();

        $total_inventario = 0;
        if ($inventario_principal != null) {
            $total_inventario_principal_actualizado = $inventario_sistema_principal->total;
        }
        $total_inventario_secundario_actualizado = $inventario_sistema_secundario->total;
        foreach (session('lista_traspaso') as $id => $item) {
            $total_inventario += $item['subtotal'];
            $detalle_traspaso = new DetalleTraspaso();
            $detalle_traspaso->precio = $item['precio'];
            $detalle_traspaso->cantidad = $item['cantidad'];
            $detalle_traspaso->subtotal = $item['subtotal'];
            $detalle_traspaso->producto_id = $item['producto_id'];
            $detalle_traspaso->traspaso_id = $traspaso->id;
            $detalle_traspaso->save();

            if ($inventario_principal != null) {
                $detalle_inventario_sistema_principal = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_principal->id)->where('producto_id', $item['producto_id'])->first();
                $total_inventario_principal_actualizado -= $detalle_inventario_sistema_principal->subtotal;
                $detalle_inventario_sistema_principal->stock = $detalle_inventario_sistema_principal->stock - $detalle_traspaso->cantidad;
                $detalle_inventario_sistema_principal->subtotal = $detalle_inventario_sistema_principal->stock * $detalle_inventario_sistema_principal->precio;
                $detalle_inventario_sistema_principal->save();
                $total_inventario_principal_actualizado += $detalle_inventario_sistema_principal->subtotal;
            }

            $detalle_inventario_sistema_secundario = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_secundario->id)->where('producto_id', $item['producto_id'])->first();
            if ($detalle_inventario_sistema_secundario != null) {
                $total_inventario_secundario_actualizado -= $detalle_inventario_sistema_secundario->subtotal;
                $detalle_inventario_sistema_secundario->stock = $detalle_inventario_sistema_secundario->stock + $detalle_traspaso->cantidad;
                $detalle_inventario_sistema_secundario->subtotal = $detalle_inventario_sistema_secundario->stock * $detalle_inventario_sistema_secundario->precio;
                $detalle_inventario_sistema_secundario->save();
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema_secundario->subtotal;
            } else {
                $detalle_inventario_sistema_secundario = new DetalleInventarioSistema();
                $detalle_inventario_sistema_secundario->stock = $item['cantidad'];
                $detalle_inventario_sistema_secundario->precio = $item['precio'];
                $detalle_inventario_sistema_secundario->subtotal = $item['subtotal'];
                $detalle_inventario_sistema_secundario->producto_id = $item['producto_id'];
                $detalle_inventario_sistema_secundario->inventario_sistema_id = $inventario_secundario->id;
                $detalle_inventario_sistema_secundario->save();
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema_secundario->subtotal;
            }
        }

        $traspaso->update(['total' => $total_inventario]);
        if ($inventario_principal != null) {
            $inventario_sistema_principal->update(['total' => $total_inventario_principal_actualizado]);
        }
        $inventario_sistema_secundario->update(['total' => $total_inventario_secundario_actualizado]);
        session()->forget('lista_traspaso');
        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function obtenerInventario($sucursal_id)
    {
        return Inventario::where('sucursal_id', $sucursal_id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
    }

    public function filtrartraspaso(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;

        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {
            $traspasos = Traspaso::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();
        } else {
            $traspasos = Traspaso::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();
        }

        return view('traspasos.index', compact('traspasos'));
    }
}
