<?php

namespace App\Http\Controllers\Siat;

use App\Http\Controllers\Controller;
use App\Models\siat\DocumentoIdentidad;
use App\Models\Siat\EventoSignificativo;
use App\Models\Siat\LeyendaFactura;
use App\Models\siat\ListadoPais;
use App\Models\Siat\ListadoTotalActividad;
use App\Models\Siat\MensajeServicio;
use App\Models\Siat\MetodoPago;
use App\Models\Siat\MotivoAnulacion;
use App\Models\Siat\ProductoServicio;
use Illuminate\Http\Request;
use App\Models\Sucursal;
use App\Services\CuisService;
use App\Models\Siat\RegistroPuntoVenta;
use App\Models\Siat\TipoDocumentoSector;
use App\Models\Siat\TipoEmision;
use App\Models\Siat\TipoFactura;
use App\Models\Siat\TipoMoneda;
use App\Models\Siat\UnidadMedida;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioOperaciones;

class RegistrarPuntoVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $config;

    public function __construct()
    {
        $this->config = new SiatConfig([
            'nombreSistema' => 'MAGNOREST',
            'codigoSistema' => '722907F2BAECC0B26025FE7',
            'nit'           => 166172023,
            'razonSocial'   => 'DONESCO S.R.L',
            'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
            'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
            'tokenDelegado'    => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjI5MDdGMkJBRUNDMEIyNjAyNUZFNyIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjQ1ODI0MDAsImlhdCI6MTY2MDgyOTA0NCwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.8ubSTM8oYEuY7pHiNQYbNj6I87koRUqzOqsQ341VMKwA8Y_A9nh_qA4ttCdY-6HywevMQ4Ov64I-w7S3k47NYw',
            /* 'pubCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'certificado.pem',
          'privCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'llave_privada.pem', */
            'telefono'        => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'
        ]);
    }

    public function index()
    {
        $puntos_ventas = RegistroPuntoVenta::all();
        $eventos_significativos = EventoSignificativo::all();
        $motivos_anulaciones = MotivoAnulacion::all();
        $tipos_facturas = TipoFactura::all();
        $documentos_sectores = TipoDocumentoSector::all();
        $documentos_identidad = DocumentoIdentidad::all();
        $leyendas_factura = LeyendaFactura::all();
        $listados_paises = ListadoPais::all();
        $mensajes_servicios = MensajeServicio::all();
        $metodos_pagos = MetodoPago::all();
        $productos_servicios = ProductoServicio::all();
        $tipos_emisiones = TipoEmision::all();
        $tipos_facturas = TipoFactura::all();
        $tipos_monedas = TipoMoneda::all();
        $unidades_medidas = UnidadMedida::all();
        return view('siat.punto_venta.index', compact('puntos_ventas', 'eventos_significativos', 'motivos_anulaciones', 'tipos_facturas', 'documentos_sectores', 'documentos_identidad', 'leyendas_factura', 'listados_paises', 'mensajes_servicios', 'metodos_pagos','productos_servicios','tipos_emisiones','tipos_facturas','tipos_monedas','unidades_medidas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sucursales = Sucursal::all();
        return view('siat.punto_venta.create', compact('sucursales'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    function registroPuntoVentaAPI(Request $request)
    {

        $codigoSucursal = $request->codigoSucursal;
        $nombrePuntoVenta = $request->nombrePuntoVenta;



        $resCuis = $this->obtenerCuis(null, $codigoSucursal, true);
        $service = new ServicioOperaciones();
        $service->setConfig((array)$this->config);
        $service->cuis = $resCuis->RespuestaCuis->codigo;

        $res = $service->registroPuntoVenta($codigoSucursal, 2, $nombrePuntoVenta);

        $sucursal = Sucursal::find($codigoSucursal);

        $registroPuntoVenta = new RegistroPuntoVenta();
        $registroPuntoVenta->codigo_punto_venta = $res->RespuestaRegistroPuntoVenta->codigoPuntoVenta;
        $registroPuntoVenta->sucursal_id = $sucursal->id;

        $registroPuntoVenta->save();
        return  $res;
    }



    public function store(Request $request)
    {
        $nombrePuntoVenta =  Sucursal::select('nombre')
            ->where('sucursals.id', '=', $request->sucursal_id)
            ->first();

        $cuisService = new CuisService();

        $response = $cuisService->obtenerCuis(null, $request->sucursal_id, true);
        $service = new ServicioOperaciones();
        $service->setConfig((array)$this->config);

        $service->cuis = $response->RespuestaCuis->codigo;
        $res = $service->registroPuntoVenta($request->sucursal_id, 2, $nombrePuntoVenta->nombre);

        $punto_venta = new RegistroPuntoVenta();
        $punto_venta->codigo_punto_venta = $res->RespuestaRegistroPuntoVenta->codigoPuntoVenta;
        $punto_venta->sucursal_id = $request->sucursal_id;
        $punto_venta->save();

        return redirect()->route('puntos_ventas.index');
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
        //
    }
}
