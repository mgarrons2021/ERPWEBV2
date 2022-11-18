<?php

namespace App\Http\Controllers;

use App\Models\CategoriaGastosAdministrativos;
use App\Models\SubCategoria;
use Illuminate\Http\Request;

class CategoriaGastosAdministrativosController extends Controller
{
    public function index()
    {
        $categorias_gastos_administrativos = CategoriaGastosAdministrativos::all();
       // dd($categorias_gastos_administrativos);
        //sub_categoria_id
        return view('categorias_gastos_administrativos.index')->with('categorias_gastos_administrativos',$categorias_gastos_administrativos);
    }

    public function create()
    {

        $subCategorias = SubCategoria::all();

        return view('categorias_gastos_administrativos.create',compact('subCategorias'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required' 
        ]);

        $categorias_gastos_administrativos= new CategoriaGastosAdministrativos();

        $categorias_gastos_administrativos->codigo =$request->get('codigo');
        $categorias_gastos_administrativos->nombre =$request->get('nombre');
        $categorias_gastos_administrativos->sub_categoria_id =$request->get('sub_categoria_id');
        $categorias_gastos_administrativos->save();
       
        return redirect()->route('categorias_gastos_administrativos.index');
    }

    public function show($id)
    {
        $categorias_gastos_administrativos = CategoriaGastosAdministrativos::find($id);

       

        return view('categorias_gastos_administrativos.show', ['categorias_gastos_administrativos'=>$categorias_gastos_administrativos]);
    }

    public function edit($id)
    {
    
        $categorias_gastos_administrativos = CategoriaGastosAdministrativos::find($id);
        return view ('categorias_gastos_administrativos.edit',compact('categorias_gastos_administrativos'));
    }

    public function update(Request $request, $id)
    {
        $categorias_gastos_administrativos= CategoriaGastosAdministrativos::find($id);
        $request->validate([
            'nombre' => 'required' 
        ]);
        $categorias_gastos_administrativos->nombre =$request->get('nombre');
        $categorias_gastos_administrativos->save();

        return redirect()->route('categorias_gastos_administrativos.index');
    }

    public function destroy($id)
    {
        $categorias_gastos_administrativos= CategoriaGastosAdministrativos::find($id);
        $categorias_gastos_administrativos->delete();
        return response()->json(['success' => true], 200);

    }


}
