<?php

namespace App\Services;


use Carbon\Carbon;
use App\Models\Sucursal;
use App\Models\Siat\SiatCui;
use App\Models\Siat\SiatCufd;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatFactory;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\DocumentTypes;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\Hotel;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\TasaCero;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\Hospitales;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SiatInvoice;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\CompraVenta;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\InvoiceDetail;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ServicioBasico;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\SectorEducativo;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaHotel;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\EntidadFinanciera;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaTasaCero;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ComercialExportacion;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaHospitales;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaCompraVenta;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaServicioBasico;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ServicioTuristicoHospedaje;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaSectorEducativo;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ComercialExportacionServicio;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaEntidadFinanciera;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaComercialExportacion;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaServicioTuristicoHospedaje;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Invoices\ElectronicaComercialExportacionServicio;



class EmisionIndividualService
{

    public $cuisService;
    public $cufdService;
    public $configService;

    public function __construct()
    {
        $this->cuisService = new CuisService();
        $this->cufdService = new CufdService();
        $this->configService = new ConfigService();
    }

    

    function construirFactura3($codigoPuntoVenta = 0, $codigoSucursal = 0, $modalidad = 0, $documentoSector = 1, $codigoActividad = '620100', $codigoProductoSin = '', $dataFactura = null)
    {
        /*  dd($dataFactura); */
        $subTotal = 0;
        $factura = null;
        $detailClass = InvoiceDetail::class;
        if ($modalidad == ServicioSiat::MOD_ELECTRONICA_ENLINEA) {
            if ($documentoSector == DocumentTypes::FACTURA_COMPRA_VENTA)
                $factura = new ElectronicaCompraVenta();
        } else {
            if ($documentoSector == DocumentTypes::FACTURA_COMPRA_VENTA)
                $factura = new CompraVenta();
        }
        for ($i = 0; $i < sizeof($dataFactura['detalle_venta']); $i++) {
            $detalle = new $detailClass();
            $detalle->cantidad                = $dataFactura['detalle_venta'][$i]->cantidad;
            $detalle->actividadEconomica    = $codigoActividad;
            $detalle->codigoProducto        = $dataFactura['detalle_venta'][$i]->plato_id;
            $detalle->codigoProductoSin        = $codigoProductoSin;
            $detalle->descripcion            = $dataFactura['detalle_venta'][$i]->plato->nombre;
            $detalle->precioUnitario        = $dataFactura['detalle_venta'][$i]->precio;
            $detalle->montoDescuento        = $dataFactura['detalle_venta'][$i]->descuento;
            $detalle->subTotal                = $dataFactura['detalle_venta'][$i]['subtotal'] - $dataFactura['detalle_venta'][$i]['descuento'];
            $subTotal += $detalle->subTotal;
            $factura->detalle[] = $detalle;
        }
        $factura->cabecera->razonSocialEmisor    = $this->configService->config->razonSocial;
        $factura->cabecera->municipio            = 'Santa Cruz de la Sierra';
        $factura->cabecera->telefono            = '78555410';
        $factura->cabecera->numeroFactura        = $dataFactura['venta']['numero_factura'];
        $factura->cabecera->codigoSucursal        = $dataFactura['sucursal']['codigo_fiscal'];
        $factura->cabecera->direccion            = $dataFactura['sucursal']['direccion'];
        $factura->cabecera->codigoPuntoVenta    = $codigoPuntoVenta;
        $factura->cabecera->fechaEmision        =  date("Y-m-d\TH:i:s.v", strtotime($dataFactura['venta']['created_at']));
        $factura->cabecera->nombreRazonSocial    = $dataFactura['cliente']['nombre'];
        $factura->cabecera->codigoTipoDocumentoIdentidad    = $dataFactura['venta']->documento_identidad->codigo_clasificador; //Tipo de Documento (Ci,Nit,PassPort etc) 
        $factura->cabecera->numeroDocumento        = $dataFactura['cliente']['ci_nit'];
        $factura->cabecera->complemento             = $dataFactura['cliente']['complemento'];
        $factura->cabecera->codigoCliente        = $dataFactura['cliente']['id']; //Codigo Unico Asignado por el sistema de facturacion (ID DEL CLIENTE)
        $factura->cabecera->codigoMetodoPago    = 1;
        $factura->cabecera->montoTotal            = $dataFactura['venta']['total_neto'];
        $factura->cabecera->montoTotalMoneda    = $factura->cabecera->montoTotal;
        $factura->cabecera->montoTotalSujetoIva    = $factura->cabecera->montoTotal;
        $factura->cabecera->descuentoAdicional    = 0;
        $factura->cabecera->codigoMoneda        = 1; //BOLIVIANO
        $factura->cabecera->tipoCambio            = 1;
        $factura->cabecera->cuf            = $dataFactura['venta']['cuf'];
        $factura->cabecera->usuario              = $dataFactura['user']['name'] . " " . $dataFactura['user']['apellido'];
        return $factura;
    }

