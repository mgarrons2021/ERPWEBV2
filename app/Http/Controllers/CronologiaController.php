<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cronologia;
use App\Models\User;
use App\Models\DetalleCronologia;

class CronologiaController extends Controller
{
    public function index(){
        $cronologias= Cronologia::all();
        return view('cronologias.index',compact('cronologias'));
    }

    public function create(){
        $usuarios=User::all();
        $cronologia= Cronologia::all();
        return view('cronologias.create',compact('usuarios'));
    }

    public function store(Request $request){
        $request->validate([
            'usuario'=>'required',
            'fecha_cronologia'=>'required',
            'descripcion'=>'required',
        ]);
        $cronologia = new Cronologia();
        $detalleCronologia = new DetalleCronologia();
        $cronologia->fecha_cronologia = $request->get('fecha_cronologia');
        $cronologia->descripcion = $request->get('descripcion');
        $cronologia->user_id = $request->get('usuario');
        $cronologia->save();

        $detalleCronologia->cronologia_id = $cronologia->id;
        $detalleCronologia->user_id = $request->get('usuario_cr');
        $detalleCronologia->save();
        return redirect()->route('cronologias.index');
    }

    public function show($id){
        $cronologia = Cronologia::find($id);
        $usuario = User::find($cronologia->user_id);
        return view('cronologias.show', ['cronologia'=>$cronologia, 'usuario'=> $usuario ]);
    }

    public function edit($id){
        $cronologia = Cronologia::find($id);
        $usuarios=User::all();
        return view('cronologias.edit',compact('cronologia','usuarios'));
    }

    public function update(Request $request,$id){
        $cronologia=  Cronologia::find($id);
        $detalleCronologia = DetalleCronologia::where('cronologia_id',$cronologia->id)->first();
        $detalleCronologia->user_id = $request->get('usuario_cr');
        $detalleCronologia->save();
        $cronologia->fecha_cronologia =$request->get('fecha_cronologia');
        $cronologia->descripcion =$request->get('descripcion');
        $cronologia->user_id = $request->get('usuario');
        $cronologia->save();
        return redirect()->route('cronologias.index');
    }

    public function destroy($id){
        //*dd($id);
        Cronologia::destroy($id);
        return response()->json(['success' => true],200);
    }
}
