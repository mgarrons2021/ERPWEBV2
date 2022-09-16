<?php

namespace App\Http\Controllers\Siat;

use App\Http\Controllers\Controller;
use App\Models\Siat\RegistroPuntoVenta;
use App\Models\Siat\SiatCui;
use App\Models\Sucursal;
use App\Services\CuisService;
use Illuminate\Http\Request;

class CuisController extends Controller
{


    public function index()
    {
        $cuis = SiatCui::all();
        return view('siat.cuis.index', compact('cuis'));
    }

    public function create()
    {
        $sucursales = Sucursal::all();
        return view('siat.cuis.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $cuisService = new CuisService();
        $sucursal = Sucursal::find($request->sucursal_id);
        $response = $cuisService->obtenerCuis(0,  $sucursal->codigo_fiscal);
        $respCrearCuis = $cuisService->createCuis($response, $request->sucursal_id);
        if ($respCrearCuis['status']) {
            if (isset($response->RespuestaCuis->mensajesList)) {
                if ($response->RespuestaCuis->mensajesList->codigo == 980) {
                    return redirect()->route('cuis.index');
                } else {
                    return response()->json(["status" => false, "error" => "No se pudo obtener el Cuis"]);
                }
            } else {
                return response()->json(["status" => false, "error" => "Sin Codigo de Respuesta"]);
            }
        }else{
           return $respCrearCuis;
        }
    }
}
