<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Observacion;
use App\Models\DetalleObservacion;
use App\Models\User;

class ObservacionController extends Controller
{
    public function index(){
        $observaciones= Observacion::all();
        return view('observaciones.index',compact('observaciones'));
    }

    public function create(){
        $usuarios = User::all();
        $observaciones=Observacion::all();
        return view('observaciones.create',compact('observaciones','usuarios'));
    }

    public function store(Request $request){
        //dd($request); 
        $request->validate([
            'fecha_observacion' => 'Required',
            'descripcion'=> 'Required',
            'foto'=> 'Required',
        ]);
        $observacion = new Observacion();
        $detalleObservacion = new DetalleObservacion();
        if($request->hasFile('foto')){
            $file= $request->file(('foto'));
            $destinationPath ='img/observaciones/';
            $filename = time() .'-'. $file->getClientOriginalName();
            $uploadsucess = $request->file('foto')->move($destinationPath, $filename);
            $observacion->foto = $destinationPath.$filename;
        }
        $observacion->fecha_observacion = $request->get('fecha_observacion');
        $observacion->descripcion = $request->get('descripcion');
        $observacion->user_id = $request->get('usuario');
        $observacion->save();

        $detalleObservacion->observacion_id = $observacion->id;
        $detalleObservacion->user_id = $request->get('usuario_observado');
        $detalleObservacion->save();
        
        return redirect()->route('observaciones.index');
    }

    public function show($id){
        $observacion = Observacion::find($id);
        $usuario = User::find($observacion->user_id);
        return view('observaciones.show', ['observacion'=>$observacion, 'usuario'=> $usuario ]);
    }

    public function edit($id){
        $observacion = Observacion::find($id);
        $usuarios=User::all();
        return view('observaciones.edit',compact('observacion','usuarios'));
    }

    public function update(Request $request,$id){

       
        $observacion=  Observacion::find($id);
        $detalleObservacion = DetalleObservacion::where('observacion_id',$observacion->id)->first();
        $observacion->fecha_observacion =$request->get('fecha_observacion');
        $observacion->descripcion =$request->get('descripcion');
        $observacion->user_id = $request->get('usuario');

        $detalleObservacion->user_id = $request->get("usuario_observado");
        $detalleObservacion->save();
        if ($request->hasFile("foto")) {
            if (@getimagesize($user->foto)) {
                unlink($observacion->foto);
                $file = $request->file('foto');
                $destinationPath = 'img/observaciones/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $observacion->foto = $destinationPath . $filename;
            } else {
                $file = $request->file('foto');
                $destinationPath = 'img/observaciones/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $observacion->foto = $destinationPath . $filename;
            }
        }
    
        $observacion->save();
        return redirect()->route('observaciones.index');
    }
    public function destroy($id){
        $observacion = Observacion::find($id);
        unlink($observacion->foto);
        Observacion::destroy($id);
        return response()->json(['success' => true],200);   
    }   
}

