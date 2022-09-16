<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPlato;
use App\Models\Plato;
use App\Models\PlatoProducto;
use App\Models\Producto;
use App\Models\Producto_Proveedor;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class PlatoProductoController extends Controller
{
    public function create()
    {

        $categoria_plato = CategoriaPlato::all();
        $recetas = PlatoProducto::all();
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('recetas.create', compact('categoria_plato', 'recetas', 'productos', 'proveedores'));
    }
    public function obtenerPlatos(Request $request)
    {
        if (isset($request->categoria_id)) {
            $platos = Plato::where('categoria_plato_id', $request->categoria_id)->get();
            return response()->json(
                [
                    'lista' => $platos,
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
    public function obtenerProductos(Request $request)
    {

        if (isset($request->proveedor_id)) {
            $productos = Producto_Proveedor::where('proveedor_id', $request->proveedor_id)
                ->join('productos', 'productos.id', '=', 'producto_proveedor.producto_id')->get();

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
    public function obtenerPrecio(Request $request)
    {
        $producto_proveedor = Producto_Proveedor::where('producto_id', $request->producto_id)->where('proveedor_id', $request->proveedor_id)->first();
        return response()->json($producto_proveedor->precio);
    }


    public function agregarDetalle(Request $request)
    {
        /* dd($request); */
        $request->validate([
            'producto_id' => 'request',
        ]);
        $producto = Producto::find($request->detallePlato["producto_id"]);
        $detalle_receta = [
            "producto_id" => $request->detallePlato["producto_id"],
            "proveedor_id" => $request->detallePlato["proveedor_id"],
            "producto_nombre" => $producto->nombre,
            "precio" => $request->detallePlato['precio'],
            "cantidad" => $request->detallePlato['cantidad'],
            "subtotal" => $request->detallePlato['subtotal'],
        ];
        session()->get('lista_receta');
        session()->push('lista_receta', $detalle_receta);
        return response()->json([
            'lista_receta' => session()->get('lista_receta'),
            'success' => true
        ]);
    }

    public function eliminarDetalle(Request $request)
    {
        $detalle_receta = session('lista_receta');
        unset($detalle_receta[$request->data]);
        session()->put('lista_receta', $detalle_receta);
        return response()->json(
            [
                'lista_receta' => session()->get('lista_receta'),
                'success' => true
            ]
        );
    }
    public function registrarReceta(Request $request)
    {
        /* dd(session('lista_receta')); */
        $total = 0;
        foreach (session('lista_receta') as $id => $item) {
            //dd($item);
            $producto_proveedor=Producto_Proveedor::where('producto_id',$item['producto_id'])->where('proveedor_id',$item['proveedor_id'])->first();
            $detalle_receta = new PlatoProducto();
            $detalle_receta->plato_id = $request->plato_id;
            $detalle_receta->producto_proveedor_id =$producto_proveedor->id ;
            $detalle_receta->cantidad = $item['cantidad'];
            $detalle_receta->subtotal = $item['subtotal'];
            $total +=  $item['subtotal'];
            $detalle_receta->save();
        }
        $plato = Plato::find($request->plato_id);
        $plato->costo_plato =  $total;
        $plato->save();
        session()->forget('lista_receta');

        if ($detalle_receta->save()) {
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
    public function edit($id)
    {
        $recetas = PlatoProducto::where('plato_id', $id)->get();
        ///dd($recetas);
        if (isset($recetas[0])) {
            $platos = Plato::find($id);
            $recetas = PlatoProducto::where('plato_id', $id)->get();
            return view('recetas.editar_receta', compact('platos', 'recetas'));
        } else {
            $categorias_platos = CategoriaPlato::all();
            $platos = Plato::all();
            return redirect()->route('platos.index', compact('categorias_platos', 'platos'))->with('receta', 'true');
        }
    }
    public function actualizarReceta(Request $request)
    {
        $total = 0;
        $total_eliminacion = 0;
        $plato = Plato::find($request->plato_id);

        if (sizeof($request->detallesAEditar_id) != 0) {
            foreach ($request->detallesAEditar_id as $index => $detalleEditar) {
                $receta = PlatoProducto::find($detalleEditar);
                $receta->cantidad = $request->cantidades[$index];
                $receta->subtotal = $request->subtotales[$index];
                $receta->save();
            }
        }
        if (sizeof($request->detallesAEliminar_id) != 0) {
            foreach ($request->detallesAEliminar_id as $index => $detalleEliminar) {
                $receta = PlatoProducto::find($detalleEliminar);
                $total_eliminacion += $receta->subtotal;
                $receta->delete();
            }
        }
        $recetas = PlatoProducto::where('plato_id', $request->plato_id)->get();
        foreach ($recetas as $receta) {

            $total += $receta->subtotal;
        }
        $plato->costo_plato = $total;
        $plato->save();
        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
