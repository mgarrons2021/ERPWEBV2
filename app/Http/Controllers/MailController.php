<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use App\Models\Producto;
use App\Models\Producto_Proveedor;
use App\Models\SolicitudCambioPrecio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class MailController extends Controller
{
    //
    public function sendEmail(Request $request)
    {
        $solicitud =new SolicitudCambioPrecio();
        $solicitud->fecha = Carbon::now()->format('Y-m-d');
        $solicitud->estado = "PENDIENTE";
        $solicitud->motivo_cambio = $request->motivo;


        $solicitud->producto__proveedor_id = $request->producto_proveedor_id;
        $solicitud->save();
        
        $producto =  Producto::find($request->producto);
        $precionuevo = $request->precionuevo;
        $precioanterior = $request->precioanterior;
        $motivo = $request->motivo;

        $producto_proveedor = Producto_Proveedor::find($request->producto_proveedor_id);        
        $producto_id =$producto_proveedor->producto->id;
        $historial_productos = DB::select("select  productos.nombre as nombre ,detalles_compra.precio_compra as precio_compra, compras.fecha_compra as fecha_compra 
        from detalles_compra
        JOIN compras on compras.id = detalles_compra.compra_id
        join productos on productos.id= detalles_compra.producto_id
        JOIN producto_proveedor on producto_proveedor.producto_id = productos.id
        JOIN proveedores ON proveedores.id = producto_proveedor.proveedor_id
    	where productos.id= '$producto->id'
        GROUP by productos.nombre, compras.fecha_compra,detalles_compra.precio_compra, compras.fecha_compra ;");

        $datos = [
            'idproducto'=>$producto->id,
            'producto' => $producto->nombre,
            'producto_proveedor' => $producto_proveedor,
            'precionuevo' => $precionuevo,
            'precioanterior' => $precioanterior,
            'motivo' => $motivo,
            'solicitud_id' =>$solicitud->id,
            'historial'=>$historial_productos
        ];
        $details = [
            'title' => 'Solicitud de Cambio de Precio',
            'body' => $datos
        ];


        Mail::to('wilsoncoyoleon@gmail.com')->send(new TestMail($details));
        return true;
    }
}
