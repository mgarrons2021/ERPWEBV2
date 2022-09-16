<?php

namespace App\Http\Controllers;

use App\Models\CategoriaCajaChica;
use Illuminate\Http\Request;

class CategoriaCajaChicaController extends Controller
{
    public function index()
    {
        $categorias_caja_chica = CategoriaCajaChica::all();
        return view('categorias_caja_chica.index')->with('categorias_caja_chica',$categorias_caja_chica);
    }

    public function create()
    {
        return view('categorias_caja_chica.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required' 
        ]);

        $categoria_caja_chica= new CategoriaCajaChica();
        $categoria_caja_chica->nombre =$request->get('nombre');
        $categoria_caja_chica->save();
       
        return redirect()->route('categorias_caja_chica.index');
    }

    public function show($id)
    {
        $categoria_caja_chica = CategoriaCajaChica::find($id);
       
        return view('categorias_caja_chica.show', ['categoria_caja_chica'=>$categoria_caja_chica]);
    }

    public function edit($id)
    {
    
        $categoria_caja_chica = CategoriaCajaChica::find($id);
        return view ('categorias_caja_chica.edit',compact('categoria_caja_chica'));
    }

    public function update(Request $request, $id)
    {
        $categoria_caja_chica= CategoriaCajaChica::find($id);
        $request->validate([
            'nombre' => 'required' 
        ]);
        $categoria_caja_chica->nombre =$request->get('nombre');
        $categoria_caja_chica->save();

        return redirect()->route('categorias_caja_chica.index');
    }

    public function destroy($id)
    {
        $categoria_caja_chica= CategoriaCajaChica::find($id);
        $categoria_caja_chica->delete();
        return response()->json(['success' => true], 200);

    }


}