    function construirFactura2($codigoPuntoVenta = 0, $codigoSucursal = 0, $modalidad = 0, $documentoSector = 1, $codigoActividad = '620100', $codigoProductoSin = '', $dataFactura = null)
    {
        $subTotal = 0;
        $factura = null;
        $detailClass = InvoiceDetail::class;

        if ($modalidad == ServicioSiat::MOD_ELECTRONICA_ENLINEA) {
            if ($documentoSector == DocumentTypes::FACTURA_COMPRA_VENTA)
                $factura = new ElectronicaCompraVenta();
        } else {
            if ($documentoSector == DocumentTypes::FACTURA_COMPRA_VENTA)
                $factura = new CompraVenta();
        }

        for ($i = 0; $i < sizeof($dataFactura['detalle_venta']); $i++) {
            $detalle = new $detailClass();
            $detalle->cantidad                = $dataFactura['detalle_venta'][$i]['cantidad'];
            $detalle->actividadEconomica    = $codigoActividad;
            $detalle->codigoProducto        = $dataFactura['detalle_venta'][$i]['plato_id'];
            $detalle->codigoProductoSin        = $codigoProductoSin;
            $detalle->descripcion            = $dataFactura['detalle_venta'][$i]['plato'];
            $detalle->precioUnitario        = $dataFactura['detalle_venta'][$i]['costo'];
            $detalle->montoDescuento        = $dataFactura['detalle_venta'][$i]['descuento'];
            $detalle->subTotal                = $dataFactura['detalle_venta'][$i]['subtotal'] - $dataFactura['detalle_venta'][$i]['descuento'];

            $subTotal += $detalle->subTotal;
            $factura->detalle[] = $detalle;
        }
        $factura->cabecera->razonSocialEmisor    = $this->configService->config->razonSocial;
        $factura->cabecera->municipio            = 'Santa Cruz de la Sierra';
        $factura->cabecera->telefono            = '78555410';
        $factura->cabecera->numeroFactura        = $dataFactura['venta']['numero_factura'];
        $factura->cabecera->codigoSucursal        = $dataFactura['sucursal']['codigo_fiscal'];
        $factura->cabecera->direccion            = $dataFactura['sucursal']['direccion'];
        $factura->cabecera->codigoPuntoVenta    = $codigoPuntoVenta;
        $factura->cabecera->fechaEmision        = date("Y-m-d\TH:i:s.v", strtotime($dataFactura['venta']['created_at']));
        $factura->cabecera->nombreRazonSocial    = $dataFactura['cliente']['nombre'];
        $factura->cabecera->codigoTipoDocumentoIdentidad    = $dataFactura['venta']->documento_identidad->codigo_clasificador; //NIT 
        $factura->cabecera->numeroDocumento        = $dataFactura['cliente']['ci_nit'];
        $factura->cabecera->complemento             = $dataFactura['cliente']['complemento'];
        $factura->cabecera->codigoCliente        = $dataFactura['cliente']['id']; //Codigo Unico Asignado por el sistema de facturacion (ID DEL CLIENTE)
        $factura->cabecera->codigoMetodoPago    = 1;
        $factura->cabecera->montoTotal            = $dataFactura['venta']['total_neto'];
        $factura->cabecera->montoTotalMoneda    = $factura->cabecera->montoTotal;
        $factura->cabecera->montoTotalSujetoIva    = $factura->cabecera->montoTotal;
        $factura->cabecera->descuentoAdicional    = 0;
        $factura->cabecera->codigoMoneda        = 1; //BOLIVIANO
        $factura->cabecera->tipoCambio            = 1;
        $factura->cabecera->cuf            = $dataFactura['venta']['cuf'];
        $factura->cabecera->usuario              = $dataFactura['user']['name'] . " " . $dataFactura['user']['apellido'];
        return $factura;
    }

