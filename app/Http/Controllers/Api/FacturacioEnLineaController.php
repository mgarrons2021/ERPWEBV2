<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siat\SiatCui;
use App\Models\Siat\SiatCufd;
use App\Models\Siat\RegistroPuntoVenta;
use App\Services\CuisService;
use Illuminate\Support\Facades\DB;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatFactory;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioOperaciones;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionSincronizacion;



class FacturacioEnLineaController extends Controller
{

    public $config;

    public function __construct()
    {
        $this->config = new SiatConfig([
            'nombreSistema' => 'MAGNORESTv2',
            'codigoSistema' => '72422DD433BE8177DC71FE6',
            'nit'           => 166172023,
            'razonSocial'   => 'DONESCO S.R.L',
            'modalidad'     => ServicioSiat::MOD_ELECTRONICA_ENLINEA,
            'ambiente'      => ServicioSiat::AMBIENTE_PRUEBAS,
            'tokenDelegado'    => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjQyMkRENDMzQkU4MTc3REM3MUZFNiIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjcyNjA4MDAsImlhdCI6MTY2NTI0MDIyOCwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.5ZkQ6815VtUXK07ieWTBit6roArGNK2ZIq90W7TdGhzUnotYE7C31nSv-XrifFTSVrEKRgtwiNlDie8wdkrMJg',
            /* 'pubCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'certificado.pem',
          'privCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'llave_privada.pem', */
            'telefono'        => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'
        ]);
    }

    function obtenerCuisAPI(Request $request)
    {

        $codigoPuntoVenta = $request->codigoPuntoVenta;
        $codigoSucursal = $request->codigoSucursal;

        $response = $this->obtenerCuis($codigoPuntoVenta, $codigoSucursal);;

        CuisService::createCuis($response, $codigoSucursal);

        return $response;
    }

    function obtenerCufdAPI(Request $request)
    {
        $fecha = Carbon::now()->toDateString();
        $sucursal = Sucursal::where('codigo_fiscal',$request->codigoSucursal)->first();
        $codigoSucursal  = $request->codigoSucursal;
        $codigoPuntoVenta  = $request->codigoPuntoVenta;
        $sucursal_id = $request->sucursal_id;


        $cuis = SiatCui::where('sucursal_id', $codigoSucursal)->first();

        if (is_null($cuis)) {
            $response =  $this->obtenerCuis($codigoPuntoVenta, $codigoSucursal);
            $obtener_cui = SiatCui::create([
                'fecha_generado' => $fecha,
                'fecha_expiracion' =>  new Carbon($response->RespuestaCuis->fechaVigencia),
                'codigo_cui' => $response->RespuestaCuis->codigo,
                'sucursal_id' =>  $sucursal->id,
                'estado' => 'V' /* Obtenido */
            ]);
            $resCufd =  $this->obtenerCufd($codigoPuntoVenta, $codigoSucursal, $obtener_cui->codigo_cui, true);
        } else {
            $resCufd =  $this->obtenerCufd($codigoPuntoVenta, $codigoSucursal, $cuis->codigo_cui, true);
        }

         
        $guardar_cufd = SiatCufd::create([
            'codigo' => $resCufd->RespuestaCufd->codigo,
            'codigo_control' => $resCufd->RespuestaCufd->codigoControl,
            'direccion' => $resCufd->RespuestaCufd->direccion,
            'numero_factura'=> 0,
            'fecha_vigencia' => new Carbon($resCufd->RespuestaCufd->fechaVigencia),
            'fecha_generado' => $fecha,
            'sucursal_id' => $sucursal->id,
            'estado' => 'V' /* Obtenido */

        ]);

        return $resCufd;
    }

