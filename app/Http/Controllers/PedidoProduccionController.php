<?php

namespace App\Http\Controllers;

use App\Models\DetallePedidoProduccion;
use App\Models\MenuSemanal;
use App\Models\Pedido;
use App\Models\PedidoProduccion;
use App\Models\Plato;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Categoria;
use App\Models\CategoriaPlato;
use App\Models\DetalleInventarioSistema;
use App\Models\Inventario;
use App\Models\InventarioSistema;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoProduccionController extends Controller
{

    public function index()
    {
        $fecha = Carbon::now()->toDateString();
        $sucursales = Sucursal::all();
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {
            $pedidos_producciones = PedidoProduccion::where('sucursal_usuario_id', Auth::user()->sucursals[0]->id)->get();
        } else {
            $pedidos_producciones = PedidoProduccion::where('fecha_pedido',$fecha)->get();
        }
        return view('pedidos_producciones.index', compact('pedidos_producciones', 'sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $fecha_actual = Carbon::now()->locale('es')->addDay(1)->isoFormat('dddd');

        $pedidos_producciones = PedidoProduccion::all();
        $menu_semanal = MenuSemanal::where('dia', $fecha_actual)->first();

        return view('pedidos_producciones.create', compact('pedidos_producciones', 'menu_semanal', 'fecha_actual'));
    }

    public function store(Request $request)
    {

        $user_log = Auth::id();
        $user = User::find($user_log);

        $pedido = new PedidoProduccion();
        $pedido->fecha = Carbon::now()->toDateString();

        $pedido->fecha_pedido = $request->fecha_pedido;

        $pedido->estado = 'S';
        $pedido->user_id = Auth::id();
        $pedido->sucursal_usuario_id = $user->sucursals[0]->id;
        $pedido->sucursal_pedido_id = 2;

        $pedido->save();
        $total = 0;

        foreach (session('pedidos_producciones') as $id => $item) {
            $detalle_pedido = new DetallePedidoProduccion();

            $total += $item['subtotal_solicitado'];
            $detalle_pedido->cantidad_solicitada = $item['cantidad_solicitada'];
            $detalle_pedido->precio = $item['costo'];
            $detalle_pedido->subtotal_solicitado = $item['subtotal_solicitado'];
            $detalle_pedido->plato_id = $item['plato_id'];
            $detalle_pedido->pedido_produccion_id = $pedido->id;
            $detalle_pedido->save();
        }
        $pedido->update([
            'total_solicitado' =>  $total,
        ]);


        session()->forget('pedidos_producciones');
        session()->get('pedidos_producciones_asignados');
        session()->put('pedidos_producciones_asignados', 'ok');
        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function show($id)
    {
        $pedido = PedidoProduccion::find($id);

        return view('pedidos_producciones.show', compact('pedido'));
    }

    public function edit($id)
    {

        $fecha_actual = Carbon::now()->locale('es')->addDay(1)->isoFormat('dddd');
        
        $menu_semanal = MenuSemanal::where('dia', $fecha_actual)->first();
        
        $pedido = PedidoProduccion::find($id);
        $categorias = Categoria::all();
        
        //dd($pedido->detalle_pedido_produccion[0]->plato);
        
        return view('pedidos_producciones.editar',compact('pedido','categorias' ,'menu_semanal', 'fecha_actual'));

    }
    
    public function update(Request $request, $id)
    {
    }
  
    public function destroy($id)
    {
        PedidoProduccion::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function agregarPlato(Request $request)
    {
        $plato = Plato::find($request->detallePedidoProduccion["plato"]);
        $pedido_produccion_array = [
            "cantidad_solicitada" => $request->detallePedidoProduccion['cantidad_solicitada'],
            "subtotal_solicitado" => $request->detallePedidoProduccion['cantidad_solicitada'] * $plato->costo_plato,
            "plato_id" => $plato->id,
            "plato_nombre" => $plato->nombre,
            "costo" => $plato->costo_plato,
        ];

        session()->get('pedidos_producciones');
        session()->push('pedidos_producciones', $pedido_produccion_array);
        return response()->json([
            'pedidos_producciones' => session()->get('pedidos_producciones'),
            'success' => true,
        ]);
    }

    public function eliminarPlato(Request $request)
    {
        $pedidos_producciones_asignados = session('pedidos_producciones');
        unset($pedidos_producciones_asignados[$request->data]);

        session()->put('pedidos_producciones', $pedidos_producciones_asignados);

        return response()->json([
            'pedidos_producciones' => session()->get('pedidos_producciones'),
            'success' => true,
        ]);
    }

    public function obtenerCosto(Request $request)
    {
        if (isset($request->plato_id)) {
            $costo = Plato::select('costo_plato')->where('id', $request->plato_id)->get();
            return response()->json(
                [
                    'costo_plato' => $costo,
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

    public function obtenerCostoPlato(Request $request)
    {
        if (isset($request->plato_id)) {
            $costo = Plato::where('id', $request->plato_id)->first();
            return response()->json(
                [
                    'plato' => $costo,
                    'um'=>$costo->unidad_medida_compra->nombre,
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

    public function reporteProduccion()
    {
        $fecha = Carbon::now();
        $pedidos_producciones = PedidoProduccion::whereDate('fecha', '=',  Carbon::now())
            ->join('sucursals', 'pedidos_produccion.sucursal_usuario_id', '=', 'sucursals.id')
            ->where('sucursals.id', '<>', 19)
            ->where('sucursals.id', '<>', 2)
            ->get();

        /*  dd($pedidos_producciones); orderBy('sucursal_principal_id', 'asc') */
        $sucursales = Sucursal::all();

        $fecha_pedido = DB::table('pedidos_produccion')
            ->select('fecha')
            ->latest()
            ->take(1)
            ->get();

        $detalles = PedidoProduccion::selectRaw('detalle_pedidos_produccion.*')
            ->join('detalle_pedidos_produccion', 'pedidos_produccion.id', '=', 'detalle_pedidos_produccion.pedido_produccion_id')
            ->whereDate('pedidos_produccion.fecha', '=', Carbon::now())
            ->get();

        return view('pedidos_producciones.reporteProduccion', compact('detalles', 'pedidos_producciones', 'sucursales', 'fecha_pedido'));
    }

    public function filtrarReporte(Request $request)
    {
        $fecha_inicial = $request->get('fecha_inicial');
        //selectRaw('sucursals.*, pedidos_produccion.id,pedidos_produccion.fecha ')
        $pedidos_producciones = PedidoProduccion::selectRaw('sucursals.*, pedidos_produccion.id,pedidos_produccion.fecha,pedidos_produccion.created_at ')->whereDate('fecha', '=',  $fecha_inicial)
            ->join('sucursals', 'pedidos_produccion.sucursal_usuario_id', '=', 'sucursals.id')
            ->where('sucursals.id', '<>', 19)
            ->where('sucursals.id', '<>', 2)
            ->get();
        // dd($pedidos_producciones );

        // dd($pedidos_producciones[1]->detalle_pedido_produccion);
        $detalles = PedidoProduccion::selectRaw('detalle_pedidos_produccion.*')
            ->join('detalle_pedidos_produccion', 'pedidos_produccion.id', '=', 'detalle_pedidos_produccion.pedido_produccion_id')
            ->whereDate('pedidos_produccion.fecha', '=', $fecha_inicial)
            ->get();

        /* foreach ($detalles as $detalle){
            print_r($detalle->pedido_produccion_id.'</br>');
        }        

        dd('hola'); */
        //dd($detalles[0]);

        /* */

        $filtro = PedidoProduccion::where('fecha_pedido', $fecha_inicial)->get();

        $fecha_pedido = DB::table('pedidos_produccion')
            ->select('fecha')
            ->latest()
            ->take(1)
            ->get();

        return view('pedidos_producciones.reporteProduccion', compact('detalles', 'pedidos_producciones', 'fecha_pedido'));
    }

    public function cambiarEstado(Request $request)
    {
        $pedido = PedidoProduccion::find($request->idpedido);
        /* dd($pedido->detalle_pedido_produccion); */
        /* $inventario_secundario = Inventario::where('sucursal_id', Auth::user()->sucursals[0]->id)->where('fecha', Carbon::now()->format('Y-m-d'))->first();
        $inventario_sistema_secundario = InventarioSistema::where('inventario_id', $inventario_secundario->id)->first();
        $total_inventario_secundario_actualizado = $inventario_sistema_secundario->total;
        foreach ($pedido->detalle_pedido_produccion as $detalle) {
            $detalle_inventario_sistema_secundario = DetalleInventarioSistema::where('inventario_sistema_id', $inventario_sistema_secundario->id)->where('plato_id', $detalle->plato_id)->first();
            if ($detalle_inventario_sistema_secundario != null) {
                $total_inventario_secundario_actualizado -= $detalle_inventario_sistema_secundario->subtotal;
                $detalle_inventario_sistema_secundario->stock = $detalle_inventario_sistema_secundario->stock + $detalle->cantidad_enviada;
                $detalle_inventario_sistema_secundario->subtotal = $detalle_inventario_sistema_secundario->stock * $detalle_inventario_sistema_secundario->precio;
                $detalle_inventario_sistema_secundario->save();
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema_secundario->subtotal;
            } else {

                
                $detalle_inventario_sistema_secundario = new DetalleInventarioSistema();
                $detalle_inventario_sistema_secundario->stock = $detalle->cantidad_enviada;
                $detalle_inventario_sistema_secundario->precio = $detalle->precio;
                $detalle_inventario_sistema_secundario->subtotal = $detalle->subtotal_enviado;
                $detalle_inventario_sistema_secundario->plato_id = $detalle->plato_id;
                $detalle_inventario_sistema_secundario->inventario_sistema_id = $inventario_sistema_secundario->id;
                $detalle_inventario_sistema_secundario->save();
                $total_inventario_secundario_actualizado += $detalle_inventario_sistema_secundario->subtotal;
            }
        }

        $inventario_sistema_secundario->update(['total' => $total_inventario_secundario_actualizado]);
        if ($inventario_sistema_secundario->update()) {
            $pedido->estado = 'A';
            $pedido->save();
        }

        if ($pedido->save()) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        } */
        $pedido->estado = 'A';
        $pedido->save();
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

    public function editarInsumos($id)
    {
        $pedido = PedidoProduccion::find($id);
        $categorias = CategoriaPlato::all();
        $platos = Plato::all();
        // dd($pedido);
        return view('pedidos_producciones.enviarInsumos', compact('pedido', 'categorias','platos'));
    }

    public function obtenerDatosPlato(Request $request)
    {
        $id = $request->id;
        $plato = Plato::find($id);
        $um = $plato->unidad_medida_venta->nombre;
        return response()->json([
            'plato' => $plato,
            'um' => $um
        ]);
    }

    public function actualizarPedidoEnviado(Request $request)
    {
        $pedidoR = PedidoProduccion::find($request->pedido_id);
        $pedidonuevos = $request->agregarItems;
        if (sizeof($pedidonuevos) != 0) {
            foreach ($pedidonuevos as $key => $pedido) {
                $producto = new  DetallePedidoProduccion();
                $producto->precio = $pedido['precio'];
                $producto->cantidad_solicitada  = $pedido['cantidad_solicitada'];
                $producto->cantidad_enviada  = $pedido['cantidad_enviada'];
                $producto->subtotal_solicitado  = $pedido['subtotal_solicitado'];
                $producto->subtotal_enviado  = $pedido['subtotal_enviado'];
                $producto->pedido_produccion_id  = $pedido['pedido_produccion_id'];
                $producto->plato_id  = $pedido['plato_id'];
                $producto->save();
            }
        }
        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $detalle_pedido = DetallePedidoProduccion::find($detalleEditar);
                $detalle_pedido->cantidad_enviada = $request->stocks[$index];
                $detalle_pedido->subtotal_enviado = $request->subtotales[$index];
                $detalle_pedido->save();
            }
        }
        // dd($pedido);
        $pedidoR->total_enviado = $request->total_pedido;
        $pedidoR->estado = 'E';
        $pedidoR->save();

        return response()->json(
            [
                'success' => true
            ]
        );
    }

    public function filtrarPedidosProduccion(Request $request)
    {
        $sucursales = Sucursal::all();
        $fecha_inicial = $request->get('fecha_inicial');
        $fecha_final = $request->get('fecha_final');

        $pedidos_producciones = PedidoProduccion::whereBetween('fecha_pedido', [$fecha_inicial,$fecha_final])->get();
        $filtrado = PedidoProduccion::whereBetween('fecha_pedido', [$fecha_inicial,$fecha_final])->get();


        return view('pedidos_producciones.index', compact('pedidos_producciones', 'filtrado', 'sucursales'));
        
    }

    public function reporteProduccionEnviada(Request $request)
    {
        if (isset($request->fecha_inicial) && isset($request->fecha_final)) {

            $fecha_inicial = $request->fecha_inicial;
            $fecha_final = $request->fecha_final;

            $fecha = Carbon::now()->toDateString();

            $pedidos_producciones = DB::select("SELECT  sucursals.nombre as sucursal_nombre, pedidos_produccion.sucursal_usuario_id as sucursal_id,
            SUM(pedidos_produccion.total_solicitado) as TotalProduccionSolicitada, 
            SUM(pedidos_produccion.total_enviado) as TotalProduccionEnviada
            from pedidos_produccion 
            join sucursals on sucursals.id = pedidos_produccion.sucursal_usuario_id
            WHERE pedidos_produccion.fecha_pedido  BETWEEN '$fecha_inicial' and '$fecha_final' 
            GROUP by sucursals.nombre,pedidos_produccion.sucursal_usuario_id");
            

            $pedidos =  DB::select("SELECT sucursals.nombre as sucursal_nombre,
            sucursals.id as sucursal_id,
             SUM(pedidos.total_solicitado) as TotalInsumosSolicitada, 
             SUM(pedidos.total_enviado) as TotalInsumosEnviado
             from pedidos 
             join sucursals on sucursals.id = pedidos.sucursal_principal_id
             WHERE pedidos.fecha_pedido BETWEEN '$fecha_inicial' and '$fecha_final'
             GROUP by sucursals.nombre,sucursals.id");
            return view('pedidos_producciones.reporteProduccionEnviada', compact('fecha', 'pedidos_producciones', 'pedidos', 'fecha_inicial', 'fecha_final'));
        } else {

            $fecha_inicial = Carbon::now()->toDateString();
            $fecha_final = Carbon::now()->toDateString();
            $fecha = Carbon::now()->toDateString();

            $pedidos_producciones = DB::select(" SELECT sucursals.nombre as sucursal_nombre,pedidos_produccion.sucursal_usuario_id as sucursal_id,
            SUM(pedidos_produccion.total_solicitado) as TotalProduccionSolicitada, 
            SUM(pedidos_produccion.total_enviado) as TotalProduccionEnviada
            from pedidos_produccion 
            join sucursals on sucursals.id = pedidos_produccion.sucursal_usuario_id
            WHERE pedidos_produccion.fecha_pedido  BETWEEN '$fecha_inicial' and '$fecha_final' 
            GROUP by sucursals.nombre,pedidos_produccion.sucursal_usuario_id");
            

                    $pedidos =  DB::select("SELECT sucursals.nombre as sucursal_nombre,
                    sucursals.id as sucursal_id,
                     SUM(pedidos.total_solicitado) as TotalInsumosSolicitada, 
                     SUM(pedidos.total_enviado) as TotalInsumosEnviado
                     from pedidos 
                     join sucursals on sucursals.id = pedidos.sucursal_principal_id
                     WHERE pedidos.fecha_pedido BETWEEN '$fecha_inicial' and '$fecha_final'
                     GROUP by sucursals.nombre,sucursals.id");
            return view('pedidos_producciones.reporteProduccionEnviada', compact('fecha', 'pedidos_producciones', 'pedidos', 'fecha_inicial', 'fecha_final'))->with('error');
        }
    }

    public function verDetalleReporteProduccion($sucursal_id, $fecha_inicial, $fecha_final)
    {
        $pedidos_detalle = DB::select("SELECT sucursals.nombre as sucursal_nombre,
            platos.nombre as NombreProducto, unidades_medidas_ventas.nombre as um,
            sum(detalle_pedidos_produccion.cantidad_solicitada) as cantidad_solicitada,
            sum(detalle_pedidos_produccion.cantidad_enviada) as cantidadenviado,
            detalle_pedidos_produccion.precio as precio,
            SUM(detalle_pedidos_produccion.subtotal_enviado) as TotalEnviada 
            from pedidos_produccion
            JOIN detalle_pedidos_produccion on detalle_pedidos_produccion.pedido_produccion_id = pedidos_produccion.id 
            JOIN platos on platos.id = detalle_pedidos_produccion.plato_id 
            JOIN sucursals on sucursals.id = pedidos_produccion.sucursal_usuario_id 
            join unidades_medidas_ventas on unidades_medidas_ventas.id = platos.unidad_medida_venta_id
            WHERE pedidos_produccion.fecha_pedido BETWEEN '$fecha_inicial' and '$fecha_final' and sucursals.id='$sucursal_id'
            GROUP BY platos.nombre,sucursals.nombre, detalle_pedidos_produccion.precio,unidades_medidas_ventas.nombre");
/* 
            dd($pedidos_detalle);
 */
        return view('pedidos_producciones.detalleReporteP', compact('pedidos_detalle', 'fecha_inicial', 'fecha_final'));
    }

    public function reporte_inventario(Request $request)
    {        
        $fecha = Carbon::now()->toDateString();
        
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;

        /* $last_inventarios = Inventario::select('id')
        ->where('fecha','2022-08-05')
        ->latest()
        ->take(20)
        ->get();
        dd($last_inventarios); */

        if(isset($fecha_inicial) && isset($fecha_final)){
            $inventarios = Inventario::selectRaw('productos.nombre as producto_nombre,
             sum( detalles_inventario.stock) as cantidad,
             unidades_medidas_ventas.nombre as um,
              detalles_inventario.precio as precio, 
              sum(detalles_inventario.subtotal) as subtotal')
            ->join('detalles_inventario','detalles_inventario.inventario_id','=','inventarios.id')
            ->join('productos','productos.id','=','detalles_inventario.producto_id')
            
            ->join('unidades_medidas_ventas','unidades_medidas_ventas.id','=','productos.unidad_medida_venta_id')
            ->where('inventarios.tipo_inventario','=','S')
            ->whereBetween('inventarios.fecha',[$fecha_inicial,$fecha_final])   
            
            ->groupBy(['productos.nombre','detalles_inventario.precio','unidades_medidas_ventas.nombre'])
            ->get();

        }else{
            $inventarios = Inventario::selectRaw('productos.nombre as producto_nombre, 
             sum( detalles_inventario.stock) as cantidad, 
             unidades_medidas_ventas.nombre as um,
             detalles_inventario.precio as precio, 
             sum(detalles_inventario.subtotal) as subtotal' )
            ->join('detalles_inventario','detalles_inventario.inventario_id','=','inventarios.id')
            ->join('productos','productos.id','=','detalles_inventario.producto_id')
            ->join('unidades_medidas_ventas','unidades_medidas_ventas.id','=','productos.unidad_medida_venta_id')
            ->where('inventarios.tipo_inventario','=','S')
            ->whereBetween('inventarios.fecha',[$fecha,$fecha])
            
            ->groupBy(['productos.nombre','detalles_inventario.precio','unidades_medidas_ventas.nombre','inventarios.id'])
            ->get();
            /* dd($inventarios); */

        }

        return view('pedidos_producciones.reporte_inventario', compact('inventarios','fecha','fecha_inicial','fecha_final'));

    }

    public function produccion_especial(){

    }

    public function produccion_especial_store(Request $request){

    }


}