    function construirFactura($codigoPuntoVenta = 0, $codigoSucursal = 0, $modalidad = 0, $documentoSector = 1, $codigoActividad = '620100', $codigoProductoSin = '')
    {

        $subTotal = 0;
        $factura = null;
        $detailClass = InvoiceDetail::class;
        //dd($modalidad);
        if ($modalidad == ServicioSiat::MOD_ELECTRONICA_ENLINEA) {
            if ($documentoSector == DocumentTypes::FACTURA_COMPRA_VENTA)
                $factura = new ElectronicaCompraVenta();
        } else {
            if ($documentoSector == DocumentTypes::FACTURA_COMPRA_VENTA)
                $factura = new CompraVenta();
        }

        for ($i = 0; $i < 2; $i++) {
            $detalle = new $detailClass();
            $detalle->cantidad                = 1;
            $detalle->actividadEconomica    = $codigoActividad;
            $detalle->codigoProducto        = 'D001-' . rand(1, 4000);
            $detalle->codigoProductoSin        = $codigoProductoSin;
            $detalle->descripcion            = 'Nombre del producto #0' . ($i + 1);
            $detalle->precioUnitario        = 10 * rand(1, 4000);
            $detalle->montoDescuento        = 0;
            $detalle->subTotal                = $detalle->cantidad * $detalle->precioUnitario;
            if (in_array($documentoSector, [DocumentTypes::FACTURA_COMERCIAL_EXPORTACION])) {
                $detalle->codigoNandina = '0909610000';
            } elseif (in_array($documentoSector, [DocumentTypes::FACTURA_SERVICIO_TURISTICO, DocumentTypes::FACTURA_HOTELES])) {
                $detalle->codigoTipoHabitacion = '10';
                $detalle->detalleHuespedes = '[{"nombreHuesped":"Juan Perez","documentoIdentificacion":"44864646","codigoPais":"1"}]';
            } elseif ($documentoSector == DocumentTypes::FACTURA_HOSPITALES) {
                $detalle->especialidad = 'Traumatologia';
                $detalle->especialidadDetalle = 'Reduccion de fractura';
                $detalle->nroQuirofanoSalaOperaciones = 2;
                $detalle->especialidadMedico = 'Traumatologia';
                $detalle->nombreApellidoMedico = 'Alguien XXX';
                $detalle->nitDocumentoMedico = 1020703023;
                $detalle->nroMatriculaMedico = '312312ASDAS';
                $detalle->nroFacturaMedico = rand(1, 6000);
            }
            $subTotal += $detalle->subTotal;
            $factura->detalle[] = $detalle;
        }
        $factura->cabecera->razonSocialEmisor    = $this->configService->config->razonSocial;
        $factura->cabecera->municipio            = 'La Paz';
        $factura->cabecera->telefono            = '88867523';
        $factura->cabecera->numeroFactura        = rand(1, 1000);
        $factura->cabecera->codigoSucursal        = $codigoSucursal;
        $factura->cabecera->direccion            = 'Pedro Kramer #109';
        $factura->cabecera->codigoPuntoVenta    = $codigoPuntoVenta;
        $factura->cabecera->fechaEmision        = date('Y-m-d\TH:i:s.v');
        $factura->cabecera->nombreRazonSocial    = 'Perez';
        $factura->cabecera->codigoTipoDocumentoIdentidad    = 1; //CI - CEDULA DE IDENTIDAD
        $factura->cabecera->numeroDocumento        = 2287567;
        $factura->cabecera->codigoCliente        = 'CC-2287567';
        $factura->cabecera->codigoMetodoPago    = 1;
        $factura->cabecera->montoTotal            = $subTotal;
        $factura->cabecera->montoTotalMoneda    = $factura->cabecera->montoTotal;
        $factura->cabecera->montoTotalSujetoIva    = $factura->cabecera->montoTotal;
        $factura->cabecera->descuentoAdicional    = 0;
        $factura->cabecera->codigoMoneda        = 1; //BOLIVIANO

        $factura->cabecera->tipoCambio            = 1;
        $factura->cabecera->usuario                = 'MonoBusiness User 01';

        if ($documentoSector == DocumentTypes::FACTURA_COMERCIAL_EXPORTACION) {
            $factura->cabecera->montoDetalle = $factura->cabecera->montoTotal;
            $factura->cabecera->codigoMoneda = 2; //USD
            $factura->cabecera->tipoCambio = 6.86;
            $factura->cabecera->direccionComprador = 'Av. Los Tajibos';
            $factura->cabecera->incoterm = 'CIF';
            $factura->cabecera->incotermDetalle = 'CIF-WEBEX';
            $factura->cabecera->puertoDestino = 'Arica';
            $factura->cabecera->lugarDestino = 'Chile';
            $factura->cabecera->codigoPais = '100';
            $factura->cabecera->costosGastosNacionales = '[]';
            $factura->cabecera->totalGastosNacionalesFob = $factura->cabecera->montoDetalle;
            $factura->cabecera->costosGastosInternacionales = '[]';
            $factura->cabecera->totalGastosInternacionales = 0;
            $factura->cabecera->montoTotalMoneda = $factura->cabecera->montoDetalle + $factura->cabecera->totalGastosInternacionales;
            $factura->cabecera->montoTotal = $factura->cabecera->montoTotalMoneda * $factura->cabecera->tipoCambio;
            $factura->cabecera->montoTotalSujetoIva = 0;
            $factura->cabecera->numeroDescripcionPaquetesBultos = 'NINGUNA';
            $factura->cabecera->informacionAdicional = 'NINGUNA';
        } elseif ($documentoSector == DocumentTypes::FACTURA_COM_EXPORT_SERVICIOS) {
            $factura->cabecera->direccionComprador = 'Av. Los Tajibos';
            $factura->cabecera->lugarDestino = 'Chile';
            $factura->cabecera->codigoPais = '100';
            $factura->cabecera->montoTotalSujetoIva = 0;
            $factura->cabecera->informacionAdicional = 'NINGUNA';
        } elseif (in_array($documentoSector, [DocumentTypes::FACTURA_SERVICIO_TURISTICO, DocumentTypes::FACTURA_HOTELES])) {
            if ($documentoSector == DocumentTypes::FACTURA_SERVICIO_TURISTICO)
                $factura->cabecera->montoTotalSujetoIva = 0;

            $factura->cabecera->razonSocialOperadorTurismo = 'TURISMO LA PAZ';
            $factura->cabecera->cantidadHuespedes = 3;
            $factura->cabecera->cantidadHabitaciones = 1;
            $factura->cabecera->cantidadMayores = 2;
            $factura->cabecera->cantidadMenores = 1;
            $factura->cabecera->fechaIngresoHospedaje = date('Y-m-d\TH:i:s.v', time() + 63500);
        } elseif ($documentoSector == DocumentTypes::FACTURA_SECTOR_EDUCATIVO) {
            $factura->cabecera->nombreEstudiante = 'Pepito Perez';
            $factura->cabecera->periodoFacturado = 'ABRIL ' . date('Y');
        } elseif ($documentoSector == DocumentTypes::FACTURA_HOSPITALES) {
            $factura->cabecera->modalidadServicio = 'Post Operatorio';
        } elseif ($documentoSector == DocumentTypes::FACTURA_SERV_BASICOS) {
            $factura->cabecera->mes     = date('m');
            $factura->cabecera->gestion = date('Y');
            $factura->cabecera->ciudad    = 'La Paz';
            $factura->cabecera->zona    = 'Zona Central';
            $factura->cabecera->numeroMedidor    = '34234';
            $factura->cabecera->domicilioCliente    = 'Direccion X';
            $factura->cabecera->consumoPeriodo        = $factura->cabecera->montoTotal;
            $factura->cabecera->beneficiarioLey1886 = 0;
            $factura->cabecera->montoDescuentoLey1886    = 0;
            $factura->cabecera->montoDescuentoTarifaDignidad = 0;
            $factura->cabecera->tasaAseo = 5;
            $factura->cabecera->tasaAlumbrado = 3;
            $factura->cabecera->ajusteNoSujetoIva = 0;
            $factura->cabecera->detalleAjusteNoSujetoIva = null;
            $factura->cabecera->montoTotal += $factura->cabecera->tasaAseo + $factura->cabecera->tasaAlumbrado;
            $factura->cabecera->montoTotalMoneda = $factura->cabecera->montoTotal;
        }
        return $factura;
    }

