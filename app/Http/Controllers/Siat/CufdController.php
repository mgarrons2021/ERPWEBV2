<?php

namespace App\Http\Controllers\Siat;

use App\Http\Controllers\Controller;
use App\Models\Siat\SiatCufd;
use App\Models\Siat\SiatCui;
use App\Models\Sucursal;
use App\Services\CufdService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CufdController extends Controller
{

    public $cufdService;
    public function __construct()
    {
        $this->cufdService = new CufdService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fecha = Carbon::now()->toDateString();
        $cufds = SiatCufd::all();
        return view('siat.cufd.index', compact('cufds', 'fecha'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        return view('siat.cufd.create', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $codigoPuntoVenta = 0;
        $sucursal = Sucursal::find($request->sucursal_id);
        $cuis = SiatCui::where('sucursal_id', $sucursal->id)
            ->where('estado', 'V')
            ->orderBy('id', 'desc')
            ->first();

        $resCufd = $this->cufdService->obtenerCufd($codigoPuntoVenta, $sucursal->codigo_fiscal, $cuis->codigo_cui);

        $newCufd = SiatCufd::create([
            'estado' => "V",
            'codigo' => $resCufd->RespuestaCufd->codigo,
            'codigo_control' => $resCufd->RespuestaCufd->codigoControl,
            'direccion' => $resCufd->RespuestaCufd->direccion,
            'fecha_vigencia' => new Carbon($resCufd->RespuestaCufd->fechaVigencia),
            'fecha_generado' => Carbon::now()->toDateTimeString(),
            'sucursal_id' => $sucursal->id,
            'numero_factura' => 0
        ]);

        SiatCufd::where('estado','V')
        ->where('id','<>',$newCufd->id)
        ->where('sucursal_id',$sucursal->id)
        ->update(['estado'=>'N']);

        return redirect()->route('cufd.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $cufd = SiatCufd::find($id);
        $cufd->delete();

        return redirect()->route('siat.cufd.index');
    }
}
