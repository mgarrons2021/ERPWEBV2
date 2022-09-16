<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::all();
        return view('contratos.index', compact('contratos'));
    }

    public function create()
    {
        return view('contratos.create');
    }

    public function store(Request $request)
    {
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
    }

    public function show($id)
    {
        $contrato = Contrato::find($id);
        return view('contratos.show', ['contrato' => $contrato]);
    }

    public function edit($id)
    {
        $contrato = Contrato::find($id);
        return view('contratos.edit', compact('contrato'));
    }

    public function update(Request $request, $id)
    {
        $contrato = Contrato::find($id);
        $request->validate([
            'tipo_contrato' => 'required',
            'sueldo' => 'required',
            'duracion_contrato' => 'required',
        ]);
        $contrato->tipo_contrato = $request->get('tipo_contrato');
        $contrato->sueldo = $request->get('sueldo');
        $contrato->duracion_contrato = $request->get('duracion_contrato');
        $contrato->save();

        return redirect()->route('contratos.index');
    }

    public function destroy($id)
    {
        $contrato = Contrato::find($id);
        $contrato->delete();
        return redirect()->route('contratos.index')->with('eliminar', 'ok');
    }
}
