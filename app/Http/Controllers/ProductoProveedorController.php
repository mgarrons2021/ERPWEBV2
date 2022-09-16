<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use Illuminate\Http\Request;
use App\Models\Producto_Proveedor;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\SolicitudCambioPrecio;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductoProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos_proveedores = Producto_Proveedor::all();
        return view('productos_proveedores.index')->with('productos_proveedores', $productos_proveedores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fecha_act= date("Y-m-d");
        $productos= Producto::all();
        $sucursales= Sucursal::all();
        $proveedores= Proveedor::all();
        //dd(session('productos_proveedores'));
        return view('productos_proveedores.create',compact('fecha_act'))->with('productos',$productos)->with('sucursales',$sucursales)->with('proveedores',$proveedores);
    }

    public function asignarProducto(Request $request){

        $producto_nombre = Producto::find($request->productoproveedor["producto_id"]);

        $producto_proveedor = [
            "fecha" =>   Carbon::now(),
            "precio" => $request->productoproveedor['precio'],
            "producto_id" => $request->productoproveedor['producto_id'],
            "proveedor_id" => $request->productoproveedor['proveedor_id'],
            "sucursal_id" => 2,    
        ];
        session()->get('producto_proveedor');
        session()->push('producto_proveedor', $producto_proveedor); /*Guarda la session creada en $producto_proveedor */
        return response()->json([
            'producto_proveedor' => session()->get('producto_proveedor'),
            'success' => true

        ]);


    }

    public function eliminarDetalle(Request $request){

        $detalle_productos_proveedores = session('productos_proveedores');

        unset($detalle_productos_proveedores[$request->data]);
        session()->put('productos_proveedores', $detalle_productos_proveedores);
        return response()->json(
            [
                'productos_proveedores' => session()->get('productos_proveedores'),
                'success' => true
            ]
        );

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach (session('productos_proveedores') as $id => $item) {
            $producto_proveedor= new Producto_Proveedor();
            $producto_proveedor->precio = $item['precio'];
            $producto_proveedor->producto_id = $item["producto_id"];
            $producto_proveedor->fecha = Carbon::now();
            $producto_proveedor->proveedor_id = $request->proveedor_id;
            $producto_proveedor->sucursal_id = 2;
            $producto_proveedor->save();
        }
        session()->forget('productos_proveedores');

        session()->get('precios_asignados');
        session()->put('precios_asignados', 'ok');
        return response()->json(
            [
                'success' => true
            ]
        );
       
        //return redirect()->route('productos_proveedores.index')->with('registrado', 'ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);
        $producto_proveedor = Producto_Proveedor::find($id);
        
        $producto_id =$producto_proveedor->producto->id;
        $historial_productos = DB::select("select  productos.nombre as nombre ,detalles_compra.precio_compra as precio_compra, compras.fecha_compra as fecha_compra 
        from detalles_compra
        JOIN compras on compras.id = detalles_compra.compra_id
        join productos on productos.id= detalles_compra.producto_id
        JOIN producto_proveedor on producto_proveedor.producto_id = productos.id
        JOIN proveedores ON proveedores.id = producto_proveedor.proveedor_id
    	where productos.id= '$producto_id'
        GROUP by productos.nombre, compras.fecha_compra,detalles_compra.precio_compra, compras.fecha_compra 
        ORDER BY compras.fecha_compra ASC;");
        
       /*  dd($historial_productos); */

        return view('productos_proveedores.show' , compact('producto', 'producto_proveedor','historial_productos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto_proveedor = Producto_Proveedor::find($id);
        $producto = $producto_proveedor->producto;

       /*  dd($producto); */
       /*  if($producto->categoria_id!=8){
            return redirect()->route('productos_proveedores.index')->with('editar','false');
        } */
        return view('productos_proveedores.edit', compact('producto_proveedor'));
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
        $producto_proveedor=Producto_Proveedor::find($id);
        $producto_proveedor->precio = $request->precio_producto;
        $producto_proveedor->estado = $request->estado;
        $producto_proveedor->save();

        return redirect()->route('productos_proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function guardarDetalle(Request $request){
        
        $producto_nombre = Producto::find($request->detalleAsignacion["producto"]);
        $detalle_productos_proveedores = [
            "producto_id" => $request->detalleAsignacion['producto'],
            "producto_nombre" => $producto_nombre,
            "precio" => $request->detalleAsignacion['precio'],
        ];

        session()->get('productos_proveedores');
        session()->push('productos_proveedores', $detalle_productos_proveedores);

        return response()->json([
            'productos_proveedores' => session()->get('productos_proveedores'),
            'success' => true
        ]);
    }

    public function cambiarEstado(Request $request,$id){
        $producto_proveedor =Producto_Proveedor::find($id);
        $producto_proveedor->estado = $request->estado;
        $producto_proveedor->save();
    }

    public function solicitudCambioPrecioView($id){
        $producto_proveedor=Producto_Proveedor::find($id);
        $producto = $producto_proveedor->producto;
        if($producto->categoria_id==8){
            return redirect()->route('productos_proveedores.index')->with('solicitud','false');
        }
        return view('productos_proveedores.solicitud', compact('producto_proveedor'));
    }

    public function solicitudCambioPrecioSave(Request $request){
        $producto_proveedor = json_decode($request["producto_proveedor_id"]);
        if( isset($request->producto_proveedor_id) ){
            $producto_proveedor = Producto_Proveedor::find($producto_proveedor->id);
            $producto_proveedor->precio= $request->precio_nuevo;
            $producto_proveedor->save();

            $nombre = $request->nombre;
            $precioanterior=$request->precio_anterior;
            $precionuevo = $request->precio_nuevo;

            $solicitud  = SolicitudCambioPrecio::find($request->solicitud_id);
            $solicitud->estado='ACEPTADO';
            $solicitud->save();

            return view('productos_proveedores.mensaje',compact('nombre','precioanterior','precionuevo'));
        }
               
    }

    public function verSolicitudes($id){
        $producto_proveedor=Producto_Proveedor::find($id);
        $solicitudes = SolicitudCambioPrecio::where('producto__proveedor_id',$producto_proveedor->id)->get();

      /*   dd($solicitudes); */

        return view('productos_proveedores.verSolicitudes',compact('producto_proveedor','solicitudes'));
    }
    


}
