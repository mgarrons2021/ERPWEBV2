<?php

namespace App\Http\Controllers;

use App\Models\Postulantes;
use Illuminate\Http\Request;

class PostulantesController extends Controller
{
    public function index()
    {
        $postulante = Postulantes::all();
        return view('postulantes.index', compact('postulante'));
    }

    public function create()
    {
        return view('postulantes.create');
    }

    public function contratar(Request $request){
       // dd($request);
        $postulante = new Postulantes();
        $postulante->name=$request->nombre;
        $postulante->apellido =$request->apellido;
        $postulante->celular_personal=$request->nro_celular_personal;
        $postulante->observacion = $request->observacion;
        $postulante->estado = 0;
        $postulante->save();
        return redirect()->route('postulantes.index');
    }

  /*   public function store(Request $request)
    {  name','apellido','celular_personal','observacion', 'estado'
        $request->validate([
            'tipo_contrato' => 'required',
            'sueldo' => 'required',
            'duracion_contrato' => 'required',
        ]);

        $contrato = new Contrato();
        $contrato->tipo_contrato = $request->get('tipo_contrato');
        $contrato->sueldo = $request->get('sueldo');
        $contrato->duracion_contrato = $request->get('duracion_contrato');
        $contrato->save();

        return redirect()->route('contratos.index');
    } */

    public function show($id)
    {
        $postulante = Postulantes::find($id);
        return view('postulantes.show', ['postulantes' => $postulante]);
    }

     public function editDatosBasicos($id)
    {
        $postulante = Postulantes::find($id);
        return view('postulantes.datosbasicos', compact('postulante'));
    }

   public function actualizarDatosBasicos(Request $request, $id)
   {
        $postulante = Postulantes::find($id);
        $request->validate([
            'name' => 'required',
            'apellido' => 'required',
            'nro_celular_personal' => 'required',
            'observacion' => 'required',
            'estado' => 'required',
        ]);
        $postulante->name = $request->get('name');
        $postulante->apellido = $request->get('apellido');
        $postulante->celular_personal= $request->get('nro_celular_personal');
        $postulante->observacion = $request->get('observacion');
        $postulante->estado = $request->get('estado');
        $postulante->save();
        return redirect()->route('postulantes.index');
    } 

    public function destroy($id)
    {
        $postulante = Postulantes::find($id);
        $postulante->delete();
        return redirect()->route('postulantes.index')->with('eliminar', 'ok');
    }
}
