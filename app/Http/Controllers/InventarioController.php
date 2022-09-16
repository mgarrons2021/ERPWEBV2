<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaPlato;
use App\Models\DetalleInventario;
use App\Models\DetalleInventarioSistema;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Turno;
use App\Models\UnidadMedidaCompra;
use App\Models\UnidadMedidaVenta;
use App\Models\Producto_Proveedor;
use App\Models\Proveedor;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class InventarioController extends Controller
{

    public function index()

    {

        if (auth()->check() != false) {
            $user_rol = Auth::user()->roles[0]->id;
            if ($user_rol == 3) {
                $inventarios = Inventario::where('sucursal_id', Auth::user()->sucursals[0]->id)
                    ->whereDate('fecha', Carbon::now()->toDateString())
                    ->get();
            } else {

                $inventarios = Inventario::whereDate('fecha', Carbon::now()->toDateString())->get();
            }
        } else {
            $inventarios = Inventario::whereDate('fecha', Carbon::now()->toDateString())->get();
        }

        return view('inventarios.index', compact('inventarios'));
    }


    public function create()
    {
        $usuarios = User::all();
        $sucursales = Sucursal::all();
        $categorias = Categoria::all();
        $categorias_produccion = CategoriaPlato::all();
        $productos = Producto::all();
        $turnos = Turno::all();
        $unidades_medidades = UnidadMedidaCompra::all();


        $last_inventario = Inventario::where('sucursal_id', Auth::user()->sucursals[0]->id)->orderBy('id', 'desc')->count();

        if ($last_inventario == null) {
            $last_inventario = 1;
        } else {
            $last_inventario = $last_inventario + 1;
        }


        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        return view('inventarios.create', compact('usuarios', 'sucursales', 'categorias', 'fecha_actual', 'last_inventario', 'turnos', 'unidades_medidades', 'productos', 'categorias_produccion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showInventarioSistema($id)
    {
        /*Mostrar Inventario Sistema*/
        $inventario_original = Inventario::find($id);
        $inventario = InventarioSistema::where('inventario_id', $inventario_original->id)->first();
        return view('inventarios.show', compact('inventario'));
    }

    public function show($id)
    {
        /*  dd($id); */
        /*Mostrar Inventario Sistema*/
        $inventario = Inventario::find($id);
        return view('inventarios.show', compact('inventario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*Editar Inventario Sistema*/
        /*  dd('hola '. $id); */
        $inventario = Inventario::find($id);
        //dd($inventario->detalle_inventarios[0]->producto->nombre);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('inventarios.edit', compact('inventario', 'categorias', 'proveedores'));
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
        /* dd($id); */
        Inventario::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function obtenerInsumos(Request $request)
    {
        if (isset($request->categoria_id)) {
            $productos = Producto::where('categoria_id', $request->categoria_id)->get();
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

    public function guardarDetalleInventario(Request $request)
    {
        $producto = Producto::find($request->detalleInventario["producto_id"]);
        $producto_id = $producto->id;
        $unidad_medida = UnidadMedidaVenta::find($request->detalleInventario["unidad_medida_id"]);
        $ultimo_indice = sizeof($producto->productos_proveedores);
        if (isset($producto->productos_proveedores[$ultimo_indice - 1]->precio)) {
            $costo = $producto->productos_proveedores[$ultimo_indice - 1]->precio;
            $subtotal = $producto->productos_proveedores[$ultimo_indice - 1]->precio * $request->detalleInventario['stock'];
        } else {
            $costo = 0;
            $subtotal = 0;
        }
        /* dd($producto_id); */
        /*FILETES*/
        $nueva_cantidad = $request->detalleInventario['stock'];
        $nueva_subtotal =  $subtotal;
        $nuevo_precio =  $costo;
        $nueva_UM_nombre = $unidad_medida->nombre;
        $nueva_UM_id = $unidad_medida->id;
        if ($producto_id == 3) {
            $filete_en_unidades = $request->detalleInventario['stock'] / 0.18;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
            $json = [$filete_en_unidades, $precio_por_unidad_filete, $nuevo_precio, $nueva_cantidad, $nueva_subtotal];
            /*  dd($json); */
        }

        /*CHULETA DE CERDO DE 200 GR*/
        if ($producto_id == 21) {
            $filete_en_unidades = $request->detalleInventario['stock'] / 0.200;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }
        /*CHORIZOS*/

        if ($producto_id == 195 || $producto_id == 240) {
            $filete_en_unidades = $request->detalleInventario['stock'] * 10;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }
        /*ALITAS DE POLLO*/

        if ($producto_id == 201) {
            $filete_en_unidades = $request->detalleInventario['stock'] * 8;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete + 1.8;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

        /*POLLO BRASA*/

        if ($producto_id == 200) {
            $filete_en_unidades = $request->detalleInventario['stock'] * 8;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = 26.49;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

        /*ENVASE TECNOPOR*/
        if ($producto_id == 165) {
            $filete_en_unidades = $request->detalleInventario['stock'] * 400;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

        /*PLATANOS*/
        if ($producto_id == 45) {
            $filete_en_unidades = $request->detalleInventario['stock'] * 64;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = $precio_por_unidad_filete;
            $nueva_cantidad = $request->detalleInventario['stock'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

        $detalle_inventario = [
            "producto_id" => $request->detalleInventario['producto_id'],
            "producto_nombre" => $producto->nombre,
            "unidad_medida_id" => $nueva_UM_id,
            "unidad_medida_nombre" => $nueva_UM_nombre,
            "stock" => $nueva_cantidad,
            "costo" => $nuevo_precio,
            "subtotal" => $nueva_subtotal,
        ];

        session()->get('lista_inventario');
        session()->push('lista_inventario', $detalle_inventario);

        return response()->json([
            'lista_inventario' => session()->get('lista_inventario'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_inventario = session('lista_inventario');
        unset($detalle_inventario[$request->data]);
        session()->put('lista_inventario', $detalle_inventario);
        return response()->json(
            [
                'lista_inventario' => session()->get('lista_inventario'),
                'success' => true
            ]
        );
    }

    public function obtenerProductosxId(Request $request)
    {
        $productos = Producto_Proveedor::where('proveedor_id', '=', $request->id)
            ->with('producto')->get();

        if ($productos != null) {
            return response()->json(
                [
                    'lista_productos' => $productos,
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

    public function registrarInventario(Request $request)
    {
        $inventario = new Inventario();
        $inventario->fecha = Carbon::now()->toDateString();
        $inventario->tipo_inventario = $request->tipo_inventario;
        $inventario->sucursal_id = Auth::user()->sucursals[0]->id;
        $inventario->user_id = Auth::id();
        if (isset($request->turno)) {
            $inventario->turno_id = $request->turno;
        }
        $inventario->save();

        $total_inventario = 0;

        foreach (session('lista_inventario') as $id => $item) {
            $total_inventario += $item['subtotal'];
            $detalle_inventario = new DetalleInventario();
            $detalle_inventario->stock = $item['stock'];
            $detalle_inventario->precio = $item['costo'];
            $detalle_inventario->subtotal = $item['subtotal'];
            $detalle_inventario->producto_id = $item['producto_id'];
            $detalle_inventario->inventario_id = $inventario->id;
            $detalle_inventario->save();
        }
        $inventario->update(['total' => $total_inventario]);

        return $inventario->id;
    }


    public function registrarInventarioSistema(Request $request, $inventario_id)
    {
        $inventario = new InventarioSistema();
        $inventario->fecha = Carbon::now()->toDateString();
        $inventario->tipo_inventario = $request->tipo_inventario;
        $inventario->sucursal_id = Auth::user()->sucursals[0]->id;
        $inventario->user_id = Auth::id();
        $inventario->inventario_id = $inventario_id;
        if (isset($request->turno)) {
            $inventario->turno_id = $request->turno;
        }
        $inventario->save();
        $total_inventario = 0;
        foreach (session('lista_inventario') as $id => $item) {
            $total_inventario += $item['subtotal'];
            $detalle_inventario = new DetalleInventarioSistema();
            $detalle_inventario->stock = $item['stock'];
            $detalle_inventario->precio = $item['costo'];
            $detalle_inventario->subtotal = $item['subtotal'];
            $detalle_inventario->producto_id = $item['producto_id'];
            $detalle_inventario->inventario_sistema_id = $inventario->id;
            $detalle_inventario->save();
        }
        $inventario->update(['total' => $total_inventario]);
        return $inventario->update();
    }

    public function obtenerPrecios(Request $request)
    {
        $producto = Producto::find($request->producto_id);

        $ultimo_indice = sizeof($producto->productos_proveedores);

        if (isset($producto->productos_proveedores[$ultimo_indice - 1]->precio)) {
            $costo = $producto->productos_proveedores[$ultimo_indice - 1]->precio;
        } else {
            $costo = 0;
        }

        return response()->json(
            [
                'precio' => $costo,
                'nombre' => $producto->nombre,
                'unidad_medida' => $producto->unidad_medida_compra->nombre,
                'success' => true
            ]
        );
    }

    public function registrarInventarios(Request $request)
    {
        $inventario_id = $this->registrarInventario($request);
        if ($this->registrarInventarioSistema($request, $inventario_id)) {
            session()->forget('lista_inventario');
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
    }

    public function actualizarInventarios(Request $request)
    {
        if ($this->actualizarInventarioSistema($request) && $this->actualizarInventario($request)) {
            return response()->json(
                [
                    'success' => true
                ]
            );
        }
    }

    public function actualizarInventarioSistema(Request $request)
    {
        /*Actualizar Datos Inventario Sistema*/
        $inventario_principal = Inventario::find($request->inventario_id);
        $inventario = InventarioSistema::where('inventario_id', $inventario_principal->id)->first();
        $total_eliminado = 0;
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_inventario = DetalleInventarioSistema::find($detalleEditar);
                $detalle_inventario->stock = $request->stocks[$index];
                $detalle_inventario->subtotal = $request->subtotales[$index];
                $detalle_inventario->save();
            }
        }

        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_inventario = DetalleInventarioSistema::find($detalleEliminar);
                if ($detalle_inventario != null) {
                    $total_eliminado += $detalle_inventario->subtotal;
                    $detalle_inventario->delete();
                }
            }
        }

        if (sizeof($request->detallesAAgregar_datos) != 0) {
            foreach ($request->detallesAAgregar_datos as $index => $detalleAgregar) {
                $detalle =  new DetalleInventarioSistema();
                $detalle->inventario_sistema_id  = $request->inventario_id;
                $detalle->producto_id = $detalleAgregar['idInsumo'];
                $detalle->stock =  $detalleAgregar['stock'];
                $detalle->precio =  $detalleAgregar['precio'];
                $detalle->subtotal = ($detalleAgregar['stock'] * $detalleAgregar['precio']);
                $detalle->save();
            }
        }
        $inventario->total = $request->total_inventario - $total_eliminado;
        return $inventario->save();
    }

    public function actualizarInventario(Request $request)
    {
        /*Actualizar Datos Inventario */
        $inventario = Inventario::find($request->inventario_id);
        $total_eliminado = 0;
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_inventario = DetalleInventario::find($detalleEditar);
                $detalle_inventario->stock = $request->stocks[$index];
                $detalle_inventario->subtotal = $request->subtotales[$index];
                $detalle_inventario->save();
            }
        }

        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_inventario = DetalleInventario::find($detalleEliminar);
                if ($detalle_inventario != null) {
                    $total_eliminado += $detalle_inventario->subtotal;
                    $detalle_inventario->delete();
                }
            }
        }

        if (sizeof($request->detallesAAgregar_datos) != 0) {
            foreach ($request->detallesAAgregar_datos as $index => $detalleAgregar) {
                $detalle =  new DetalleInventario();
                $detalle->inventario_id  = $request->inventario_id;
                $detalle->producto_id = $detalleAgregar['idInsumo'];
                $detalle->stock =  $detalleAgregar['stock'];
                $detalle->precio =  $detalleAgregar['precio'];
                $detalle->subtotal = ($detalleAgregar['stock'] * $detalleAgregar['precio']);
                $detalle->save();
            }
        }
        $inventario->total = $request->total_inventario - $total_eliminado;
        return $inventario->save();
    }

    public function obtenerUM(Request $request)
    {

        $umvid = Producto::select('unidad_medida_compra_id')->where('id', '=', $request->producto_id)->get();
        return response()->json([
            'unidad_medida_compra_id' => $umvid,
            'success' => true
        ]);
    }

    public function filtrarInventario(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;

        if (auth()->check() != false ) {
            $user_rol = Auth::user()->roles[0]->id;
            if ($user_rol == 3) {
                $inventarios = Inventario::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->where('sucursal_id', Auth::user()->sucursals[0]->id)->get();
            } else {
                $inventarios = Inventario::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();
            }
        }else{
            $inventarios = Inventario::whereBetween('fecha', [$fecha_inicial, $fecha_fin])->get();

        }

        return view('inventarios.index', compact('inventarios'));
    }

    public function cambiarEstadoImpresion($id)
    {
        $pedido = Pedido::find($id);
    }
}
