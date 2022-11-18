<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaPlato;
use App\Models\Plato;
use App\Models\PlatoSucursal;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class PlatoSucursalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales= Sucursal::all();
        $platos_sucursales = PlatoSucursal::all();
        return view('platos_sucursales.index',compact('platos_sucursales','sucursales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       /*  dd(session('platos_sucursales')); */
        $platos = Plato::all();
        $sucursales = Sucursal::all();
        $categorias_platos = CategoriaPlato::all();
        return view('platos_sucursales.create',compact('platos','sucursales','categorias_platos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        foreach (session('platos_sucursales') as $key => $value) {
        $plato_sucursal = new PlatoSucursal();
        $plato_sucursal->precio = $value['precio'];
        $plato_sucursal->precio_delivery = $value['precio_delivery'];
        $plato_sucursal->plato_id = $value['plato_id'];

        $plato_sucursal->sucursal_id =$value['sucursal_id'];
        $plato_sucursal->categoria_plato_id = $value['categoria_plato_id'];
        
        $plato_sucursal->save();
    }
        session()->forget('platos_sucursales');

        session()->get('platos_asignados');
        session()->put('platos_asignados', 'ok');
        return response()->json(
            [
                'success' => true
            ]
    );

        /* return view('platos_sucursales.index'); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plato_sucursal = PlatoSucursal::find($id);
        return view('platos_sucursales.edit', compact('plato_sucursal'));
        
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
        $plato_sucursal = PlatoSucursal::find($id);
        $plato_sucursal->precio = $request ->get('precio');
        $plato_sucursal->precio_delivery = $request->get('precio_delivery');

        $plato_sucursal->save();

        return redirect()->route('platos_sucursales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plato_sucursal = PlatoSucursal::findOrFail($id);
        $plato_sucursal->delete();

        return redirect()->route('platos_sucursales.index')->with('eliminar','ok');
    }

    public function obtenerPlato(Request $request){

        if (isset($request->categoria_id)) {
            $platos = Plato::where('categoria_plato_id', $request->categoria_id)->join('categorias_plato','categorias_plato.id','=','platos.categoria_plato_id')
            ->get();

            /* productos = Producto_Proveedor::where('proveedor_id', $request->proveedor_id)
            ->join('productos', 'productos.id', '=', 'producto_proveedor.producto_id')->get(); */
            return response()->json(
                [
                    'lista' => $platos,
                    'success' => true
                ]
            );
        } 
    }


    
    public function enviarPlato(Request $request){
        /* dd($request); */
        $plato = Plato::find($request->platosucursal["plato"]); 
        $sucursal = Sucursal::find($request->platosucursal["sucursal"]);
        
        $plato_sucursal_array =[
           "precio" => $request->platosucursal['precio'],
           "precio_delivery" =>$request->platosucursal['precio_delivery'],
           "plato_id" => $plato->id,
           "plato_nombre" => $plato->nombre,
           "categoria_plato_id" => $request->platosucursal['categoria_plato_id'],
           "categoria_plato_nombre" => $request->platosucursal['categoria_plato_nombre'],
           "sucursal_id" => $sucursal->id,
           "sucursal" => $sucursal->nombre,
        ];
       /*   dd($plato_sucursal_array);  */

        /* Creo la Sesion llamada "platos_sucursales" e inserto mi array dentro de la session" */
        session()->get('platos_sucursales');
        session()->push('platos_sucursales', $plato_sucursal_array);
        


         return response()->json([
            'platos_sucursales' => session()->get('platos_sucursales'),
            'success' =>true,
        ]);


    }

    public function eliminarPlato(Request $request){
        $platos_sucursales_asignados = session('platos_sucursales');
        unset($platos_sucursales_asignados[$request->data]);

        session()->put('platos_sucursales', $platos_sucursales_asignados);

        return response()->json([
            'platos_sucursales' => session()->get('platos_sucursales'),
            'success' =>true,
        ]);

    }

    public function filtrarPlatos (Request $request){
       
            
            $sucursales = Sucursal::all();
            $sucursal_id = $request->get('sucursal_id');
            
            $platos_sucursales = PlatoSucursal::where('sucursal_id',$sucursal_id)->get();

            
        
            return view('platos_sucursales.index',compact('sucursales','platos_sucursales'));
    }
    

    public function eliminarDetalle($id,Request $request){
       /*  $plato_id = $request->get('plato_id');
        $sucursal_id = $request->get('sucursal_id');
        $categoria_plato_id = $request->get('categoria_plato_id');

        $plato_sucursal = PlatoSucursal::find($id);33
        $plato_sucursal->id->detach($plato_id,$sucursal_id,$categoria_plato_id);

        return redirect()->route('platos_sucursales.index',compact('plato_sucursal')); */




    }

   
}
