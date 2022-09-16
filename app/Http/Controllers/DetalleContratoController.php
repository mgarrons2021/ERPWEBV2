<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\DetalleContrato;
use Illuminate\Http\Request;

class DetalleContratoController extends Controller
{
    public function edit($id){
        $detalleContrato = DetalleContrato::find($id);
        $contratos=Contrato::all();
        return view('personales.contratos.editarContrato',compact('detalleContrato','contratos'));
    }

    public function update(Request $request,$id){
        $detalleContrato = DetalleContrato::find($id);
        $detalleContrato->fecha_inicio_contrato = $request->fecha_inicio_contrato;
        $detalleContrato->fecha_fin_contrato = $request->fecha_fin_contrato;
        $detalleContrato->disponibilidad = $request->disponibilidad;
        $detalleContrato->contrato_id = $request->tipo_contrato;
        $detalleContrato->user_id = $request->usuario_id;
        $detalleContrato->save();

        return redirect()->route('personales.showDetalleContrato',$detalleContrato->user_id);
    }

    public function eliminar($id){
        $detalleContrato = DetalleContrato::find($id);
        $detalleContrato->delete();
        return redirect()->route('personales.showDetalleContrato',$detalleContrato->user_id);
    }


}
