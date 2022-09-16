<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaPlato;
use App\Models\DetalleEliminacion;
use App\Models\DetalleInventario;
use App\Models\DetalleInventarioSistema;
use App\Models\Eliminacion;
use App\Models\Plato;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use App\Models\Producto;
use App\Models\Producto_Proveedor;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EliminacionController extends Controller
{

    public function index()
    {
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {
            $eliminaciones = Eliminacion::where('sucursal_id', Auth::user()->sucursals[0]->id)
                ->whereDate('fecha', Carbon::now()->toDateString())
                ->get();
        } else {
            $eliminaciones = Eliminacion::whereDate('fecha', Carbon::now()->toDateString())->get();
        }
        return view('eliminaciones.index', compact('eliminaciones'));
    }

    public function create()
    {
        $user = Auth::user();
        /*    $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        if(!is_null($inventassrio)){
            $inventario_sistema = InventarioSistema::where('inventario_id', $inventario->id)->first();
        }else{
            $inventario_sistema=null;
        }
    */

        $sucursales = Sucursal::all();
        $categorias = Categoria::all();
        $platos = Plato::all();
        /* dd($categorias_produccion); */
        $last_eliminacion = Eliminacion::where('sucursal_id', Auth::user()->sucursals[0]->id)->orderBy('id', 'desc')->count();
        if ($last_eliminacion == null) {
            $last_eliminacion = 1;
        } else {
            $last_eliminacion = $last_eliminacion + 1;
        }
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('eliminaciones.create', compact('sucursales', 'platos', 'categorias', 'fecha_actual', 'last_eliminacion'));
    }

    public function show($id)
    {
        $eliminacion = Eliminacion::find($id);
        return view('eliminaciones.show', compact('eliminacion'));
    }

    public function edit($id)
    {
        $categorias = Categoria::all();
        $eliminacion = Eliminacion::find($id);
        return view('eliminaciones.edit', compact('eliminacion', 'categorias'));
    }

    public function destroy($id)
    {
        Eliminacion::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function obtenerDatosProducto(Request $request)
    {
        $user = Auth::user();
        if (is_null($request->tipo)) {
            $producto = Producto::find($request->producto_id);
            $inventario_p = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
            if ($inventario_p == null) {
                $precio = Producto_Proveedor::where('producto_id', '=', $request->producto_id)->orderBy('id', 'desc')->first();

                return response()->json([
                    'status' => true,
                    'inventario_id' => 0,
                    'stock' => 0,
                    'precio' => $precio->precio,
                    'unidad_medida' => $producto->unidad_medida_compra->nombre,
                ]);
                
            }
            $inventario = InventarioSistema::where('inventario_id', $inventario_p->id)->first();
            $detalleInventario = DetalleInventarioSistema::where('inventario_sistema_id', $inventario->id)->where('producto_id', $producto->id)->first();
            if ($detalleInventario == null) {
                $precio = Producto_Proveedor::where('producto_id', '=', $request->producto_id)->orderBy('id', 'desc')->first();

                return response()->json([
                    'status' => true,
                    'inventario_id' => 0,
                    'stock' => 0,
                    'precio' => $precio->precio,
                    'unidad_medida' => $producto->unidad_medida_compra->nombre,
                ]);
            }
            return response()->json([
                'status' => true,
                'inventario_id' => $inventario->id,
                'stock' => $detalleInventario->stock,
                'precio' => $detalleInventario->precio,
                'unidad_medida' => $detalleInventario->producto->unidad_medida_compra->nombre,
            ]);
        } else {
            $plato = Plato::find($request->plato_id);
            $precio = $plato->costo_plato;
            $inventario_p = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
            if ($inventario_p == null) {
                return response()->json([
                    'status' => true,
                    'inventario_id' => $plato->id,
                    'stock' => 0,
                    'precio' => $precio,
                    'unidad_medida' => $plato->unidad_medida_compra->nombre,
                ]);
            }
            $inventario = InventarioSistema::where('inventario_id', $inventario_p->id)->first();
            $detalleInventario = DetalleInventarioSistema::where(
                [
                    ['plato_id', "=", $request->plato_id],
                    ['inventario_sistema_id', "=", $inventario->id]
                ]
            )->first();
            if (is_null($detalleInventario)) {
                $detalleInventario = new DetalleInventarioSistema();
                $detalleInventario->stock = 0;
            } else {
                //si no es null el inventario, obtenemos ese precio
                $precio = $detalleInventario->precio;
            }
            return response()->json([
                'status' => true,
                'inventario_id' => $plato->id,
                'stock' => $detalleInventario->stock,
                'precio' => $precio,
                'unidad_medida' => $plato->unidad_medida_compra->nombre,
            ]);
        }
    }

    public function agregarDetalle(Request $request)
    {
        $producto = Producto::find($request->detalleEliminacion['producto_id']);
        if (is_null($request->detalleEliminacion['producto_id'])) {
            $plato = Plato::find($request->detalleEliminacion['plato_id']);
            $plato_id = $plato->id;
            $plato_nombre = $plato->nombre;
            $unidad_medida_nombre = $plato->unidad_medida_compra->nombre;
            $producto_id = null;
            $producto_nombre = "";
        }
        if (is_null($request->detalleEliminacion['plato_id'])) {
            $producto = Producto::find($request->detalleEliminacion['producto_id']);
            $plato_id = null;
            $plato_nombre = "";
            $producto_id = $producto->id;
            $producto_nombre = $producto->nombre;
            $unidad_medida_nombre = $producto->unidad_medida_compra->nombre;
        }
        $detalle_eliminacion = [
            "precio" => $request->detalleEliminacion['precio'],
            "cantidad" => $request->detalleEliminacion['cantidad_eliminar'],
            "subtotal" => $request->detalleEliminacion['cantidad_eliminar'] * $request->detalleEliminacion['precio'],
            "observacion" => $request->detalleEliminacion['observacion'],
            "unidad_medida" => $unidad_medida_nombre,
            "producto_id" =>  $producto_id,
            "producto_nombre" => $producto_nombre,
            "plato_id" => $plato_id,
            "plato_nombre" => $plato_nombre,
        ];
        session()->get('lista_eliminacion');
        session()->push('lista_eliminacion', $detalle_eliminacion);
        return response()->json([
            'lista_eliminacion' => session()->get('lista_eliminacion'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_eliminacion = session('lista_eliminacion');
        unset($detalle_eliminacion[$request->data]);
        session()->put('lista_eliminacion', $detalle_eliminacion);
        return response()->json(
            [
                'lista_eliminacion' => session()->get('lista_eliminacion'),
                'success' => true
            ]
        );
    }


    public function registrarEliminacion(Request $request)
    {
        $user = Auth::user();
        $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        if ($inventario != null) {
            $inventario_sistema = InventarioSistema::where('inventario_id', $inventario->id)->first();
        }
        $total_eliminacion = 0;

        if ($request->estado == "Con Eliminacion") {
            if ($request->inventario_id == 0) {
                $eliminacion = new Eliminacion();
                $eliminacion->fecha = Carbon::now()->format('Y-m-d');
                $eliminacion->user_id = $user->id;
                $eliminacion->sucursal_id = $user->sucursals[0]->id;
                if ($inventario != null) {
                    $eliminacion->inventario_id = $inventario->id;
                }
                $eliminacion->turno_id = $request->turno;
                $eliminacion->estado = $request->estado;
                $eliminacion->save();

                if ($inventario != null) {
                    $total_inventario_actualizado = $inventario_sistema->total;
                }
                foreach (session('lista_eliminacion') as $id => $item) {
                    $total_eliminacion += $item['subtotal'];
                    $detalle_eliminacion = new DetalleEliminacion();
                    $detalle_eliminacion->precio = $item['precio'];
                    $detalle_eliminacion->cantidad = $item['cantidad'];
                    $detalle_eliminacion->subtotal = $item['subtotal'];
                    $detalle_eliminacion->observacion = $item['observacion'];
                    $detalle_eliminacion->producto_id = $item['producto_id'];
                    $detalle_eliminacion->plato_id = $item['plato_id'];
                    $detalle_eliminacion->eliminacion_id = $eliminacion->id;
                    $detalle_eliminacion->save();

                    /*  $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $item['producto_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_eliminacion->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    }

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('plato_id', $item['plato_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_eliminacion->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    } */
                }
                $eliminacion->update(['total' => $total_eliminacion]);
                /*          $inventario_sistema->update(['total' => $total_inventario_actualizado]); */
                session()->forget('lista_eliminacion');
                return response()->json(
                    [
                        'success' => true
                    ]
                );
            } else {
                $eliminacion = new Eliminacion();
                $eliminacion->fecha = Carbon::now()->format('Y-m-d');
                $eliminacion->user_id = $user->id;
                $eliminacion->sucursal_id = $user->sucursals[0]->id;
                $eliminacion->inventario_id = $request->inventario_id;
                $eliminacion->turno_id = $request->turno;
                $eliminacion->estado = $request->estado;
                $eliminacion->save();

                if($inventario!=null){
                    $total_inventario_actualizado = $inventario_sistema->total;
                }
                foreach (session('lista_eliminacion') as $id => $item) {
                    $total_eliminacion += $item['subtotal'];
                    $detalle_eliminacion = new DetalleEliminacion();
                    $detalle_eliminacion->precio = $item['precio'];
                    $detalle_eliminacion->cantidad = $item['cantidad'];
                    $detalle_eliminacion->subtotal = $item['subtotal'];
                    $detalle_eliminacion->observacion = $item['observacion'];
                    $detalle_eliminacion->producto_id = $item['producto_id'];
                    $detalle_eliminacion->plato_id = $item['plato_id'];
                    $detalle_eliminacion->eliminacion_id = $eliminacion->id;
                    $detalle_eliminacion->save();
                    /*  $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $item['producto_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_eliminacion->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    } else {
                        $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('plato_id', $item['plato_id'])->first();
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_eliminacion->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    } */
                }
                $eliminacion->update(['total' => $total_eliminacion]);
                /*   $inventario_sistema->update(['total' => $total_inventario_actualizado]); */

                session()->forget('lista_eliminacion');
                return response()->json(
                    [
                        'success' => true
                    ]
                );
            }
        } else if ($request->estado == "Sin Eliminacion") {
            $eliminacion = new Eliminacion();
            $eliminacion->fecha = Carbon::now()->format('Y-m-d');
            $eliminacion->user_id = $user->id;
            $eliminacion->sucursal_id = $user->sucursals[0]->id;
            $eliminacion->turno_id = $request->turno;
            $eliminacion->estado = $request->estado;
            $eliminacion->total = 0;
            $eliminacion->save();
            //session()->forget('lista_eliminacion');
            return response()->json(
                [
                    'success' => true
                ]
            );
        }
    }

    public function actualizarEliminacion(Request $request)
    {
        $user = Auth::user();
        $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema = InventarioSistema::where('inventario_id', $inventario->id)->first();
        $eliminacion = Eliminacion::find($request->eliminacion_id);
        $total_eliminado = 0;
        $total_inventario_actualizado = $inventario_sistema->total;
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_eliminacion = DetalleEliminacion::find($detalleEditar);

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $detalle_eliminacion->producto_id)->first();
                $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + ($detalle_eliminacion->cantidad - $request->stocks[$index]);
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;

                $detalle_eliminacion->cantidad = $request->stocks[$index];
                $detalle_eliminacion->subtotal = $request->subtotales[$index];
                $detalle_eliminacion->save();
            }
        }

        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_eliminacion = DetalleEliminacion::find($detalleEliminar);
                if ($detalle_eliminacion != null) {
                    $total_eliminado += $detalle_eliminacion->subtotal;

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $detalle_eliminacion->producto_id)->first();
                    $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                    $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + $detalle_eliminacion->cantidad;
                    $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                    $detalle_inventario_sistema->save();
                    $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;

                    $detalle_eliminacion->delete();
                }
            }
        }
        if (sizeof($request->detallesAAgregar_datos) != 0) {
            foreach ($request->detallesAAgregar_datos as $index => $detalleAgregar) {
                $detalle =  new DetalleEliminacion();
                $detalle->precio = $detalleAgregar['precio'];
                $detalle->cantidad = $detalleAgregar['stock'];
                $detalle->subtotal = $detalleAgregar['stock'] * $detalleAgregar['precio'];
                $detalle->observacion = $detalleAgregar['observacion'];
                $detalle->producto_id = $detalleAgregar['idProducto'];
                $detalle->eliminacion_id = $eliminacion->id;
                $detalle->save();

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id',  $detalleAgregar['idProducto'])->first();
                $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle->cantidad;
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
            }
        }
        $eliminacion->total = $request->total_eliminacion - $total_eliminado;
        $inventario_sistema->update(['total' => $total_inventario_actualizado]);
        $eliminacion->save();
        return response()->json(
            [
                'success' => true
            ]
        );
    }
    public function guardarDetalleEnTable(Request $request)
    {
        $producto = Producto::find($request->producto_id);
        //$precio = Producto::select('precio')->where('producto_id', $request->producto_id)->get();
        $ultimo_indice = sizeof($producto->productos_proveedores);

        if (isset($producto->productos_proveedores[$ultimo_indice - 1]->precio)) {
            $costo = $producto->productos_proveedores[$ultimo_indice - 1]->precio;
        } else {
            $costo = 0;
        }
        return response()->json(
            [
                'precio' => $costo,
                'unidad_medida' => $producto->unidad_medida_compra->nombre,
                'success' => true
            ]
        );
    }

    public function filtrarEliminacion(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {

            $eliminaciones = Eliminacion::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_fin)->get();
        } else {
            $eliminaciones = Eliminacion::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_fin)->get();
        }

        return view('eliminaciones.index', compact('eliminaciones'));
    }
}
