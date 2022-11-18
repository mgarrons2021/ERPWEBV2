<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPlato;
use App\Models\DetalleInventario;
use App\Models\Plato;
use App\Models\PlatoProducto;
use App\Models\PlatoSucursal;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\UnidadMedidaCompra;
use App\Models\UnidadMedidaVenta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;


class PlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platos = Plato::all();
        $cantidadPlatos = Plato::where('costo_plato', '<>', null)->count();
        $sumaCosto = Plato::sum('costo_plato');

        $categorias_platos = CategoriaPlato::all();
        if ($cantidadPlatos == 0) {
            $costoPromedioTotal = 0;
        } else {
            $costoPromedioTotal = $sumaCosto / $cantidadPlatos;
        }


        return view('platos.index', compact('categorias_platos', 'platos', 'costoPromedioTotal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $um_compras = UnidadMedidaCompra::all();
        $um_ventas = UnidadMedidaVenta::all();
        $categorias_platos = CategoriaPlato::all();
        $platos = Plato::all();
        return view('platos.create', compact('categorias_platos', 'platos', 'um_compras', 'um_ventas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',

        ]);

        $plato = new Plato();
        $plato->nombre = $request->get('nombre');

        if ($request->hasFile('imagen')) {
            $file = $request->file(('imagen'));
            $destinationPath = 'img/platos/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadsucess = $request->file('imagen')->move($destinationPath, $filename);
            $plato->imagen = $destinationPath . $filename;
        }

        $plato->unidad_medida_compra_id = $request->get('unidad_medida_compra_id');
        $plato->unidad_medida_venta_id = $request->get('unidad_medida_venta_id');
        $plato->estado = $request->get('estado');
        $plato->save();

        return redirect()->route('platos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plato = Plato::find($id);
        $recetas = PlatoProducto::where('plato_id', $id)->get();
        $categoria_plato = CategoriaPlato::all();
        return view('platos.show', compact('plato', 'categoria_plato', 'recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plato = Plato::find($id);
        $categorias_platos = CategoriaPlato::all();
        $um_compras = UnidadMedidaCompra::all();
        $um_ventas = UnidadMedidaVenta::all();
        return view('platos.edit', compact('plato', 'categorias_platos', 'um_compras', 'um_ventas'));
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
        $plato = Plato::find($id);
        $plato->nombre = $request->get('nombre');

        if ($request->hasFile("imagen")) {
            if (@getimagesize($plato->imagen)) {
                unlink($plato->imagen);
                $file = $request->file('imagen');
                $destinationPath = 'img/platos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('imagen')->move($destinationPath, $filename);
                $plato->imagen = $destinationPath . $filename;
            } else {
                $file = $request->file('imagen');
                $destinationPath = 'img/platos/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('imagen')->move($destinationPath, $filename);
                $plato->imagen = $destinationPath . $filename;
            }
        }
        $plato->unidad_medida_compra_id = $request->get('unidad_medida_compra_id');
        $plato->unidad_medida_venta_id = $request->get('unidad_medida_venta_id');
        $plato->estado = $request->get('estado');
        $plato->save();

        return redirect()->route('platos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plato = Plato::find($id);
        unlink($plato->imagen);
        Plato::destroy($id);

        return redirect()->route('platos.index')->with('eliminar', 'ok');
    }

    public function obtenercosto(Request $request)
    {
        $plato = Plato::find($request->idplato);
        $detalle = DetalleInventario::where('plato_id', $plato->id)->get();
        /* if(  ){

        }else{

        } */
    }

    public function asignarReceta($id)
    {
        $recetas = PlatoProducto::where('plato_id', $id)->get();
        if (isset($recetas[0])) {
            $categorias_platos = CategoriaPlato::all();
            $platos = Plato::all();
            return redirect()->route('platos.index', compact('categorias_platos', 'platos'))->with('receta', 'tiene');
        } else {
            $plato = Plato::find($id);
            $categoria_plato = CategoriaPlato::all();
            $recetas = PlatoProducto::all();
            $productos = Producto::all();
            $proveedores = Proveedor::all();
            return view('recetas.create', compact('categoria_plato', 'recetas', 'productos', 'proveedores', 'plato'));
        }
    }

    public function filtrarPlatos(Request $request)
    {
        

        $categorias_platos = CategoriaPlato::all();
        $categoria_plato_id = $request->categoria_plato_id;

        $platos = Plato::selectRaw('DISTINCT platos.id, platos.nombre,platos.costo_plato,platos.estado, categorias_plato.nombre as nombre_categoria')
            ->join('platos_sucursales', 'platos_sucursales.plato_id', '=', 'platos.id')
            ->join('categorias_plato','categorias_plato.id','=','platos_sucursales.categoria_plato_id')
            ->where('platos_sucursales.categoria_plato_id', $categoria_plato_id)
            ->distinct()
            ->get(); 
        
    
        
          $cantidadPlatosCosteados =  Plato::selectRaw('DISTINCT platos.id, platos.nombre,platos.costo_plato,platos.estado, categorias_plato.nombre as nombre_categoria')
        ->join('platos_sucursales', 'platos_sucursales.plato_id', '=', 'platos.id')
        ->join('categorias_plato','categorias_plato.id','=','platos_sucursales.categoria_plato_id')
        ->where('platos.costo_plato','<>',null)
        ->where('platos_sucursales.categoria_plato_id', $categoria_plato_id)
        ->get();   
        


      
        
     /*    $totalPlatos = $cantidadPlatosCosteados->total_platos- $cantidadPlatosNulos->total_platos ;  */
        
         /* dd($platos,$cantidadPlatos);  */   

         $sumaCosto = $platos->sum('costo_plato');
         
         
            foreach ($cantidadPlatosCosteados as $key => $plato) {
            
             if (is_null($plato->costo_plato)) {
                    $cantidadPlatosCosteados->pop();
                }else{
                    $cantidad = $plato->count(); 
                }
            } 
            
            $cantidad = $cantidadPlatosCosteados->count();
            /* dd($cantidad) ;  */
            
         /* $cantidadPlatos = $platos->where($platos->costo_plato,'<>',null)->count();  */
     

        
        if ($cantidad == 0) {
            $costoPromedioTotal = 0;
        } else {
            $costoPromedioTotal = $sumaCosto / $cantidad;
        }

        return view('platos.index', compact('platos', 'categorias_platos', 'costoPromedioTotal'));
    }

    public function showPdf($id){

        $plato = Plato::find($id);
        $recetas = PlatoProducto::where('plato_id', $id)->get();

        view()->share('platos.show-PDF', $plato, $recetas);

        $pdf = PDF::loadView('platos.show-PDF', ['plato' => $plato, 'recetas' => $recetas])->setOptions(['defaultFont' => 'sans-serif', 'isRemoteEnabled' => true]);

        return $pdf->stream('Plato-Receta-' . $plato->id . '.pdf', ['Attachment' => false]);
    }
}