    function testFactura($sucursal, $puntoventa, SiatInvoice $factura, $tipoFactura)
    {
        $fecha_actual = Carbon::now();
        $sucursal_DB = Sucursal::where('codigo_fiscal', $sucursal)->first();

        $cuis = SiatCui::where('sucursal_id', $sucursal_DB->id)
            ->where('estado', 'V')
            ->orderBy('id', 'desc')
            ->first();

        $cufd = SiatCufd::where('sucursal_id', $sucursal_DB->id)
            ->whereDate('fecha_vigencia', '>=', $fecha_actual)
            ->orderBy('id', 'desc')
            ->first();

        $service = SiatFactory::obtenerServicioFacturacion($this->configService->config, $cuis->codigo_cui, $cufd->codigo, $cufd->codigo_control);
        $service->codigoControl = $cufd->codigo_control;
        $res = $service->recepcionFactura($factura, SiatInvoice::TIPO_EMISION_ONLINE, $tipoFactura);
        return $res;
    }

    function test_log($data, $destFile = null)
    {
        $filename = __DIR__ . '/nit-' . $this->configService->config->nit . ($destFile ? '-' . $destFile : '') . '.log';
        $fh = fopen($filename, is_file($filename) ? 'a+' : 'w+');
        fwrite($fh, sprintf("[%s]#\n%s\n", date('Y-m-d H:i:s'), print_r($data, 1)));
        fclose($fh);
        print_r($data);
    }
}
