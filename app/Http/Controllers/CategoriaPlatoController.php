<?php

namespace App\Http\Controllers;

use App\Models\CategoriaPlato;
use Illuminate\Http\Request;

class CategoriaPlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias_platos = CategoriaPlato::all();
        return view('categorias_platos.index',compact('categorias_platos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoria_plato = CategoriaPlato::all();
        return view('categorias_platos.create',compact('categoria_plato') );
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
            'nombre' =>'required',

        ]);

        $categoria_plato = new CategoriaPlato();
        $categoria_plato->nombre = $request->get('nombre');
        $categoria_plato->estado = $request->get('estado');
        $categoria_plato->save();

        return redirect()->route('categorias_platos.store');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoria_plato= CategoriaPlato::find($id);

        return view('categorias_platos.show', compact('categoria_plato') );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categoria_plato = CategoriaPlato::find($id);
        return view('categorias_platos.edit', compact('categoria_plato') );
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
        $categoria_plato = CategoriaPlato::find($id);
        $categoria_plato->nombre = $request->get('nombre');
        $categoria_plato->estado = $request->get('estado');
        $categoria_plato->save();

        return redirect()->route('categorias_platos.index');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria_plato = CategoriaPlato::find($id);
        $categoria_plato->delete();

        return redirect()->route('categorias_platos.index')->with('eliminar','ok');



    }
}
