<?php

namespace App\Http\Controllers;


use App\Models\DetalleParteProduccion;
use App\Models\ParteProduccion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Inventario;
use App\Models\Producto_Proveedor;
use App\Models\UnidadMedidaVenta;

class ParteProduccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $fecha_actual= Carbon::now()->toDateString();
       $user_role = Auth::user()->roles[0]->id;
       if ($user_role == 3){
        $partes_producciones = ParteProduccion::where('sucursal_usuario_id', Auth::user()->sucursals[0]->id)->get();
       } else {
        $partes_producciones = ParteProduccion::where('fecha',$fecha_actual)->get();
       }
        
        return view('partes_producciones.index', compact('partes_producciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

       
        $user = auth()->user();
        $user_sucursal = $user->sucursals[0]->id;
        
        
        $fecha_actual = Carbon::now()->toDateString();
        $partes_producciones = ParteProduccion::all();
        
        /* Saca el ultimo Inv registrado de la fecha actual */
        $ultimo_inventario = DB::table('inventarios')
        ->select('id')
        ->where('sucursal_id',$user_sucursal)
        ->where('fecha',$fecha_actual)
        ->latest()
        ->take(1)
        ->get(); 

  
        
        /* $productos = DB::select('select productos.id, productos.nombre
        from detalles_inventario 
        inner join inventarios on inventarios.id = detalles_inventario.inventario_id
        JOIN users on users.id = inventarios.user_id 
        JOIN sucursal_user on sucursal_user.user_id = users.id
        JOIN sucursals on sucursals.id = sucursal_user.sucursal_id
        LEFT JOIN productos on productos.id = detalles_inventario.producto_id
        WHERE inventarios.id='.$ultimo_inventario[0]->id); */
        $productos  = Producto::all();

        


        return view('partes_producciones.create', compact('partes_producciones','productos','fecha_actual','user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_log = Auth::id();
        $user = User::find($user_log);
        $parte_produccion = new ParteProduccion();
        $parte_produccion->fecha = Carbon::now()->toDateString();
        $parte_produccion->user_id = Auth::id();
        $parte_produccion->sucursal_usuario_id = $user->sucursals[0]->id;
        $parte_produccion->save();

        $total = 0;
        foreach (session('partes_producciones') as $id => $item) {
            $detalle_parte_produccion = new DetalleParteProduccion();
            $total += $item['subtotal'];
            $detalle_parte_produccion->cantidad = $item['cantidad_solicitada'];
            $detalle_parte_produccion->precio = $item['precio'];
            $detalle_parte_produccion->subtotal = $item['subtotal'];
            $detalle_parte_produccion->producto_id = $item['producto_id'];
            $detalle_parte_produccion->parte_produccion_id = $parte_produccion->id;
            $detalle_parte_produccion->save();
        }
        $parte_produccion->update([
            'total' =>  $total,
        ]);
        session()->forget('partes_producciones');
        session()->get('partes_producciones_asignados');
        session()->put('partes_producciones_asignados', 'ok');
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
        $parte_produccion = ParteProduccion::find($id);
        return view('partes_producciones.show',compact('parte_produccion'));
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
        ParteProduccion::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function obtenerPrecios(Request $request)
    {
        if (isset($request->producto_id)) {
            $producto = Producto::find($request->producto_id);
            $producto_proveedor = Producto_Proveedor::where('producto_id', $request->producto_id)->first();
            
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
                        'unidad_medida' => $producto->unidad_medida_compra_id,
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


    public function agregarInsumo(Request $request)
    {

        // dd($request); 
        $user_log = Auth::id();
        $user = User::find($user_log);
        $producto = Producto::find($request->detalleParteProduccion["producto"]);
       /*  dd($producto); */
        $producto_id = $producto->id;
        $ultimo_indice = sizeof($producto->productos_proveedores);
        if (isset($producto->productos_proveedores[$ultimo_indice - 1]->precio)) {
            $costo = $producto->productos_proveedores[$ultimo_indice - 1]->precio;
            $subtotal = $producto->productos_proveedores[$ultimo_indice - 1]->precio * $request->detalleParteProduccion['cantidad_solicitada'];
        } else {
            $costo = 0;
            $subtotal = 0;
        }

         /*FILETES*/
         $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
         $nueva_subtotal =  $subtotal;
         $nuevo_precio =  $costo;
         $nueva_UM_nombre = $producto->unidad_medida_venta->nombre;
         $nueva_UM_id = $producto->unidad_medida_venta->id;
         if ($producto_id == 3) {
             $filete_en_unidades = $request->detalleParteProduccion['cantidad_solicitada'] / 0.18;
             $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
             $nuevo_precio = $precio_por_unidad_filete;
             $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
             $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
             $nueva_UM_nombre = "Und";
             $nueva_UM_id = 8;
             $json=[$filete_en_unidades,$precio_por_unidad_filete,$nuevo_precio,$nueva_cantidad,$nueva_subtotal];
            /*  dd($json); */
         }
 
         /*CHULETA DE CERDO DE 200 GR*/
         if ($producto_id == 21) {
             $filete_en_unidades = $request->detalleParteProduccion['cantidad_solicitada'] / 0.200;
             $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
             $nuevo_precio = $precio_por_unidad_filete;
             $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
             $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
             $nueva_UM_nombre = "Und";
             $nueva_UM_id = 8;
         }
         /*CHORIZOS*/
 
         if ($producto_id == 195 || $producto_id == 240) {
             $filete_en_unidades = $request->detalleParteProduccion['cantidad_solicitada'] * 10;
             $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
             $nuevo_precio = $precio_por_unidad_filete;
             $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
             $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
             $nueva_UM_nombre = "Und";
             $nueva_UM_id = 8;
         }

         /*POLLO BRASA*/

        if ($producto_id == 200) {
            $filete_en_unidades = $request->detalleParteProduccion['cantidad_solicitada'] * 8;
            $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
            $nuevo_precio = 26.49;
            $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
            $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
            $nueva_UM_nombre = "Und";
            $nueva_UM_id = 8;
        }

         /*ALITAS DE POLLO*/
 
         if ($producto_id == 201) {
             $filete_en_unidades = $request->detalleParteProduccion['cantidad_solicitada'] * 8;
             $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
             $nuevo_precio = $precio_por_unidad_filete + 1.8;
             $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
             $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
             $nueva_UM_nombre = "Und";
             $nueva_UM_id = 8;
         }
    
          /*PLATANOS*/
          if ($producto_id == 45) {
             $filete_en_unidades = $request->detalleParteProduccion['cantidad_solicitada'] * 64;
             $precio_por_unidad_filete = $subtotal / $filete_en_unidades;
             $nuevo_precio = $precio_por_unidad_filete;
             $nueva_cantidad = $request->detalleParteProduccion['cantidad_solicitada'];
             $nueva_subtotal = $nuevo_precio * $nueva_cantidad;
             $nueva_UM_nombre = "Und";
             $nueva_UM_id = 8;
         }
 
      

        $parte_produccion_array = [
            
            "cantidad_solicitada" => $request->detalleParteProduccion['cantidad_solicitada'],
            "precio" => $nuevo_precio,
            "subtotal" => $nueva_subtotal,
            "producto_id" => $producto->id,
            "producto_nombre" => $producto->nombre,
            "unidad_medida" => $nueva_UM_nombre,

        ];
        /* dd($parte_produccion_array); */

        session()->get('partes_producciones');
        session()->push('partes_producciones', $parte_produccion_array);
        return response()->json([
            'partes_producciones' => session()->get('partes_producciones'),
            'success' => true,
        ]);
    }

    public function eliminarInsumo(Request $request)
    {
        $partes_producciones_asignados= session('partes_producciones');
        unset($partes_producciones_asignados[$request->data]);

        session()->put('partes_producciones', $partes_producciones_asignados);

        return response()->json([
            'partes_producciones' => session()->get('partes_producciones'),
            'success' => true,
        ]);
    }

    public function filtrarpartes_producciones(Request $request)
    {
        $fecha_inicial = $request->fecha_inicial;
        $fecha_fin = $request->fecha_final;
        $user_rol = Auth::user()->roles[0]->id;
        if ($user_rol == 3) {

            $partes_producciones = ParteProduccion::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_fin)->get();
        } else {
            $partes_producciones = ParteProduccion::where('fecha', '>=', $fecha_inicial)->where('fecha', '<=', $fecha_fin)->get();
        }

        return view('partes_producciones.index', compact('partes_producciones'));
    }

}
