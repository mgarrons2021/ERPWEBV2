<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\CategoriaSancion;
use App\Models\DetalleSancion;
use App\Models\Sanciones;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SancionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sanciones = Sanciones::all();
        //dd($sanciones);
        return view('sanciones.index', compact('sanciones'));
    }

    public function filtrarSanciones(Request $request){
        $fecha_inicial =$request->fecha_inicial;
        $fecha_final = $request->fecha_final;

        $sanciones = Sanciones::whereBetween('fecha', [$fecha_inicial, $fecha_final])->get();
        return view('sanciones.index', compact('sanciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuarios= User::all();
        $sucursales = Sucursal::all();
        $sanciones = CategoriaSancion::all();
        //dd($usuarios);
        return view('sanciones.create', compact('usuarios', 'sucursales', 'sanciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* dd($request); */
        $request->validate([
            'fecha'=>'required',
            'funcionario_encargado'=>'required',
            'funcionario_sancionado'=>'required',
            'sucursal_id'=>'required',
            'descripcion'=>'required',         
        ]);
        $datos = new Sanciones();
        if($request->hasFile('imagen')){
            $file= $request->file('imagen');
            $destinationPath ='img/sanciones/';
            $filename = time() .'-'. $file->getClientOriginalName();
            $uploadsucess = $request->file('imagen')->move($destinationPath, $filename);
            $datos->imagen = $destinationPath.$filename;
        }
        $datos->fecha = $request->fecha;
        $datos->descripcion = $request->descripcion;
        $datos->categoria_sancion_id = $request->categoria_sancion_id;
        $datos->sucursal_id = $request->sucursal_id;
        $datos->user_id = $request->funcionario_sancionado;
        $datos->save();

        if($datos->save()){
            $detalleSancion =new DetalleSancion();
            $detalleSancion->user_id = $request->funcionario_encargado;
            $detalleSancion->sanciones_id = $datos->id;
            $detalleSancion->save();
        }
        return back()->with('sancion', 'registrado');

    } 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sancion =  Sanciones::find($id);
        return view('sanciones.show', ['sancion'=>$sancion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sancion =  Sanciones::find($id);
        $sucursales = Sucursal::all();
        $categoria_sanciones = CategoriaSancion::all();
        $users = User::all();
        return view('sanciones.edit', compact('sancion' , 'sucursales', 'users', 'categoria_sanciones'));
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
        $sanciones = Sanciones::findOrFail($id);
        if($request->hasFile('imagen')){
            $file= $request->file(('imagen'));
            $destinationPath ='img/sanciones/';
            $filename = time() .'-'. $file->getClientOriginalName();
            $uploadsucess = $request->file('imagen')->move($destinationPath, $filename);
            $sanciones->imagen = $destinationPath.$filename;
        }
        $sanciones->fecha = $request->fecha;
        $sanciones->descripcion = $request->descripcion;
        $sanciones->sucursal_id = $request->sucursal_id;
        $sanciones->user_id = $request->user_id;
        $sanciones->save();
        return redirect()->route('sanciones.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Sanciones::destroy($id);
        return response()->json(['success' => true],200);
    }
}