    function pruebasEmisionIndividual()
    {

        global $config, $sucursal, $documentoSector, $codigoActividad, $codigoProductoSin, $tipoFactura;

        foreach ([0, 1] as $puntoventa) {
            $resCuis     = obtenerCuis($puntoventa, $sucursal, true);
            $resCufd    = obtenerCufd($puntoventa, $sucursal, $resCuis->RespuestaCuis->codigo, true);

            for ($i = 0; $i < 125; $i++) {
                $factura = construirFactura($puntoventa, $sucursal, $config->modalidad, $documentoSector, $codigoActividad, $codigoProductoSin);
                $res = testFactura($sucursal, $puntoventa, $factura, $tipoFactura);
                print_r($res);
            }
            sleep(10);
        }
        die;
    }

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

    function sincronizarListaLeyendasFacturaAPI(Request $request)
    {
        $sucursal = 0;
        $count = 0;
        $puntoventa =0;
        $cuisService = new CuisService();
        $resCuis 	= $cuisService->obtenerCuis($puntoventa, $sucursal, true);
        $service     = new ServicioFacturacionSincronizacion($resCuis->RespuestaCuis->codigo);
        $service->setConfig((array)$this->config);
        $res = $service->sincronizarParametricaEventosSignificativos($sucursal, $puntoventa);
        return $res;
       
    }


    /*Funciones Auxiliares*/
    function obtenerCuis($codigoPuntoVenta, $codigoSucursal, $new = false)
    {
        $serviceCodigos = new ServicioFacturacionCodigos(null, null, $this->config->tokenDelegado);
        $serviceCodigos->debug = true;
        $serviceCodigos->setConfig((array)$this->config);
        $resCuis = $serviceCodigos->cuis($codigoPuntoVenta, $codigoSucursal);

        return $resCuis;
    }

    function obtenerCufd($codigoPuntoVenta, $codigoSucursal, $cuis, $new = false)
    {

        $serviceCodigos = new ServicioFacturacionCodigos(null, null, $this->config->tokenDelegado);
        $serviceCodigos->setConfig((array)$this->config);
        $serviceCodigos->cuis = $cuis;
        $resCufd = $serviceCodigos->cufd($codigoPuntoVenta, $codigoSucursal);

        return $resCufd;
    }

    function testFactura($sucursal, $puntoventa, SiatInvoice $factura, $tipoFactura)
    {
        global $config;

        $resCuis = obtenerCuis($puntoventa, $sucursal);
        $resCufd = obtenerCufd($puntoventa, $sucursal, $resCuis->RespuestaCuis->codigo);

        echo "Codigo CUIS: ", $resCuis->RespuestaCuis->codigo, "\n";
        echo "Codigo CUFD: ", $resCufd->RespuestaCufd->codigo, "\n";
        echo "Codigo Control: ", $resCufd->RespuestaCufd->codigoControl, "\n";

        $service = SiatFactory::obtenerServicioFacturacion($config, $resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo, $resCufd->RespuestaCufd->codigoControl);
        //$service = $config->modalidad == ServicioSiat::MOD_COMPUTARIZADA_ENLINEA ? 
        //	new ServicioFacturacionComputarizada($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo) :
        //	new ServicioFacturacionElectronica($resCuis->RespuestaCuis->codigo, $resCufd->RespuestaCufd->codigo);
        //$service->setConfig((array)$config);
        $service->codigoControl = $resCufd->RespuestaCufd->codigoControl;
        $res = $service->recepcionFactura($factura, SiatInvoice::TIPO_EMISION_ONLINE, $tipoFactura);
        test_log("RESULTADO RECEPCION FACTURA\n=============================");
        test_log($res);

        return $res;
    }

    function sincronizarTotalTipoEmisionAPI(Request $request)
    {
        $sucursal = 0;
        $count = 0;
        $puntoventa =0;
        $cuisService = new CuisService();
        $resCuis 	= $cuisService->obtenerCuis($puntoventa, $sucursal, true);
       /*  dd($resCuis); */
        $service     = new ServicioFacturacionSincronizacion($resCuis->RespuestaCuis->codigo);
        $service->setConfig((array)$this->config);
        $res = $service->sincronizarParametricaUnidadMedida($sucursal, $puntoventa);
        return $res;
       
    }
}
