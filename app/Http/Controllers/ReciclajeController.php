<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaPlato;
use App\Models\DetalleInventario;
use App\Models\DetalleInventarioSistema;
use App\Models\DetalleReciclaje;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use App\Models\Plato;
use App\Models\Producto;
use App\Models\Reciclaje;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReciclajeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {
            $reciclajes = Reciclaje::where('sucursal_id', Auth::user()->sucursals[0]->id)->get();
        } else {
            $reciclajes = Reciclaje::all();
        }
        return view('reciclaje.index', compact('reciclajes'));
    }
    public function obtenerDatosProducto(Request $request)
    {
        $user = Auth::user();
        if (is_null($request->tipo)) {
            $producto = Producto::find($request->producto_id);
            $inventario_p = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
            $inventario = InventarioSistema::where('inventario_id', $inventario_p->id)->first();
            if ($inventario == null) {
                return response()->json([
                    'status' => false,
                    'msj' => 'Sin Inventario Registrado',
                ]);
            }
            $detalleInventario = DetalleInventarioSistema::where('inventario_sistema_id', $inventario->id)->where('producto_id', $producto->id)->first();
            if ($detalleInventario == null) {
                return response()->json([
                    'status' => false,
                    'msj' => 'Sin Stock de ' . $producto->nombre,
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
            /*  dd($request->plato_id); */
            $plato = Plato::find($request->plato_id);
            $precio = $plato->costo_plato;
            $inventario_p = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
            $inventario = InventarioSistema::where('inventario_id', $inventario_p->id)->first();
            if ($inventario == null) {
                return response()->json([
                    'status' => false,
                    'msj' => 'Sin Inventario Registrado',
                ]);
            }
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
        $producto = Producto::find($request->detalleReciclaje['producto_id']);
        if (is_null($request->detalleReciclaje['producto_id'])) {
            $plato = Plato::find($request->detalleReciclaje['plato_id']);
            $plato_id = $plato->id;
            $plato_nombre = $plato->nombre;
            $unidad_medida_nombre = $plato->unidad_medida_compra->nombre;
            $producto_id = null;
            $producto_nombre = "";
        }
        if (is_null($request->detalleReciclaje['plato_id'])) {
            $producto = Producto::find($request->detalleReciclaje['producto_id']);
            $plato_id = null;
            $plato_nombre = "";
            $producto_id = $producto->id;
            $producto_nombre = $producto->nombre;
            $unidad_medida_nombre = $producto->unidad_medida_compra->nombre;
        }

        $detalle_reciclaje = [
            "precio" => $request->detalleReciclaje['precio'],
            "cantidad" => $request->detalleReciclaje['cantidad_reciclar'],
            "subtotal" => $request->detalleReciclaje['cantidad_reciclar'] * $request->detalleReciclaje['precio'],
            "observacion" => $request->detalleReciclaje['observacion'],
            "unidad_medida" => $unidad_medida_nombre,
            "producto_id" =>  $producto_id,
            "producto_nombre" => $producto_nombre,
            "plato_id" => $plato_id,
            "plato_nombre" => $plato_nombre,
        ];
        session()->get('lista_reciclaje');
        session()->push('lista_reciclaje', $detalle_reciclaje);

        return response()->json([
            'lista_reciclaje' => session()->get('lista_reciclaje'),
            'success' => true
        ]);
    }
    public function eliminarDetalle(Request $request)
    {
        $detalle_reciclaje = session('lista_reciclaje');
        unset($detalle_reciclaje[$request->data]);
        session()->put('lista_reciclaje', $detalle_reciclaje);
        return response()->json(
            [
                'lista_reciclaje' => session()->get('lista_reciclaje'),
                'success' => true
            ]
        );
    }

    public function registrarReciclaje(Request $request)
    {
        $user = Auth::user();
        $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema = InventarioSistema::where('inventario_id', $inventario->id)->first();
        $total_reciclaje = 0;
        if ($request->estado == "Con reciclaje") {
            if ($request->inventario_id == 0) {
                $reciclaje = new Reciclaje();
                $reciclaje->fecha = Carbon::now()->format('Y-m-d');
                $reciclaje->total = 0;
                $reciclaje->user_id = $user->id;
                $reciclaje->sucursal_id = $user->sucursals[0]->id;
                $reciclaje->inventario_id = $inventario->id;
                $reciclaje->turno_id = $request->turno;
                $reciclaje->estado = $request->estado;
                $reciclaje->save();

                $total_inventario_actualizado = $inventario_sistema->total;
                foreach (session('lista_reciclaje') as $id => $item) {
                    $total_reciclaje += $item['subtotal'];
                    $detalle_reciclaje  = new DetalleReciclaje();
                    $detalle_reciclaje->precio = $item['precio'];
                    $detalle_reciclaje->cantidad = $item['cantidad'];
                    $detalle_reciclaje->subtotal = $item['subtotal'];
                    $detalle_reciclaje->observacion = $item['observacion'];
                    $detalle_reciclaje->plato_id = $item['plato_id'];
                    $detalle_reciclaje->producto_id = $item['producto_id'];
                    $detalle_reciclaje->reciclaje_id =  $reciclaje->id;
                    $detalle_reciclaje->save();
                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $item['producto_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_reciclaje->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    }

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('plato_id', $item['plato_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_reciclaje->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    }
                }
                $reciclaje->update(['total' => $total_reciclaje]);
                $inventario_sistema->update(['total' => $total_inventario_actualizado]);
                session()->forget('lista_reciclaje');
                return response()->json(
                    [
                        'success' => true
                    ]
                );
            } else {
                $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
                $reciclaje = new Reciclaje();
                $reciclaje->fecha = Carbon::now()->format('Y-m-d');
                $reciclaje->user_id = $user->id;
                $reciclaje->sucursal_id = $user->sucursals[0]->id;
                $reciclaje->inventario_id = $request->inventario_id;
                $reciclaje->turno_id = $request->turno;
                $reciclaje->estado = $request->estado;
                $reciclaje->save();

                $total_inventario_actualizado = $inventario_sistema->total;
                foreach (session('lista_reciclaje') as $id => $item) {
                    $total_reciclaje += $item['subtotal'];
                    $detalle_reciclaje  = new DetalleReciclaje();
                    $detalle_reciclaje->precio = $item['precio'];
                    $detalle_reciclaje->cantidad = $item['cantidad'];
                    $detalle_reciclaje->subtotal = $item['subtotal'];
                    $detalle_reciclaje->observacion = $item['observacion'];
                    $detalle_reciclaje->plato_id = $item['plato_id'];
                    $detalle_reciclaje->producto_id = $item['producto_id'];
                    $detalle_reciclaje->reciclaje_id =  $reciclaje->id;
                    $detalle_reciclaje->save();

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $item['producto_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_reciclaje->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    }

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('plato_id', $item['plato_id'])->first();
                    if (!is_null($detalle_inventario_sistema)) {
                        $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                        $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle_reciclaje->cantidad;
                        $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                        $detalle_inventario_sistema->save();
                        $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
                    }
                }
                $reciclaje->update(['total' => $total_reciclaje]);
                $inventario_sistema->update(['total' => $total_inventario_actualizado]);
                session()->forget('lista_reciclaje');
                return response()->json(
                    [
                        'success' => true
                    ]
                );
            }
        } else {
            $reciclaje = new Reciclaje();
            $reciclaje->fecha = Carbon::now()->format('Y-m-d');
            $reciclaje->user_id = $user->id;
            $reciclaje->sucursal_id = $user->sucursals[0]->id;
            $reciclaje->turno_id = $request->turno;
            $reciclaje->estado = $request->estado;
            $reciclaje->total = 0;
            $reciclaje->save();
            session()->forget('lista_reciclaje');
            return response()->json(
                [
                    'success' => true
                ]
            );
        }
    }
    public function actualizarReciclaje(Request $request)
    {
        //dd($request);
        $user = Auth::user();
        $inventario = Inventario::where('sucursal_id', $user->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema = InventarioSistema::where('inventario_id', $inventario->id)->first();
        $reciclaje = Reciclaje::find($request->reciclaje_id);
        $total_reciclado = 0;
        $total_inventario_actualizado = $inventario_sistema->total;
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_reciclaje = DetalleReciclaje::find($detalleEditar);

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $detalle_reciclaje->producto_id)->first();
                $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + ($detalle_reciclaje->cantidad - $request->stocks[$index]);
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;


                $detalle_reciclaje->cantidad = $request->stocks[$index];
                $detalle_reciclaje->subtotal = $request->subtotales[$index];
                $detalle_reciclaje->save();
            }
        }
        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_reciclaje = DetalleReciclaje::find($detalleEliminar);
                if ($detalle_reciclaje != null) {
                    $total_reciclado += $detalle_reciclaje->subtotal;

                    $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id', $detalle_reciclaje->producto_id)->first();
                    $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                    $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock + $detalle_reciclaje->cantidad;
                    $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                    $detalle_inventario_sistema->save();
                    $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;


                    $detalle_reciclaje->delete();
                }
            }
        }

        if (sizeof($request->detallesAAgregar_datos) != 0) {
            foreach ($request->detallesAAgregar_datos as $index => $detalleAgregar) {
                $detalle =  new DetalleReciclaje();
                $detalle->reciclaje_id = $request->reciclaje_id;
                $detalle->producto_id = $detalleAgregar['idProducto'];
                $detalle->subtotal = ($detalleAgregar['stock'] * $detalleAgregar['precio']);
                $detalle->cantidad = $detalleAgregar['stock'];
                $detalle->precio = $detalleAgregar['precio'];
                $detalle->observacion = $detalleAgregar['observacion'];
                $detalle->save();

                $detalle_inventario_sistema = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema->id)->where('producto_id',  $detalleAgregar['idProducto'])->first();
                $total_inventario_actualizado -= $detalle_inventario_sistema->subtotal;
                $detalle_inventario_sistema->stock = $detalle_inventario_sistema->stock - $detalle->cantidad;
                $detalle_inventario_sistema->subtotal = $detalle_inventario_sistema->stock * $detalle_inventario_sistema->precio;
                $detalle_inventario_sistema->save();
                $total_inventario_actualizado += $detalle_inventario_sistema->subtotal;
            }
        }

        $reciclaje->total = $request->total_reciclaje - $total_reciclado;
        $inventario_sistema->update(['total' => $total_inventario_actualizado]);
        $reciclaje->save();
        return response()->json(
            [
                'success' => true
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        $categorias = Categoria::all();
        $categorias_produccion = CategoriaPlato::all();
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');
        $ultimo_reciclaje = Reciclaje::where('sucursal_id', Auth::user()->sucursals[0]->id)->orderBy('id', 'desc')->count();
        if ($ultimo_reciclaje == null) {
            $ultimo_reciclaje = 1;
        } else {
            $ultimo_reciclaje = $ultimo_reciclaje + 1;
        }
        return view('reciclaje.create', compact('sucursales', 'categorias', 'fecha_actual', 'ultimo_reciclaje', 'categorias_produccion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reciclaje = Reciclaje::find($id);
        return view('reciclaje.show', compact('reciclaje'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reciclaje = Reciclaje::find($id);
        $categorias = Categoria::all();
        return view('reciclaje.edit', compact('reciclaje', 'categorias'));
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
        Reciclaje::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function filtrarreciclaje(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin =  $request->fecha_final;
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {
            $reciclajes = Reciclaje::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->where('sucursal_id', Auth::user()->sucursals[0]->id)->get();
        } else {
            $reciclajes = Reciclaje::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();
        }
        return view('reciclaje.index', compact('reciclajes'));
    }
}
