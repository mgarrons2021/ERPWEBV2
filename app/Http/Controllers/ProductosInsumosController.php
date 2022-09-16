<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\InsumosDias;
use App\Models\ProductosInsumos;

class ProductosInsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $insumos = InsumosDias::all();
        $categorias= Categoria::all();
        $productos= ProductosInsumos::all();
        return view('pedidos.nuevos_insumos',compact( 'categorias' , 'insumos' , 'productos' ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $productos= $request->productos;
       // dd($productos);
        foreach ($productos as  $value) {
            $product = new ProductosInsumos(); 
            $product->cantidad =$value['cantidad']; 
            $product->producto_id= $value['idproducto']; 
            $product->insumos_dias_id= $value['iddia'];
            $product->save();
        } 

        return response()->json([
            'success' => true], 200);
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
    public function destroy(Request $request) /* TAS EN BOLAS FERNANDIN */
    {
        //
        $prod= ProductosInsumos::find($request->id); 
        $prod->delete();
        return response()->json([
            'success' => true], 200);
    }
}
