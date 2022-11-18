<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProyeccionesVentas;
use App\Models\DetalleProyeccionesVentas;
use App\Models\DetalleInventario;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Categoria;
use App\Models\DetalleProyeccionesVentasReales;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ProyeccionesVentasController extends Controller
{

    public function index()
    {
        $proyecciones_ventas = ProyeccionesVentas::all();
        return view('proyecciones_ventas.index', compact('proyecciones_ventas'));
    }


    public function asignarProducto(Request $request)
    {
        $producto_nombre = Producto::find($request->productoproveedor["producto_id"]);
        $producto_proveedor = [
            "fecha" =>   Carbon::now(),
            "cantidad" => $request->productoproveedor['cantidad'],
            "producto_id" => $request->productoproveedor['producto_id'],
            "sucursal_id" => $request->productoproveedor['sucursal'], /*Sueldo pue y bono mas pero de 500 para Jhonatan y Patricio mi bebito fiu fui  xd si :v  */
        ];
        session()->get('asignar_stock');
        session()->push('asignar_stock', $producto_proveedor); /*Guarda la session creada en $producto_proveedor */
        return response()->json([
            'asignar_stock' => session()->get('asignar_stock'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {

        $detalle_productos_proveedores = session('asignar_stock');
        unset($detalle_productos_proveedores[$request->data]);
        session()->put('asignar_stock', $detalle_productos_proveedores);
        return response()->json(
            [
                'asignar_stock' => session()->get('asignar_stock'),
                'success' => true
            ]
        );
    }

    public function store(Request $request)
    {
        /* dd($request); */
        $asignar_stock_cabecera = new ProyeccionesVentas();
        $asignar_stock_cabecera->fecha = Carbon::now();
        $asignar_stock_cabecera->user_id =  Auth()->id();
        $asignar_stock_cabecera->sucursal_id = $request->sucursal;

        $asignar_stock_cabecera->save();

        foreach (session('asignar_stock') as $id => $item) {
            $asignar_stock = new DetalleProyeccionesVentas();
            $asignar_stock->cantidad = $item['cantidad'];
            $asignar_stock->producto_id = $item["producto_id"];
            $asignar_stock->fecha = Carbon::now();

            $asignar_stock->asignar__stock_id = $asignar_stock_cabecera->id;
            $asignar_stock->save();
        }
        session()->forget('asignar_stock');

        session()->get('stock_asignados');
        session()->put('stock_asignados', 'ok');
        return response()->json(
            [
                'success' => true
            ]
        );

        //return redirect()->route('productos_proveedores.index')->with('registrado', 'ok');
    }

    public function show($id)
    {
        $producto = Producto::find($id);
        $asignar_stock = ProyeccionesVentas::find($id);
        return view('proyecciones_ventas.show', compact('producto', 'asignar_stock',));
    }


    public function edit($id)
    {
        $categorias = Categoria::all();
        $asignar_stock = ProyeccionesVentas::find($id);
        return view('proyecciones_ventas.edit', compact('asignar_stock', 'categorias'));
    }

    public function actualizarStock(Request $request)
    {
        $detalles_stock_ideal = ProyeccionesVentas::find($request->asignar__stock_id);
        $total_eliminado = 0;
        /*   $nuevospedidos = $request->agregarNuevos; */

        /*  if (sizeof($nuevospedidos) != 0) {
            foreach ($nuevospedidos as $index => $detalle) {
                $detalle_pedido = new DetalleAsignarStock();
                $detalle_pedido->cantidad = $detalle['cantidad'];   
                $detalle_pedido->asignar__stock_id = $detalles_stock_ideal->id;
                $detalle_pedido->producto_id = $detalle['producto_id']; 
                $detalle_pedido->save();
            }
        } */

        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_pedido = DetalleProyeccionesVentas::find($detalleEditar);
                $detalle_pedido->cantidad = $request->stocks[$index];
                $detalle_pedido->save();
            }
        }
        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_pedido = DetalleProyeccionesVentas::find($detalleEliminar);
                if ($detalle_pedido != null) {
                    $total_eliminado += $detalle_pedido->subtotal;
                    $detalle_pedido->delete();
                }
            }
        }

        $detalles_stock_ideal->save();
        return response()->json(
            [
                'success' => true
            ]
        );
    }


    public function update(Request $request, $id)
    {
        $producto_proveedor = DetalleProyeccionesVentas::find($id);
        $producto_proveedor->precio = $request->precio_producto;
        $producto_proveedor->save();
        return redirect()->route('proyecciones_ventas.index');
    }

    public function destroy($id)
    {
        //
    }
    public function guardarDetalle(Request $request)
    {
        $producto = Producto::find($request->detalleAsignacion["producto"]);
        $sucursal = Sucursal::find($request->detalleAsignacion["sucursal"]);
        $detalle_productos_proveedores = [
            "sucursal_id" =>  $sucursal->id,
            "sucursal_nombre" => $sucursal->nombre,
            "producto_id" => $request->detalleAsignacion['producto'],
            "producto_nombre" => $producto->nombre,
            "cantidad" => $request->detalleAsignacion['cantidad'],
        ];
        session()->get('asignar_stock');
        session()->push('asignar_stock', $detalle_productos_proveedores);
        return response()->json([
            'asignar_stock' => session('asignar_stock'),
            'success' => true
        ]);
    }
    public function showDetalleProyeccion()
    {
        $detalleProyeccionesVentas = DetalleProyeccionesVentas::all();
        return view('proyecciones_ventas.edit', compact('asignar_stock', 'categorias'));
    }

    public function create($param)
    {
        $id = $param;
        $detalleProyeccionesVentas = DetalleProyeccionesVentas::where('proyecciones_ventas_id', $id)->get();
        return view('proyecciones_ventas.create', compact('id', 'detalleProyeccionesVentas'));
    }
    public function create_ventas_reales($param)
    {
        $id = $param;
        $detalleProyeccionesVentas = DetalleProyeccionesVentasReales::where('proyecciones_ventas_id', $id)->get();       
        return view('proyecciones_ventas.create_venta', compact('id', 'detalleProyeccionesVentas'));
    }
    public function agregarNuevaVentaReal(Request $request)
    {
        //dd($request);
        $detalleProyeccionesVentasReales = DetalleProyeccionesVentasReales::where('fecha', $request->fecha)
            ->where('proyecciones_ventas_id', $request->id)
            ->get();
        if (count($detalleProyeccionesVentasReales) > 0) {
            echo "Editar";
            $detalleProyeccionesVentasReales = DetalleProyeccionesVentasReales::where('fecha', $request->fecha)
                ->where('proyecciones_ventas_id', $request->id)
                ->first();
            if ($request->turno === "AM") {
                echo "Editar registro en AM" . '</br>';
                $id = $request->id;
                $detalleProyeccionesVentasReales->venta_real_am = $request->venta;
                $detalleProyeccionesVentasReales->venta_real_subtotal =  $detalleProyeccionesVentasReales->venta_real_am +  $detalleProyeccionesVentasReales->venta_real_pm;
                $detalleProyeccionesVentasReales->save();
            } else {
                echo "Editar registro en PM" . '</br>';
                $id = $request->id;
                $detalleProyeccionesVentasReales->venta_real_pm = $request->venta;
                $detalleProyeccionesVentasReales->venta_real_subtotal = $detalleProyeccionesVentasReales->venta_real_am +  $detalleProyeccionesVentasReales->venta_real_pm;
                $detalleProyeccionesVentasReales->save();
            }
            //editar Proyeccion 
            $this->editarProyeccionesVenta($request->turno, $request->venta, $id);
        } else {
            echo "crear Nuevo registro" . '</br>';
            //Agreagar nuevo detalle
            if ($request->turno === "AM") {
                echo "crear Nuevo registro en AM" . '</br>';
                $id = $request->id;
                $detalleProyeccionesVentasReales = new DetalleProyeccionesVentasReales();
                $detalleProyeccionesVentasReales->fecha = $request->fecha;
                $detalleProyeccionesVentasReales->venta_real_am = $request->venta;
                $detalleProyeccionesVentasReales->venta_real_pm = 0;
                $detalleProyeccionesVentasReales->venta_real_subtotal =  $detalleProyeccionesVentasReales->venta_real_am +  $detalleProyeccionesVentasReales->venta_real_pm;
                $detalleProyeccionesVentasReales->proyecciones_ventas_id = $id;
                $detalleProyeccionesVentasReales->save();
            } else {
                echo "crear Nuevo registro en PM" . '</br>';
                $id = $request->id;
                $detalleProyeccionesVentasReales = new DetalleProyeccionesVentasReales();
                $detalleProyeccionesVentasReales->fecha = $request->fecha;
                $detalleProyeccionesVentasReales->venta_real_am = 0;
                $detalleProyeccionesVentasReales->venta_real_pm = $request->venta;
                $detalleProyeccionesVentasReales->venta_real_subtotal = $detalleProyeccionesVentasReales->venta_real_am +  $detalleProyeccionesVentasReales->venta_real_pm;
                $detalleProyeccionesVentasReales->proyecciones_ventas_id = $id;
                $detalleProyeccionesVentasReales->save();
            }
            //editar Proyeccion 
            $this->editarProyeccionesVenta($request->turno, $request->venta, $id);
        }
        return redirect()->route('proyecciones_ventas.create_ventas_reales', $id);
    }


    public function agregarNuevaProyeccion(Request $request)
    {
        $total = $request->proyeccion_am + $request->proyeccion_pm;
        $id = 0;
        if ($request->id != 0) {
            //Agreagar nuevo detalle
            $id = $request->id;
            $detalleProyeccionesVentas = new DetalleProyeccionesVentas();
            $detalleProyeccionesVentas->fecha_proyeccion = $request->fecha;
            $detalleProyeccionesVentas->venta_proyeccion_am = $request->proyeccion_am;
            $detalleProyeccionesVentas->venta_proyeccion_pm = $request->proyeccion_pm;
            $detalleProyeccionesVentas->venta_proyeccion_subtotal = $total;
            $detalleProyeccionesVentas->proyecciones_ventas_id = $id;
            $detalleProyeccionesVentas->save();
            //BUSCAR LA PROYECCION DE VENTA E IR actualizando el total de proyeccion AM,PM y Total
            $proyeccionVentas = ProyeccionesVentas::where('id', $id)->first();
            $proyeccionVentas->proyeccion_subtotal_am += $request->proyeccion_am;
            $proyeccionVentas->proyeccion_subtotal_pm += $request->proyeccion_pm;
            $proyeccionVentas->total_proyeccion += $total;
            $proyeccionVentas->diferencias = $proyeccionVentas->total_proyeccion * (-1);
            $proyeccionVentas->save();
        } else {
            //CREAR UN NUEVO REGISTRO DE PROYECCION DE VENTAS
            $proyeccionVentas = new ProyeccionesVentas();
            $fecha = Carbon::parse($request->fecha);
            $respuesta = $proyeccionVentas::create([
                'mes_proyeccion' => $fecha->monthName,
                'proyeccion_subtotal_am' => $request->proyeccion_am,
                'proyeccion_subtotal_pm' => $request->proyeccion_pm,
                'total_proyeccion' => $total,
                'venta_subtotal_am' => 0,
                'venta_subtotal_pm' => 0,
                'total_ventas_real' => 0,
                'diferencias' => $total * (-1),
                'user_id' => Auth::user()->id,
                'sucursal_id' => Auth::user()->sucursals[0]->id,
            ]);
            $id = $respuesta->id;
            $detalleProyeccionesVentas = new DetalleProyeccionesVentas();
            $detalleProyeccionesVentas->fecha_proyeccion = $request->fecha;
            $detalleProyeccionesVentas->venta_proyeccion_am = $request->proyeccion_am;
            $detalleProyeccionesVentas->venta_proyeccion_pm = $request->proyeccion_pm;
            $detalleProyeccionesVentas->venta_proyeccion_subtotal = $total;
            $detalleProyeccionesVentas->proyecciones_ventas_id = $respuesta->id;
            $detalleProyeccionesVentas->save();
        }
        return redirect()->route('proyecciones_ventas.create', $id);
    }

    public function editarProyeccionesVenta($turno, $venta, $id)
    {
        $proyeccionVentas = ProyeccionesVentas::where('id', $id)->first();
        if ($turno === "AM") {
            $proyeccionVentas->venta_subtotal_am += $venta;
            $proyeccionVentas->total_ventas_real += $venta;
            $proyeccionVentas->diferencias = $proyeccionVentas->total_proyeccion - $proyeccionVentas->total_ventas_real;
            $proyeccionVentas->save();
        } else {
            $proyeccionVentas->venta_subtotal_pm += $venta;
            $proyeccionVentas->total_ventas_real += $venta;
            $proyeccionVentas->diferencias = $proyeccionVentas->total_proyeccion - $proyeccionVentas->total_ventas_real;
            $proyeccionVentas->save();
        }
    }
    public function reporteCarnicos()
    {

        $fecha_anterior = Carbon::now()->subDay()->toDateString();
        $fecha_actual = Carbon::now()->toDateString();

        $asignar_stocks = ProyeccionesVentas::selectRaw('sucursals.id as sucursal_id, sucursals.nombre sucursal_nombre,productos.nombre as producto_nombre, detalles_stock_ideal.cantidad as Cantidad')
            ->join('sucursals', 'sucursals.id', '=', 'stock_ideal.sucursal_id')
            ->join('detalles_stock_ideal', 'detalles_stock_ideal.asignar__stock_id', '=', 'stock_ideal.id')
            ->join('productos', 'productos.id', '=', 'detalles_stock_ideal.producto_id')
            ->where('sucursals.id', 14)
            ->get();
        /*    dd($asignar_stocks); */

        $inventarios = Inventario::selectRaw('sucursals.id as sucursal_id, sucursals.nombre ,  max(inventarios.created_at) as hora_solicitud ')
            ->join('sucursals', 'inventarios.sucursal_id', '=', 'sucursals.id')
            ->join('detalles_inventario', 'detalles_inventario.inventario_id', '=', 'inventarios.id')
            ->join('productos', 'productos.id', '=', 'detalles_inventario.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->groupBy(['sucursals.id', 'sucursals.nombre'])
            ->whereDate('inventarios.fecha', $fecha_anterior)
            ->where('productos.categoria_id', '=', 9)
            ->get();
        /*dd($inventarios);*/

        $inventarios_carnes = DetalleInventario::selectRaw('sucursals.id as sucursal_id,
        productos.id as producto_id,
        productos.nombre as producto_nombre,
        sucursals.nombre as sucursal_nombre,  
        max(inventarios.created_at) as hora_solicitud,  
        detalles_inventario.stock as stock,
        detalles_stock_ideal.cantidad as cantidad, 
        detalles_stock_ideal.producto_id,
        
        detalles_stock_ideal.producto_id as detalle_stock_producto_id,
        
        detalles_inventario.producto_id as detalle_inventario_producto_id')
            ->join('inventarios', 'inventarios.id', '=', 'detalles_inventario.inventario_id')
            ->join('sucursals', 'sucursals.id', '=', 'inventarios.sucursal_id')
            ->join('productos', 'productos.id', '=', 'detalles_inventario.producto_id')
            ->join('stock_ideal', 'stock_ideal.sucursal_id', '=', 'sucursals.id')
            ->join('detalles_stock_ideal', 'detalles_stock_ideal.asignar__stock_id', '=', 'stock_ideal.id')
            ->groupBy(['sucursals.id', 'sucursals.nombre', 'productos.id', 'productos.nombre', 'detalles_inventario.stock', 'detalles_stock_ideal.cantidad', 'detalles_stock_ideal.producto_id', 'detalles_inventario.producto_id'])
            ->where('productos.categoria_id', '=', 9)
            ->whereDate('inventarios.fecha', '=', $fecha_anterior)
            ->get();

        $array_search = array();
        $collection = collect();
        $invertido = $inventarios_carnes->reverse();

        foreach ($invertido as $inventario_carne) {
            if ($inventario_carne->detalle_stock_producto_id === $inventario_carne->detalle_inventario_producto_id && !in_array(["sucursal_id" => $inventario_carne->sucursal_id, "producto_id" => $inventario_carne->producto_id], $array_search)) {

                array_push($array_search, ["sucursal_id" => $inventario_carne->sucursal_id, "producto_id" => $inventario_carne->producto_id]);
                $collection->push($inventario_carne);
            }
        }


        return view('proyecciones_ventas.reporteCarnicos', compact('asignar_stocks', 'fecha_actual', 'inventarios', 'inventarios_carnes', 'collection'));
    }

    public function filtrarReporteCarnes(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicial');
        $fecha_anterior = Carbon::parse($fecha_inicio)->subDay()->toDateString();

        /*     dd($fecha_anterior); */
        $fecha_actual = $fecha_anterior;

        $asignar_stocks = ProyeccionesVentas::selectRaw('sucursals.id as sucursal_id, sucursals.nombre sucursal_nombre,productos.nombre as producto_nombre, detalles_stock_ideal.cantidad as Cantidad')
            ->join('sucursals', 'sucursals.id', '=', 'stock_ideal.sucursal_id')
            ->join('detalles_stock_ideal', 'detalles_stock_ideal.asignar__stock_id', '=', 'stock_ideal.id')
            ->join('productos', 'productos.id', '=', 'detalles_stock_ideal.producto_id')
            ->where('sucursals.id', 14)
            ->get();
        $inventarios = Inventario::selectRaw('sucursals.id as sucursal_id, sucursals.nombre ,  max(inventarios.created_at) as hora_solicitud ')
            ->join('sucursals', 'inventarios.sucursal_id', '=', 'sucursals.id')
            ->join('detalles_inventario', 'detalles_inventario.inventario_id', '=', 'inventarios.id')
            ->join('productos', 'productos.id', '=', 'detalles_inventario.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->groupBy(['sucursals.id', 'sucursals.nombre'])
            ->whereDate('inventarios.fecha', $fecha_anterior)
            ->where('productos.categoria_id', '=', 9)
            ->get();
        $inventarios_carnes = DetalleInventario::selectRaw('
            sucursals.id as sucursal_id, 
            productos.id as producto_id,
            productos.nombre as producto_nombre,
            sucursals.nombre as sucursal_nombre,  
            max(inventarios.created_at) as hora_solicitud,  
            detalles_inventario.stock as stock,
            detalles_stock_ideal.cantidad as cantidad, 
            detalles_stock_ideal.producto_id as detalle_stock_producto_id, 
            detalles_inventario.producto_id as detalle_inventario_producto_id')
            ->join('inventarios', 'inventarios.id', '=', 'detalles_inventario.inventario_id')
            ->join('sucursals', 'sucursals.id', '=', 'inventarios.sucursal_id')
            ->join('stock_ideal', 'stock_ideal.sucursal_id', '=', 'sucursals.id')
            ->join('detalles_stock_ideal', 'detalles_stock_ideal.asignar__stock_id', '=', 'stock_ideal.id')
            ->join('productos', 'productos.id', '=', 'detalles_inventario.producto_id')
            ->join('categorias', 'categorias.id', '=', 'productos.categoria_id')
            ->groupBy(['sucursals.id', 'sucursals.nombre', 'productos.id', 'productos.nombre', 'detalles_inventario.stock', 'detalles_stock_ideal.cantidad', 'detalles_stock_ideal.producto_id', 'detalles_inventario.producto_id'])
            ->whereDate('inventarios.fecha', '=', $fecha_anterior)
            ->where('productos.categoria_id', '=', 9)
            ->get();




        $array_search = array();
        $collection = collect();
        $invertido = $inventarios_carnes->reverse();

        foreach ($invertido as $inventario_carne) {
            if ($inventario_carne->detalle_stock_producto_id === $inventario_carne->detalle_inventario_producto_id) {
                $collection->push($inventario_carne);
            }
        }


        /*foreach($inventarios as $item){
            echo  json_encode($item)."<br><br>"; 
        }
        dd($collection);*/
        $filter = ProyeccionesVentas::where('fecha', $fecha_inicio)->get();

        return view(
            'proyecciones_ventas.reporteCarnicos',
            compact(
                'filter',
                'fecha_inicio',
                'fecha_anterior',
                'fecha_actual',
                'asignar_stocks',
                'inventarios',
                'inventarios_carnes',
                'collection'
            )
        );
    }
}
