<?php

namespace App\Http\Controllers;

use App\Models\DetalleRetrasoFalta;
use App\Models\RetrasoFalta;
use App\Models\Sucursal;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class RetrasoyFaltaController extends Controller
{
    use HasRoles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = Auth::id();
        $user = User::find($id);
        $role = $user->roles();
        $sucursal = $user->sucursals[0]->id;
        foreach ($user->roles as $rol) {
            if ($user->roles[0]->id == 3) {
                $retrasos_faltas_total = RetrasoFalta::where('sucursal_id',  $sucursal)->where('estado', '=' , 1)->get();
                return view('retrasos_faltas.index', compact('retrasos_faltas_total'));
            } else {
                $retrasos_faltas_total = RetrasoFalta::all();
                return view('retrasos_faltas.index', compact('retrasos_faltas_total'));
            }
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id = Auth::id();
        $user = User::find($id);
        $sucursales = $user->sucursals[0];
        $role = $user->roles();
        foreach ($user->roles as $rol) {
            if ($rol->id == 3) {
                $usuarios = User::whereHas('sucursals', function ($q) {
                    $id = Auth::id();
                    $user = User::find($id);
                    $sucursales = $user->sucursals[0];
                    $q->where('sucursals.id', '=',   $sucursales->id);
                })->get();
                return view('retrasos_faltas.create', compact('usuarios', 'sucursales'));
            } else {
                $usuarios = User::all();
                $sucursales = Sucursal::all();
                /*        dd($sucursales); */
                return view('retrasos_faltas.create', compact('usuarios', 'sucursales'));
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'fecha' => 'required',
            'funcionario_registrado' => 'required',
            'funcionario_encargado' => 'required',
            'descripcion' => 'required',
        ]);
        $datos = new RetrasoFalta();
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $destinationPath = 'img/retrasos-faltas/';
            $filename = time() . '-' . $file->getClientOriginalName();
            $uploadsucess = $request->file('imagen')->move($destinationPath, $filename);
            $datos->imagen = $destinationPath . $filename;
        }
        $datos->fecha = $request->fecha;
        $datos->hora = $request->hora;
        $datos->descripcion = $request->descripcion;
        $datos->sucursal_id = $request->sucursal_id;
        $datos->justificativo = $request->justificativo;
        $datos->tipo_registro = $request->tipo_registro;
        $datos->user_id = $request->funcionario_registrado;
        $datos->estado = $request->estado;
        $datos->save();

        if ($datos->save()) {
            $detalleRetrasoFalta = new DetalleRetrasoFalta();
            $detalleRetrasoFalta->user_id = $request->funcionario_encargado;
            $detalleRetrasoFalta->retraso_falta_id = $datos->id;
            $detalleRetrasoFalta->save();
        }
        return back()->with('retraso-sancion', 'registrado');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $retrasos =  RetrasoFalta::find($id);
        return view('retrasos_faltas.show', compact('retrasos'));
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
    public function destroy($id)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $datos = RetrasoFalta::find($id);
        foreach ($user->roles as $rol) {
            if ($user->roles[0]->id == 1) {
                RetrasoFalta::destroy($id);
                return response()->json(['success' => true],200);
            }else{
                $datos->estado = 0;
                $datos->save();
                return response()->json(['success' => true],200);
            }      
        }
    }
}