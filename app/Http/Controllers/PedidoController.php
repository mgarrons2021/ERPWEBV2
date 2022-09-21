<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\DetalleInventarioSistema;
use App\Models\DetallePedido;
use App\Models\Eliminacion;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Producto_Proveedor;
use App\Models\Sucursal;
use App\Models\ProductosInsumos;
use App\Models\User;
use App\Models\CategoriaPlato;
use App\Models\InsumosDias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Dompdf;

class PedidoController extends Controller
{

    public function index()
    {
        $fecha = Carbon::now()->toDateString();
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {
            $pedidos = Pedido::where('sucursal_principal_id', Auth::user()->sucursals[0]->id)->get();
        } else {
            $pedidos = Pedido::where('fecha_actual', $fecha)->get();
        }
        $sucursales = Sucursal::all();
        return view('pedidos.index', compact('pedidos', 'sucursales'));
    }

    public function filtrarPedidos(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        $pedidos = Pedido::whereBetween('fecha_actual', [$fecha_inicial, $fecha_final])->get();

        $filtro = Pedido::whereBetween('fecha_actual', [$fecha_inicial, $fecha_final])->get();

        return view('pedidos.index', compact('pedidos', 'filtro'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categorias = Categoria::all();
        $fecha_actual = Carbon::now()->locale('es')->isoFormat('dddd, D MMMM Y');

        $users = User::all();
        $last_pedido = Pedido::where('sucursal_principal_id', Auth::user()->sucursals[0]->id)->orderBy('id', 'desc')->count();
        if ($last_pedido == null) {
            $last_pedido = 1;
        } else {
            $last_pedido = $last_pedido + 1;
        }
        $productos = Producto::all();

        return view('pedidos.create', compact('users', 'productos', 'fecha_actual', 'categorias', 'last_pedido'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //guardar_pedido
        $user_log = Auth::id();
        $user = User::find($user_log);
        $pedido = new Pedido();
        $pedido->fecha_actual = Carbon::now()->toDateString();
        $pedido->fecha_pedido = $request->fecha_pedido;
        $pedido->estado = 'P'; //CREADO EN PENDIENTE
        $pedido->user_id = Auth::id();
        $pedido->sucursal_principal_id = $user->sucursals[0]->id;
        $pedido->sucursal_secundaria_id = 2;
        $pedido->save();
        $total = 0;
        foreach (session('pedidos_sucursales') as $id => $item) {
            $detalle_pedido = new DetallePedido();
            $total += $item['subtotal_solicitado'];
            $detalle_pedido->cantidad_solicitada = $item['cantidad_solicitada'];
            $detalle_pedido->precio = $item['precio'];
            $detalle_pedido->subtotal_solicitado = $item['subtotal_solicitado'];
            $detalle_pedido->producto_id = $item['producto_id'];
            $detalle_pedido->pedido_id = $pedido->id;
            $detalle_pedido->save();
        }
        $pedido->update([
            'total_solicitado' =>  $total,
        ]);
        session()->forget('pedidos_sucursales');
        session()->get('pedidos_asignados');
        session()->put('pedidos_asignados', 'ok');
        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function show($id)
    {
        $pedido = Pedido::find($id);
        return view('pedidos.show', compact('pedido'));
    }


    public function edit($id)
    {
        $pedido = Pedido::find($id);
        $categorias = Categoria::all();
        return view('pedidos.edit', compact('pedido', 'categorias'));
    }

    public function editPedidoEnviado($id)
    {
        $pedido = Pedido::find($id);
        $categorias = Categoria::all();
        return view('pedidos.editPedidoEnviado', compact('pedido', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Pedido::destroy($id);
        return response()->json(['success' => true], 200);
    }


    public function obtenerPrecios(Request $request)
    {
        if (isset($request->producto_id)) {
            $producto = Producto::find($request->producto_id);
            $categoria_nombre=$producto->categoria->nombre;
            $categoria_id = $producto->categoria->id;
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
                        'categoria'=>$categoria_nombre,
                        'categoria_id' => $categoria_id,
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

    public function agregarInsumo(Request $request)
    {
        // dd($request); 
        $user_log = Auth::id();
        $user = User::find($user_log);
        $producto = Producto::find($request->detallePedido["producto"]);
        if ($producto->id == 3 || $producto->id == 195 || $producto->id == 240 || $producto->id == 201 || $producto->id == 165 || $producto->id == 21 || $producto->id == 200) {
            $unidad_medida = "Und";
        } else {
            $unidad_medida =   $producto->unidad_medida_compra->nombre;
        }

        $pedido_sucursal_array = [
            /* Recibo por Inputs */
            "cantidad_solicitada" => $request->detallePedido['cantidad_solicitada'],
            "precio" => $request->detallePedido['precio'],
            "subtotal_solicitado" =>$request->detallePedido['cantidad_solicitada']*$request->detallePedido['precio'],
            "producto_id" => $producto->id,
            "producto_nombre" => $producto->nombre,
            "unidad_medida" => $unidad_medida,

        ];

        session()->get('pedidos_sucursales');
        session()->push('pedidos_sucursales', $pedido_sucursal_array);
        return response()->json([
            'pedidos_sucursales' => session()->get('pedidos_sucursales'),
            'success' => true,
        ]);
    }

    public function eliminarInsumo(Request $request)
    {
        $pedidos_sucursales_asignados = session('pedidos_sucursales');
        unset($pedidos_sucursales_asignados[$request->data]);
        session()->put('pedidos_sucursales', $pedidos_sucursales_asignados);

        return response()->json([
            'pedidos_sucursales' => session()->get('pedidos_sucursales'),
            'success' => true,
        ]);
    }

    public function actualizarPedido(Request $request)
    {
        $pedido = Pedido::find($request->pedido_id);
        $total_eliminado = 0;
        $nuevospedidos = $request->agregarNuevos;

        if (sizeof($nuevospedidos) != 0) {
            foreach ($nuevospedidos as $index => $detalle) {
                $detalle_pedido = new DetallePedido();
                $detalle_pedido->cantidad_solicitada = $detalle['cantidad_solicitada'];
                $detalle_pedido->cantidad_enviada = $detalle['cantidad_enviada'];
                $detalle_pedido->precio = $detalle['precio'];
                $detalle_pedido->subtotal_solicitado = $detalle['subtotal_solicitado'];
                $detalle_pedido->subtotal_enviado = $detalle['subtotal_enviado'];
                $detalle_pedido->pedido_id = $pedido->id;
                $detalle_pedido->producto_id = $detalle['producto_id'];
                $detalle_pedido->save();
            }
        }
        
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_pedido = DetallePedido::find($detalleEditar);
                $detalle_pedido->cantidad_solicitada = $request->stocks[$index];
                $detalle_pedido->subtotal_solicitado = $request->subtotales[$index];
                $detalle_pedido->save();
            }
        }
        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $detalle_pedido = DetallePedido::find($detalleEliminar);
                if ($detalle_pedido != null) {
                    $total_eliminado += $detalle_pedido->subtotal;
                    $detalle_pedido->delete();
                }
            }
        }
        $pedido->total_solicitado = $request->total_pedido - $total_eliminado;
        $pedido->save();
        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function actualizarPedidoEnviado(Request $request)
    {
        $pedido = Pedido::find($request->pedido_id);
        $nuevospedidos = $request->agregarNuevos;

        if (sizeof($nuevospedidos) != 0) {
            foreach ($nuevospedidos as $index => $detalle) {
                $detalle_pedido = new DetallePedido();
                $detalle_pedido->cantidad_solicitada = $detalle['cantidad_solicitada'];
                $detalle_pedido->cantidad_enviada = $detalle['cantidad_enviada'];
                $detalle_pedido->precio = $detalle['precio'];
                $detalle_pedido->subtotal_solicitado = $detalle['subtotal_solicitado'];
                $detalle_pedido->subtotal_enviado = $detalle['subtotal_enviado'];
                $detalle_pedido->pedido_id = $pedido->id;
                $detalle_pedido->producto_id = $detalle['producto_id'];
                $detalle_pedido->save();
            }
        }
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_pedido = DetallePedido::find($detalleEditar);
                $detalle_pedido->cantidad_enviada = $request->stocks[$index];
                $detalle_pedido->subtotal_enviado = $request->subtotales[$index];
                $detalle_pedido->save();
            }
        }

        /*$detalle_pedido = DetallePedido::find($request->pedido->id);
        $detalle_pedido->cantidad_enviada = $request->cantidad_enviada;
        $detalle_pedido->subtotal_solicitado = $request->subtotal_enviado;
        $detalle_pedido->save();
        */
        /*1 P->pendiente  , 2 E ->enviado  3  A-> ACEPTADO*/

        $pedido->total_enviado = $request->total_pedido;
        $pedido->estado = 'E'; //Estado enviado
        $pedido->save();

        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function VaucherPdf($id)
    {
        $pedido = Pedido::find($id);
        $pedido->estado_impresion = 'Y';
        $pedido->save();
        $detallePedido = DetallePedido::where('pedido_id', '=', $id);

        view()->share('pedidos.pedidosVaucher', $pedido);
        view()->share('pedidos.pedidosVaucher', $detallePedido);

        $pdf = PDF::loadView('pedidos.pedidosVaucher', ['pedido' => $pedido, 'detallePedido' => $detallePedido])->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);
        $pdf->setPaper('Arial', 'B', 8);
        /* $pdf->setPaper( [0, 0, 141.732,  283,465]); */
        return $pdf->stream('Vaucher' . $pedido->id . '.pdf', ['Attachment' => false]);
    }

    public function reporteZumos()
    {
        $pedidos = Pedido::selectRaw('sucursals.id as sucursal_id, sucursals.nombre as sucursal_nombre, max(pedidos.created_at) as hora_solicitud')
            ->join('sucursals', 'pedidos.sucursal_principal_id', '=', 'sucursals.id')
            ->groupBy(['sucursals.id', 'sucursals.nombre'])
            ->where('fecha_actual', Carbon::now()->format('Y-m-d'))
            ->where('sucursals.id', '<>', 19)
            ->where('sucursals.id', '<>', 20)
            ->orderBy('sucursals.id', 'asc')
            ->get();
        $primer_pedido  = Pedido::where('fecha_actual', Carbon::now()->format('Y-m-d'))->orderBy('sucursal_principal_id', 'asc')->first();
        $detalles_pedido = DetallePedido::selectRaw(
            'sucursals.id as sucursal_id,sucursals.nombre as NombreSucursal,productos.nombre as NombreProducto,productos.categoria_id as CategoriaProducto ,productos.id as producto_id,
            sum(detalle_pedidos.cantidad_solicitada) as cantidad_solicitada, 
            sum(detalle_pedidos.cantidad_enviada) as cantidad_enviada,
            sum(detalle_pedidos.subtotal_solicitado) as subtotal_solicitado,
            sum(detalle_pedidos.subtotal_enviado)as subtotal_enviado'
        )->join('productos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->join('pedidos', 'detalle_pedidos.pedido_id', '=', 'pedidos.id')
            ->join('sucursals', 'pedidos.sucursal_principal_id', '=', 'sucursals.id')
            ->groupBy(['sucursals.id', 'sucursals.nombre', 'productos.nombre', 'productos.id', 'productos.categoria_id'])
            ->where('sucursals.id', '<>', 19)
            ->where('sucursals.id', '<>', 20)
            ->whereBetween('detalle_pedidos.created_at', [Carbon::now()->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
            ->get();
        if ($primer_pedido == null) {
            $primer_pedido = new Pedido();
        }
        $id_primer_pedido = $primer_pedido->sucursal_principal_id;
        $sucursales = Sucursal::all();
        $fecha_pedido = DB::table('pedidos')
            ->select('fecha_actual')
            ->latest()
            ->take(1)
            ->get();
        return view('pedidos.reporteZumos', compact('pedidos', 'sucursales', 'fecha_pedido', 'id_primer_pedido', 'detalles_pedido'));
    }
    public function filtrarZumos(Request $request)
    {
        $fecha = new Carbon($request->get('fecha_inicial'));
        // dd($fecha->endOfDay());

        $fecha_inicial = $request->get('fecha_inicial');

        $pedidos = Pedido::selectRaw('sucursals.id as sucursal_id, sucursals.nombre, max(pedidos.created_at) as hora_solicitud')
            ->join('sucursals', 'pedidos.sucursal_principal_id', '=', 'sucursals.id')
            ->groupBy(['sucursals.id', 'sucursals.nombre'])
            ->whereDate('fecha_actual', '=', $fecha)
            ->where('sucursals.id', '<>', 19)
            ->where('sucursals.id', '<>', 20)
            ->where('sucursals.id', '<>', 2)
            ->orderBy('sucursals.id', 'asc')->get();
        //  dd($pedidos);
        $sucursales = Sucursal::all();
        $fecha_pedido = DB::table('pedidos')
            ->select('fecha_actual')
            ->latest()
            ->take(1)
            ->get();

        $detalles_pedido = DetallePedido::selectRaw(
            'sucursals.id as sucursal_id,sucursals.nombre as NombreSucursal,productos.nombre as NombreProducto,productos.id as producto_id,
            productos.categoria_id as CategoriaProducto ,
            sum(detalle_pedidos.cantidad_solicitada) as cantidad_solicitada, 
            sum(detalle_pedidos.cantidad_enviada) as cantidad_enviada,
            sum(detalle_pedidos.subtotal_solicitado) as subtotal_solicitado,
            sum(detalle_pedidos.subtotal_enviado)as subtotal_enviado'
        )->join('productos', 'detalle_pedidos.producto_id', '=', 'productos.id')
            ->join('pedidos', 'detalle_pedidos.pedido_id', '=', 'pedidos.id')
            ->join('sucursals', 'pedidos.sucursal_principal_id', '=', 'sucursals.id')
            ->groupBy(['sucursals.id', 'sucursals.nombre', 'productos.nombre', 'productos.id', 'productos.categoria_id'])
            ->where('sucursals.id', '<>', 19)
            ->where('sucursals.id', '<>', 20)
            ->where('sucursals.id', '<>', 2)
            ->whereBetween('detalle_pedidos.created_at', [$fecha->startOfDay()->format('Y-m-d H:i:s'), $fecha->endOfDay()->format('Y-m-d H:i:s')])
            ->get();
        // dd($detalles_pedido[0]);
        $filtrado =  Pedido::whereDate('fecha_actual', '=', $fecha)->get();
        return  view('pedidos.reporteZumos', compact('filtrado', 'fecha_pedido', 'pedidos', 'sucursales', 'detalles_pedido'));
    }

    public function obtenerPrecioPlato(Request $request)
    {
    }

    public function cambiarEstado(Request $request)
    {
        $pedido = Pedido::find($request->idpedido);
        $fechapedido = $pedido->fecha_pedido;
        /* $inventario_principal = Inventario::where('sucursal_id', 2)->where('fecha', Carbon::now()->format('Y-m-d') )->first();

        $inventario_sistema_principal ='';
        if(is_null($inventario_principal)==false){
            $inventario_sistema_principal = InventarioSistema::where('inventario_id', $inventario_principal->id)->first();
        }
        
        $inventario_secundario = Inventario::where('sucursal_id', Auth::user()->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema_secundario = '';

        if(is_null($inventario_secundario)==false){
            $inventario_sistema_secundario = InventarioSistema::where('inventario_id', $inventario_secundario->id)->first();
        }

        $total_inventario = 0;
        $total_inventario_principal_actualizado =  ( is_null($inventario_principal)==false ? $inventario_sistema_principal->total : 0  );
        $total_inventario_secundario_actualizado =  ( is_null($inventario_secundario)==false ?  $inventario_sistema_secundario->total : 0 );
        foreach ($pedido->detalle_pedidos as $detalle) {

            if( is_null($inventario_principal) == false ){
                $detalle_inventario_sistema_principal = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_principal->id)->where('producto_id', $detalle->producto_id)->first();
                if( is_null($detalle_inventario_sistema_principal) ==false ){
                    $total_inventario_principal_actualizado -= $detalle_inventario_sistema_principal->subtotal;
                    $detalle_inventario_sistema_principal->stock = $detalle_inventario_sistema_principal->stock - $detalle->cantidad_enviada;
                    $detalle_inventario_sistema_principal->subtotal = $detalle_inventario_sistema_principal->stock * $detalle_inventario_sistema_principal->precio;
                    $detalle_inventario_sistema_principal->save()  ;
                    $total_inventario_principal_actualizado += $detalle_inventario_sistema_principal->subtotal  ;
                }
                   
            }
            
            $detalle_inventario_sistema_secundario =  ( is_null($inventario_secundario)==false ? DetalleInventarioSistema::where('inventario_sistema_id', $inventario_secundario->id)->where('producto_id', $detalle->producto_id)->first() : null ) ;
            if ($detalle_inventario_sistema_secundario != null) {
                $total_inventario_secundario_actualizado -= $detalle_inventario_sistema_secundario->subtotal;
                $detalle_inventario_sistema_secundario->stock = $detalle_inventario_sistema_secundario->stock + $detalle->cantidad_enviada;
                $detalle_inventario_sistema_secundario->subtotal = $detalle_inventario_sistema_secundario->stock * $detalle_inventario_sistema_secundario->precio;
                $detalle_inventario_sistema_secundario->save();    
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema_secundario->subtotal;
            } else {          
                if( is_null($inventario_secundario)==false ){
                    $detalle_inventario_sistema_secundario = new DetalleInventarioSistema();
                    $detalle_inventario_sistema_secundario->stock = $detalle->cantidad_enviada;
                    $detalle_inventario_sistema_secundario->precio = $detalle->precio;
                    $detalle_inventario_sistema_secundario->subtotal = $detalle->subtotal_enviado;
                    $detalle_inventario_sistema_secundario->producto_id = $detalle->producto_id;
                    $detalle_inventario_sistema_secundario->inventario_sistema_id = $inventario_secundario->id;
                    $detalle_inventario_sistema_secundario->save();
                    $total_inventario_secundario_actualizado += $detalle_inventario_sistema_secundario->subtotal;
                }                                                  
            }

        }
    
        if( is_null($inventario_principal)==false ) {
            $inventario_sistema_principal->update(['total' => $total_inventario_principal_actualizado]);
        }
        if( is_null($inventario_secundario) ==false ) {
            $inventario_sistema_secundario->update(['total' => $total_inventario_secundario_actualizado]);
        }
 */
        $pedido->estado = 'A';

        if ($pedido->save()) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }

    public function verDetalleReporte($sucursal_id, $fecha_inicial, $fecha_final)
    {
        $fecha = Carbon::now()->toDateString();

        $pedidos_detalle = DB::select("SELECT sucursals.nombre as sucursal_nombre,
            productos.nombre as NombreProducto, unidades_medidas_ventas.nombre as um,
            sum(detalle_pedidos.cantidad_enviada) as cantidadenviado,
            detalle_pedidos.precio as precio,
            SUM(detalle_pedidos.subtotal_enviado) as TotalEnviada 
            from pedidos 
            JOIN detalle_pedidos on detalle_pedidos.pedido_id = pedidos.id 
            JOIN productos on productos.id = detalle_pedidos.producto_id 
            JOIN sucursals on sucursals.id = pedidos.sucursal_principal_id 
            join unidades_medidas_ventas on unidades_medidas_ventas.id = productos.unidad_medida_venta_id
            WHERE pedidos.fecha_pedido BETWEEN '$fecha_inicial' and '$fecha_final' and sucursals.id='$sucursal_id'
            GROUP BY productos.nombre,sucursals.nombre, detalle_pedidos.precio,unidades_medidas_ventas.nombre");

        return view('pedidos_producciones.detalleReporteP', compact('pedidos_detalle', 'fecha_inicial', 'fecha_final'));
    }

    public function total_insumos_solicitados(Request $request){
        $categoria_insumos = Categoria::all();

        $fecha_inicial =$request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $categoria_id = $request->categoria_id;

        $insumos_solicitados = Producto::selectRaw('productos.nombre, detalle_pedidos.cantidad_solicitada, detalle_pedidos.cantidad_enviada')
        ->join('pedidos','pedidos.producto_id','=','productos.id')
        ->join('detalle_pedidos','detalle_pedidos.pedido_id','=','productos.id')
        ->join('categorias','categorias.producto_id','=','productos.id')
        ->where('productos.estado',1)
        ->where('productos.categoria_id',$categoria_id)
        ->whereBetween('pedidos.fecha_pedido',[$fecha_inicial,$fecha_final])
        ->get();

        return view('pedidos.total_insumos_solicitados', compact('categoria_insumos','insumos_solicitados'));
        
    }

    public function pedido_especial()
    {
        $categorias = Categoria::all();
        $productos = Producto::all();
        $fecha_actual = Carbon::now()->addDay(1)->locale('es')->isoFormat('dddd');
        
        //dd($fecha_actual);

        $dia = InsumosDias::where('dia',$fecha_actual)->first();
        
        //dd($dia->id);
        
        $productos_predefinidos= ProductosInsumos::selectRaw('productos.nombre,productos_insumos.*,productos.categoria_id')        
        ->join('productos','productos.id','=','productos_insumos.producto_id')
        ->where('productos_insumos.insumos_dias_id',1)
        ->orWhere('productos_insumos.insumos_dias_id',$dia->id)
        ->orderBy('productos.categoria_id','ASC')
        ->get();    
        
        //$prod=$productos_predefinidos->distinct()->get();
        
        //dd($productos_predefinidos);

        //dd($productos_predefinidos  ); 

        /*where( 'insumos_dias_id',1 )
            ->where('insumos_dias_id',$dia->id )->get() */
        
        //dd($productos_predefinidos);

        //echo sizeof(  $productos_predefinidos[0]->producto->productos_proveedores)>0?'si':'no';
        //echo $productos_predefinidos[0]->producto->unidad_medida_compra->nombre;
        //dd($productos_predefinidos[0]->producto->productos_proveedores[0]); 
        return view( 'pedidos.pedido_especial' , compact('categorias','productos','productos_predefinidos'));


    }

    public function pedido_especial_store( Request $request )
    {
        //guardar pedido
        $user_log = Auth::id();
        $user = User::find($user_log);
        $pedido  = new Pedido();
        $pedido2 = new Pedido();
        $pedido3 = new Pedido();
        //1 CARNES
        $pedido->fecha_actual = Carbon::now()->toDateString();    
        $pedido->fecha_pedido = $request->fecha_pedido;
        $pedido->estado = 'P'; //CREADO EN PENDIENTE
        $pedido->user_id = Auth::id();
        $pedido->sucursal_principal_id = $user->sucursals[0]->id;
        $pedido->sucursal_secundaria_id = 2;
        $pedido->save();
        $total = 0;
        //2  INSUMOS
        $pedido2->fecha_actual = Carbon::now()->toDateString();    
        $pedido2->fecha_pedido = $request->fecha_pedido;
        $pedido2->estado = 'P'; //CREADO EN PENDIENTE
        $pedido2->user_id = Auth::id();
        $pedido2->sucursal_principal_id = $user->sucursals[0]->id;
        $pedido2->sucursal_secundaria_id = 2;
        $pedido2->save();
        $total2 = 0; 
        //3 VERDURAS
        $pedido3->fecha_actual = Carbon::now()->toDateString();    
        $pedido3->fecha_pedido = $request->fecha_pedido;
        $pedido3->estado = 'P'; //CREADO EN PENDIENTE
        $pedido3->user_id = Auth::id();
        $pedido3->sucursal_principal_id = $user->sucursals[0]->id;
        $pedido3->sucursal_secundaria_id = 2;
        $pedido3->save();
        $total3 = 0; 

        $subtotales=$request->subtotales;
        $stock=$request->stocks;
        $productos=$request->idproductos;
        $precios = $request->precios;
        $categorias=$request->categorias;
        //dd($subtotales);
        foreach ($productos as $index =>  $item) {                    
            if($stock[$index]>0)
            {
//falta controlar los subtotales
                $detalle_pedido = new DetallePedido();    
                $detalle_pedido->cantidad_solicitada = $stock[$index];
                $detalle_pedido->precio = $precios[$index];
                $detalle_pedido->subtotal_solicitado = $detalle_pedido->cantidad_solicitada * $detalle_pedido->precio;
                $detalle_pedido->producto_id = $item;

                if( $categorias[$index] == 4 || $categorias[$index] == 5   ){
                    $detalle_pedido->pedido_id = $pedido->id;
                    $total += floatval($detalle_pedido->subtotal_solicitado);
                }else if(  $categorias[$index] == 14 || $categorias[$index] == 9 || $categorias[$index] == 10 || $categorias[$index] == 11 || $categorias[$index] == 13    ){//no comestible mas
                    $detalle_pedido->pedido_id = $pedido2->id;
                    $total2 += floatval($detalle_pedido->subtotal_solicitado);
                }else if(   $categorias[$index] == 8 || $categorias[$index] == 7 || $categorias[$index] == 12  ){
                    $detalle_pedido->pedido_id = $pedido3->id;
                    $total3 += floatval($detalle_pedido->subtotal_solicitado);
                }

                $detalle_pedido->save();

            }
        }

        $pedido->update([
            'total_solicitado' =>  $total,
        ]); 
        $pedido2->update([
            'total_solicitado' =>  $total2,
        ]); 
        $pedido3->update([
            'total_solicitado' =>  $total3,
        ]); 

        return response()->json(
            [
                'success' => true
            ]
        );
    }

}
