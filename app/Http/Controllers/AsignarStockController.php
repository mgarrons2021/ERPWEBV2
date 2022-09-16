<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignar_Stock;
use App\Models\DetalleAsignarStock;
use App\Models\DetalleInventario;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Categoria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AsignarStockController extends Controller
{

    public function index()
    {
        $asignar_stockes = Asignar_Stock::all();
        return view('asignar_stock.index', compact('asignar_stockes'));
    }

    public function create()
    {
        $fecha_act = date("Y-m-d");
        $productos = Producto::all();
        $sucursales = Sucursal::all();

        return view('asignar_stock.create', compact('fecha_act'))->with('productos', $productos)->with('sucursales', $sucursales);
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
        $asignar_stock_cabecera = new Asignar_Stock();
        $asignar_stock_cabecera->fecha = Carbon::now();
        $asignar_stock_cabecera->user_id =  Auth()->id();
        $asignar_stock_cabecera->sucursal_id = $request->sucursal;

        $asignar_stock_cabecera->save();

        foreach (session('asignar_stock') as $id => $item) {
            $asignar_stock = new DetalleAsignarStock();
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
        $asignar_stock = Asignar_Stock::find($id);
        return view('asignar_stock.show', compact('producto', 'asignar_stock',));
    }
    
    
    public function edit($id)
    {
        $categorias = Categoria::all();
        $asignar_stock = Asignar_Stock::find($id);
        return view('asignar_stock.edit', compact('asignar_stock', 'categorias'));
    }
     
    public function actualizarStock(Request $request)
    {
        $detalles_stock_ideal= Asignar_Stock::find($request->asignar__stock_id);
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
                $detalle_pedido = DetalleAsignarStock::find($detalleEditar);
                $detalle_pedido-> cantidad = $request->stocks[$index];
                $detalle_pedido->save();
            }
        }
        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_pedido = DetalleAsignarStock::find($detalleEliminar);
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
        $producto_proveedor = DetalleAsignarStock::find($id);
        $producto_proveedor->precio = $request->precio_producto;
        $producto_proveedor->save();
        return redirect()->route('asignar_stock.index');
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

    public function reporteCarnicos()
    {

        $fecha_anterior = Carbon::now()->subDay()->toDateString();
        $fecha_actual = Carbon::now()->toDateString();

        $asignar_stocks = Asignar_Stock::selectRaw('sucursals.id as sucursal_id, sucursals.nombre sucursal_nombre,productos.nombre as producto_nombre, detalles_stock_ideal.cantidad as Cantidad')
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


        return view('asignar_stock.reporteCarnicos', compact('asignar_stocks', 'fecha_actual', 'inventarios', 'inventarios_carnes', 'collection'));
    }

    public function filtrarReporteCarnes(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicial');
        $fecha_anterior = Carbon::parse($fecha_inicio)->subDay()->toDateString();

        /*     dd($fecha_anterior); */
        $fecha_actual = $fecha_anterior;

        $asignar_stocks = Asignar_Stock::selectRaw('sucursals.id as sucursal_id, sucursals.nombre sucursal_nombre,productos.nombre as producto_nombre, detalles_stock_ideal.cantidad as Cantidad')
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
            if ($inventario_carne->detalle_stock_producto_id === $inventario_carne->detalle_inventario_producto_id ) {
                $collection->push($inventario_carne);
            }
        }

	
        /*foreach($inventarios as $item){
            echo  json_encode($item)."<br><br>"; 
        }
        dd($collection);*/ 
        $filter = Asignar_Stock::where('fecha', $fecha_inicio)->get();

        return view(
            'asignar_stock.reporteCarnicos',
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