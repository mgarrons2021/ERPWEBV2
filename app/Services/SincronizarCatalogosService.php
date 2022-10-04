<?php

namespace App\Services;

use App\Models\Siat\LeyendaFactura;
use App\Models\Siat\ListadoTotalActividad;
use App\Models\siat\SiatFechaHora;
use App\Models\Siat\TipoDocumentoSector;
use App\Models\Siat\ProductoServicio;
use App\Models\Siat\EventoSignificativo;
use App\Models\siat\ListadoPais;
use App\Models\Siat\MotivoAnulacion;
use Carbon\Carbon;
use App\Models\siat\DocumentoIdentidad;
use App\Models\Siat\MensajeServicio;
use App\Models\Siat\MetodoPago;
use App\Models\Siat\TipoEmision;
use App\Models\Siat\TipoFactura;
use App\Models\Siat\TipoHabitacion;
use App\Models\Siat\TipoMoneda;
use App\Models\Siat\TipoPuntoVenta;
use App\Models\Siat\UnidadMedida;
use Illuminate\Support\Facades\DB;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;

class SincronizarCatalogosService
{

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
            'tokenDelegado'    => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJET05FU0NPXzAyMyIsImNvZGlnb1Npc3RlbWEiOiI3MjI5MDdGMkJBRUNDMEIyNjAyNUZFNyIsIm5pdCI6Ikg0c0lBQUFBQUFBQUFETTBNek0wTnpJd01nWUE3bHFjcHdrQUFBQT0iLCJpZCI6NTE5NjgyLCJleHAiOjE2NjcxNzQ0MDAsImlhdCI6MTY2NDcxMzUxOSwibml0RGVsZWdhZG8iOjE2NjE3MjAyMywic3Vic2lzdGVtYSI6IlNGRSJ9.dYOJ0EpBGBy_znNjIlkw283FvQif6qFx_x6t8sh7MQ4DEJmLL_bsQNivh2MYg7DAZDK4aRKn8fwu7HEqpEWhNA',
            /* 'pubCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'certificado.pem',
          'privCert'		=> MOD_SIAT_DIR . SB_DS . 'certs' . SB_DS . 'terminalx' . SB_DS . 'llave_privada.pem', */
            'telefono'        => '34345435',
            'ciudad'        => 'SANTA CRUZ GC'
        ]);
    }

    /* LISTADO TOTAL DE ACTIVIDADES - ALREADY-TESTED*/
    public function create_listado_actividades($response)
    {
        if ($response->RespuestaListaActividades->transaccion == true) {
            $listado_actividad =  DB::select('select codigo_caeb from siat_listados_actividades');
            if (sizeof($listado_actividad) == 0) {
                $create_listados = ListadoTotalActividad::create([
                    'codigo_caeb' => $response->RespuestaListaActividades->listaActividades->codigoCaeb,
                    'descripcion' => $response->RespuestaListaActividades->listaActividades->descripcion,
                    'tipo_actividad' => $response->RespuestaListaActividades->listaActividades->tipoActividad
                ]);
            } else {
                return response()->json(["error" => "Ya hay datos registrados"]);
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }

    /* FECHA HORA ACTUAL ALREADY-TESTED */
    public function create_fecha_hora_actual($response)
    {
        if ($response->RespuestaFechaHora->transaccion == true) {
            $create_fecha_hora = SiatFechaHora::create([
                'fecha_hora' => $response->RespuestaFechaHora->fechaHora,
            ]);
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }


    /* SINCRONIZAR LISTADO LEYENDAS ALREADY-TESTED */
    public function create_lista_leyendas($response)
    {
        if ($response->RespuestaListaParametricasLeyendas->transaccion == true) {
            $cantidad_registros_response = count($response->RespuestaListaParametricasLeyendas->listaLeyendas);
            $cantidad_registros_db = LeyendaFactura::count();
            $fecha = Carbon::now()->toDateString();
            if ($cantidad_registros_db < $cantidad_registros_response) {
                DB::table('siat_leyendas_facturas')->delete();
                foreach ($response->RespuestaListaParametricasLeyendas->listaLeyendas as $listado) {
                    $create_invoice_leyend = LeyendaFactura::create([
                        'fecha' => $fecha,
                        'codigo_actividad' => $listado->codigoActividad,
                        'descripcion_leyenda' => $listado->descripcionLeyenda,
                    ]);
                }

                return response()->json(["msj" => "Registro insertados sactisfactoriamente"]);
            } else {
                return response()->json(["msj" => "No hay mas registro para insertar"]);
            }
        } else {
            return response()->json(["msj" => "No se pudo obtener las leyendas"]);
        }
    }
    /* CREAR LISTADO MENSAJE DE SERVICIOS  ALREADY-TESTED*/
    public function create_mensajes_servicios($response)
    {
        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion == true) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $listado) {
                $mensaje_servicio = MensajeServicio::where('codigo_clasificador', $listado->codigoClasificador)->first();
                if (is_null($mensaje_servicio)) {
                    $create_service_message = MensajeServicio::create([
                        'codigo_clasificador' => $listado->codigoClasificador,
                        'descripcion' => $listado->descripcion,
                    ]);
                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }

    /*TESTEADO*/
    public function create_productos_servicios($response)
    {
        if ($response->RespuestaListaProductos->transaccion == true) {
            $cantidad_registros_db = ProductoServicio::count();
            $cantidad_registros_response = count($response->RespuestaListaProductos->listaCodigos);
            /* dd($cantidad_registros_response); */
            if ($cantidad_registros_db < $cantidad_registros_response) {
                DB::table('siat_productos_servicios')->delete();
                foreach ($response->RespuestaListaProductos->listaCodigos as $listado) {
                    $create_producto_servicio = ProductoServicio::create([
                        'codigo_actividad' => $listado->codigoActividad,
                        'codigo_producto' => $listado->codigoProducto,
                        'descripcion_producto' => $listado->descripcionProducto,
                    ]);
                }
                return response()->json(["msj" => "Registro insertados satisfactoriamente"]);
            } else {
                return response()->json(["msj" => "No hay mas registro para insertar"]);
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }

    /*Testeado*/
    public function create_eventos_significativos($response)
    {
        if ($response->RespuestaListaParametricas->transaccion == true) {
            $cantidad_registros_db = ProductoServicio::count();
            $cantidad_registros_response = count($response->RespuestaListaParametricas->listaCodigos);
            if ($cantidad_registros_db < $cantidad_registros_response) {
                DB::table('siat_eventos_significativos')->delete();
                foreach ($response->RespuestaListaParametricas->listaCodigos as $listado) {
                    $create_signifficant_event = EventoSignificativo::create([
                        'codigo_clasificador' => $listado->codigoClasificador,
                        'descripcion'  => $listado->descripcion,
                    ]);
                }
                return response()->json(["msj" => "Registro insertados satisfactoriamente"]);
            } else {
                return response()->json(["msj" => "No hay mas registro para insertar"]);
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }

    /*ALREADY TESTED*/
    public function create_motivo_anulacion($response)
    {
        if ($response->RespuestaListaParametricas->transaccion) {
            $cantidad_registros_db = MotivoAnulacion::count();
            $cantidad_registros_response = count($response->RespuestaListaParametricas->listaCodigos);
            if ($cantidad_registros_db < $cantidad_registros_response) {
                DB::table('siat_motivos_anulaciones')->delete();
                foreach ($response->RespuestaListaParametricas->listaCodigos as $listado) {
                    $create_motivo_anulacion = MotivoAnulacion::create([
                        'codigo_clasificador' => $listado->codigoClasificador,
                        'descripcion' => $listado->descripcion
                    ]);
                }
                return response()->json(["msj" => "Registro insertados satisfactoriamente"]);
            } else {
                return response()->json(["error" => "Peticion Fallida Datos no Registrados"]);
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }

    /*ALREADY TESTED*/
    public function create_listado_paises($response)
    {
        if ($response->RespuestaListaParametricas->transaccion == true) {
            $cantidad_registros_db = ListadoPais::count();
            $cantidad_registros_response = count($response->RespuestaListaParametricas->listaCodigos);
            if ($cantidad_registros_db < $cantidad_registros_response) {
                DB::table('siat_listados_paises')->delete();
                foreach ($response->RespuestaListaParametricas->listaCodigos as $listado) {
                    $create_listado_paises = ListadoPais::create([
                        'codigo_clasificador' => $listado->codigoClasificador,
                        'descripcion' => $listado->descripcion,
                    ]);
                }
            } else {
                return response()->json(["error" => "Peticion Fallida Datos no Registrados"]);
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }

    /*Testeado*/
    public function create_documento_identidad($response)
    {
        if ($response->RespuestaListaParametricas->transaccion == true) {
            $cantidad_registros_db = MotivoAnulacion::count();
            $cantidad_registros_response = count($response->RespuestaListaParametricas->listaCodigos);
            if ($cantidad_registros_db < $cantidad_registros_response) {
                DB::table('siat_documentos_identidad')->delete();
                foreach ($response->RespuestaListaParametricas->listaCodigos as $listado) {
                    $create_identity_document = DocumentoIdentidad::create([
                        'codigo_clasificador' => $listado->codigoClasificador,
                        'descripcion' => $listado->descripcion,
                    ]);
                }
                return response()->json(["msj" => "Registro insertados satisfactoriamente"]);
            } else {
                return response()->json(["msj" => "No hay datos nuevos para insertar"]);
            }
        } else {
            return response()->json(["error" => "Peticion Fallida"]);
        }
    }


    /* ALREADY TESTED*/
    public function createTiposDocumentosSector($response)
    {
        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion == true) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $tipoDocumentoSector = TipoDocumentoSector::where('codigoClasificador', $codigo->codigoClasificador)->first();

                if (is_null($tipoDocumentoSector)) {
                    $tipoDocumentoSector = new TipoDocumentoSector();
                    $tipoDocumentoSector->codigoClasificador = $codigo->codigoClasificador;
                    $tipoDocumentoSector->descripcion = $codigo->descripcion;
                    $tipoDocumentoSector->save();
                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Tipos de Documentos de Sector de Impuestos"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }

    /*ALREADY TESTED*/
    public function createTiposEmisiones($response)
    {
        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $tipoEmision = TipoEmision::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($tipoEmision)) {
                    $tipoEmision = new TipoEmision();
                    $tipoEmision->codigoClasificador = $codigo->codigoClasificador;
                    $tipoEmision->descripcion = $codigo->descripcion;
                    $tipoEmision->save();

                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Tipos de Emisiones"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }

    /*¨Ya esta Probado*/
    public function createTiposHabitaciones($response)
    {
        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $tipoHabitacion = TipoHabitacion::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($tipoHabitacion)) {
                    $tipoHabitacion = new TipoHabitacion();
                    $tipoHabitacion->codigoClasificador = $codigo->codigoClasificador;
                    $tipoHabitacion->descripcion = $codigo->descripcion;
                    $tipoHabitacion->save();

                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Tipos de Habitaciones"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }

    /*¨Ya esta Probado*/
    public function createMetodosPagos($response)
    {
        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $metodoPago = MetodoPago::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($metodoPago)) {
                    $metodoPago = new MetodoPago();
                    $metodoPago->codigoClasificador = $codigo->codigoClasificador;
                    $metodoPago->descripcion = $codigo->descripcion;
                    $metodoPago->save();

                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Metodos de Pagos"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }

    /*¨Ya esta Probado*/
    public function createTiposMonedas($response)
    {

        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $tipoMoneda = TipoMoneda::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($tipoMoneda)) {
                    $tipoMoneda = new TipoMoneda();
                    $tipoMoneda->codigoClasificador = $codigo->codigoClasificador;
                    $tipoMoneda->descripcion = $codigo->descripcion;
                    $tipoMoneda->save();

                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Tipos de Monedas"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }

    /* ALREADY TESTED */

    public function createTiposPuntosVentas($response)
    {

        $sw = false;
        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $tipoPuntoVenta = TipoPuntoVenta::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($tipoPuntoVenta)) {
                    $tipoPuntoVenta = new TipoPuntoVenta();
                    $tipoPuntoVenta->codigoClasificador = $codigo->codigoClasificador;
                    $tipoPuntoVenta->descripcion = $codigo->descripcion;
                    $tipoPuntoVenta->save();

                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Tipos de Ventas"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }
    /* ALREADY TESTED */
    public function createTiposFacturas($response)
    {
        $sw = false;

        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $tipoFactura = TipoFactura::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($tipoFactura)) {
                    $tipoFactura = new TipoFactura();
                    $tipoFactura->codigoClasificador = $codigo->codigoClasificador;
                    $tipoFactura->descripcion = $codigo->descripcion;
                    $tipoFactura->save();

                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener los Tipos de Facturas"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }
    /* ALREADY TESTED */
    public function createUnidadesMedidas($response)
    {
        $sw = false;

        if ($response->RespuestaListaParametricas->transaccion) {
            foreach ($response->RespuestaListaParametricas->listaCodigos as $codigo) {
                $unidadMedida = UnidadMedida::where('codigoClasificador', $codigo->codigoClasificador)->first();
                if (is_null($unidadMedida)) {
                    $unidadMedida = new UnidadMedida();
                    $unidadMedida->codigoClasificador = $codigo->codigoClasificador;
                    $unidadMedida->descripcion = $codigo->descripcion;
                    $unidadMedida->save();
                    $sw = true;
                }
            }
        } else {
            return response()->json(["error" => "Error al tratar de obtener las Unidades de Medida"]);
        }
        return  $sw ? response()->json([
            "success" => "Datos nuevos agregados satisfactorios"
        ]) : response()->json([
            "success" => "No hay datos nuevos para agregar"
        ]);
    }
}
