<?php

namespace App\Http\Controllers;

use App\Models\DetalleVacacion;
use App\Models\User;
use App\Models\Vacacion;
use Illuminate\Http\Request;

class VacacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vacaciones =  Vacacion::all();
        //dd($vacaciones);
        return view('vacaciones.index', compact('vacaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('vacaciones.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*  dd($request); */
        $vacacion = new Vacacion();
        $detalleVacacion = new DetalleVacacion();

        $vacacion->fecha_inicio = $request->get('fecha_inicio');
        $vacacion->fecha_fin = $request->get('fecha_fin');
        $vacacion->estado = $request->get('estado');
        $vacacion->user_id = $request->get('usuario_solicitante');
        $vacacion->save();

        if ($vacacion->save()) {
            if ($request->hasFile("foto")) {
                $file = $request->file('foto');
                $destinationPath = 'img/vacaciones/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $detalleVacacion->imagen = $destinationPath . $filename;
            }

            $detalleVacacion->vacacion_id = $vacacion->id;
            $detalleVacacion->user_id = $request->get('usuario_encargado');
            $detalleVacacion->save();
        }

        return redirect()->route('vacaciones.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vacacion =  Vacacion::find($id);
        return view('vacaciones.show', ['vacacion' => $vacacion]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vacacion = Vacacion::find($id);
        return view('vacaciones.edit', ['vacacion' => $vacacion]);
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
        $vacacion = Vacacion::findOrFail($id);

        $vacacion->fecha_inicio = $request->get("fecha_inicio");
        $vacacion->fecha_fin = $request->get("fecha_fin");
        $vacacion->estado = $request->get("estado");
        $vacacion->save();
        $detalleVacacion = DetalleVacacion::where('vacacion_id', $vacacion->id)->first();

        if ($request->hasFile("foto")) {
            if (@getimagesize($detalleVacacion->imagen)) {
                unlink($detalleVacacion->imagen);
                $file = $request->file('foto');
                $destinationPath = 'img/vacaciones/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $detalleVacacion->imagen = $destinationPath . $filename;
            } else {
                $file = $request->file('foto');
                $destinationPath = 'img/vacaciones/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $detalleVacacion->imagen = $destinationPath . $filename;
            }
        }
        $detalleVacacion->save();

        return redirect()->route('vacaciones.show', $vacacion->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vacacion = Vacacion::find($id);
        $detalleVacacion = DetalleVacacion::where('vacacion_id', $vacacion->id)->first();
        unlink($detalleVacacion->imagen);
        Vacacion::destroy($id);
        return response()->json(['success' => true], 200);
    }

    public function agregarVacacion($id)
    {
        $user = User::find($id);
        $users = User::all();
        return view('personales.vacaciones.agregarVacacion', compact('user', 'users'));
    }

    public function guardarVacacion(Request $request, $id)
    {
        $user = User::find($id);
        $users = User::all();
        $vacacion = new Vacacion();
        $detalleVacacion = new DetalleVacacion();

        $vacacion->fecha_inicio = $request->get("fecha_inicio");
        $vacacion->fecha_fin = $request->get("fecha_fin");
        $vacacion->estado = "S";
        $vacacion->user_id = $user->id;
        $vacacion->save();

        if ($vacacion->save()) {
            if ($request->hasFile("foto")) {
                $file = $request->file('foto');
                $destinationPath = 'img/vacaciones/';
                $filename = time() . '-' . $file->getClientOriginalName();
                $uploadSuccess = $request->file('foto')->move($destinationPath, $filename);
                $detalleVacacion->imagen = $destinationPath . $filename;
            }

            $detalleVacacion->vacacion_id = $vacacion->id;
            $detalleVacacion->user_id = $request->get('usuario_encargado');
            $detalleVacacion->save();
        }

        return redirect()->route('personales.showDetalleContrato',$user->id);
    }

    function cambiarestado(Request $request){
        $vacacion = Vacacion::findOrfail($request->id);
            $vacacion->update([
                'estado' =>  "A",
            ]);
        
        return response()->json([ 'status' => true]);
        
    }
}
