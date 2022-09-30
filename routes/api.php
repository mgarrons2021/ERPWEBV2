<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AutorizacionController;
use App\Models\CategoriaPlato;
use App\Models\Compra;
use App\Models\DetalleVenta;
use App\Models\Plato;
use App\Models\TurnoIngreso;
use App\Models\Venta;
use Carbon\Carbon;
use App\Http\Controllers\Api\AuthController;
use App\Models\Autorizacion;
use App\Models\Cliente;
use App\Models\PlatoSucursal;
use App\Models\Turno;
use App\Models\Siat\LeyendaFactura;
use App\Models\ParteProduccion;
use App\Models\Siat\EventoSignificativo;
use App\Models\Siat\SiatCufd;
use Illuminate\Support\Facades\DB;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioFacturacionCodigos;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioSiat;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\SiatConfig;
use SinticBolivia\SBFramework\Modules\Invoices\Classes\Siat\Services\ServicioOperaciones;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login_sales', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::post('sale_register', [\App\Http\Controllers\Api\VentaController::class, 'registerSale'])->name('registerSale');

Route::post('update_state_turn', [\App\Http\Controllers\Api\TurnoController::class, 'update_state_turn'])->name('update_state_turn');

Route::get('get_tax_sales', [\App\Http\Controllers\Api\TurnoController::class, 'get_tax_sales'])->name('get_tax_sales');

Route::get('get_transaction', [\App\Http\Controllers\Api\TurnoController::class, 'get_transaction'])->name('get_transaction');

Route::get('check_open_turn', [\App\Http\Controllers\Api\TurnoController::class, 'check_open_turn'])->name('check_open_turn');

Route::get('get_open_turn', [\App\Http\Controllers\Api\TurnoController::class, 'get_open_turn'])->name('get_open_turn');
Route::post('turn_register', [\App\Http\Controllers\Api\TurnoController::class, 'turn_register'])->name('turn_register');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {

    return $request->user();
});

Route::get('/compras', [CompraController::class, 'getCompras']);

Route::get('/get_compras', function (Request $request) {

    $compras = new Compra();
    $compras_registradas = $compras->getCompras();
    if (!is_null($compras_registradas)) {
        $respuesta = [
            'success' => true,
            'compras' => $compras_registradas
        ];
    } else {
        $respuesta = [
            'success' => false,
            'compras' => $compras_registradas
        ];
    }
    return response($respuesta, 200)->header('Content-Type', 'application/json');
});

Route::get('/getCufd', function (Request $request) { //----------
    $cufd =SiatCufd::where('sucursal_id', '=', $request->sucursal_id)
        ->where('estado', 'V')
        ->orderBy('id', 'desc')
        ->first();
    $respuesta = [
        'success' => true,
        'cufd' => json_encode($cufd)
    ];
    return response($respuesta, 200)->header('Content-Type', 'application/json');
});

Route::get('/getPlates', function (Request $request) {

    $plates = new Plato();
    $categoria_plato_id = $request->categoria_plato_id;
    $sucursal_id = $request->sucursal_id;
    /* Tan pariendo con la consulta :v */

    $assigned_plates = $plates->getPlates($categoria_plato_id, $sucursal_id);

    $response = [
        'success' => true,
        'plate' => $assigned_plates,
    ];

    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('/getCategories', function (Request $request) {
    $categories = new PlatoSucursal();

    $categories = $categories->allCategorias($request->sucursal_id);

    $response = [
        'success' => true,
        'categorias' => $categories,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

//getPlates
Route::get('/getPlatos', function () {

    $plates = new Plato();
    $assigned_plates = $plates->getPlatos();
    $response = [
        'success' => true,
        'plato' => $assigned_plates,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('/getSignifficantEvents', function () {

    $events = new EventoSignificativo();
    $signifficant_events = $events->getSignifficantEvents();
    $response = [
        'success' => true,
        'events' => $signifficant_events,

    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::post('comprobeishon_turn', function (Request $request) {
    $user = $request->user_id;
    $fecha = Carbon::now()->format('Y-m-d');
    $turno_am = DB::select("select count(turno) as total from turnos_ingresos where fecha = '$fecha' and user_id = '$user' and turno = 0"); //0 = AM ... 1 = PM ...

    $response = [
        'success' => true,
        'turno_id' => $turno_am,
    ];

    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::post('updated_turn', function (Request $request) {

    try {

        $turno_id = $request->turno_id;
        $sucursal_id = $request->sucursal_id;

        //Obtener el total de ventas (Bs) del turno
        $turns = new TurnoIngreso();
        $turns->close_turn($turno_id, $sucursal_id);

        /* total_ventas =  $turns->getSaleTurn($turno_id);      
        $hora_fin = Carbon::now()->format('H:i:s');
        $turno = TurnoIngreso::find($turno_id);
        $turno->hora_fin = $hora_fin;
        $turno->ventas = $total_ventas;
        $turno->estado = 0;
        $turno->save();
 */
        return response("Turno Actualizado con exito", 200)->header('Content-Type', 'application/json');
    } catch (\Exception $e) {

        return response($e->getMessage(), 404)->header('Content-Type', 'application/json');
    }
});

Route::get('list_turns', function (Request $request) {
    $fecha_inicio = $request->fecha_inicio;
    $fecha_fin = $request->fecha_fin;
    $sucursal = $request->sucursal;
    $list_turn = new TurnoIngreso();
    $turns = $list_turn->getListTurn($fecha_inicio, $fecha_fin, $sucursal);
    $response = [
        'success' => true,
        'turns' => $turns,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('filter_client', function (Request $request) {
    $id =  $request->codigo;
    $client = Cliente::where('ci_nit', '=',  $id)->first();
    if ($client == null) {
        $response = [
            'success' => false,
        ];
        return response($response, 200)->header('Content-Type', 'application/json');
    }
    $response = [
        'success' => true,
        'cliente' => $client,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('sales_lists', function (Request $request) {
    $fecha_inicio = $request->fecha_inicio;
    $fecha_fin = $request->fecha_fin;
    $sucursal = $request->sucursal;
    $ventas = new Venta();
    $list_sales = $ventas->getSales($fecha_inicio, $fecha_fin, $sucursal);
    $response = [
        'success' => true,
        'sale' => $list_sales,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::get('sales_lists_detail', function (Request $request) {
    $venta_id = $request->venta_id;
    $ventas = new Venta();
    $list_sales_detail = $ventas->getsalesDetail($venta_id);

    $response = [
        'success' => true,
        'sales_detail' => $list_sales_detail,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::get('verified_turn', function (Request $request) {
    $turno = TurnoIngreso::where('id', $request->id_turno)->where('estado', 1)->first();
    if (isset($turno)) {
        $response = [
            'success' => true,
        ];
    } else {
        $response = [
            'success' => false,
        ];
    }
    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::get('change_status_sale', function (Request $request) {

    $venta =  Venta::find($request->id_venta);
    $turno = $request->turno;
    if (isset($venta)) {
        $venta->estado = $request->estado;
        $venta->save();

        $ventas_activas = Venta::selectRaw('sum(ventas.total_venta) as total_venta')
            ->where('ventas.turnos_ingreso_id', $turno)
            ->where('ventas.estado', 1)
            ->get();

        $turno = TurnoIngreso::find($request->turno);
        $turno->ventas = $ventas_activas[0]->total_venta;
        $turno->save();

        $response = [
            'success' => true,
        ];
    } else {
        $response = [
            'success' => false,
        ];
    }
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('sales_for_id', function (Request $request) {
    $venta = new Venta();
    $list_sales = $venta->sales_for_id($request->id);
    $list_sales_detail = $venta->getsalesDetail($request->id);
    $obj = new LeyendaFactura();
    $leyenda = $obj->getLeyenda();
    $response = [
        'success' => true,
        'ventas' => $list_sales,
        'venta_detalle' => $list_sales_detail,
        'leyenda' => $leyenda,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('sales_for_id_personal', function (Request $request) {
    $venta = new Venta();
    $list_sales = $venta->sales_for_id_personal($request->id);
    $list_sales_detail = $venta->getsalesDetail($request->id);
    $response = [
        'success' => true,
        'ventas' => $list_sales,
        'venta_detalle' => $list_sales_detail,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('obtener_ventas_turno', function (Request $request) {
    $turno_id = $request->turno_id;
    $sucursal_id = $request->sucursal_id;
    $ventas = new Venta();
    $ventas_x_plato = $ventas->obtener_ventas_x_plato($turno_id, $sucursal_id);
    $ventas_x_categoria = $ventas->obtener_ventas_x_categoria($turno_id, $sucursal_id);
    $ventas_anuladas = $ventas->obtener_ventas_anuladas($turno_id, $sucursal_id);
    $comida_personal = $ventas->obtener_comida_personal($turno_id, $sucursal_id);

    $turno = TurnoIngreso::find($turno_id);

    $response = [
        'success' => true,
        'ventas_x_plato' => $ventas_x_plato,
        'ventas_x_categoria' => $ventas_x_categoria,
        'ventas_anuladas' => $ventas_anuladas,
        'comida_personal' => $comida_personal,
        'fecha' => $turno->fecha,
        'hora_inicio' => $turno->hora_inicio,
        'hora_fin' => $turno->hora_fin != null ? $turno->hora_fin : "00:00:00",
        'turno' => $turno->turno == 0 ? "AM" : "PM"
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::get('obtener_ventas_categoria', function (Request $request) {
    $turno_id = $request->turno_id;
    $ventas = new Venta();
    $ventas_turno_categoria = $ventas->obtener_ventas_categoria($turno_id);
    $response = [
        'success' => true,
        'ventas_turno_categoria' => $ventas_turno_categoria,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});

Route::get('obtener_ventas_anuladas', function (Request $request) {
    $turno_id = $request->turno_id;
    $ventas = new Venta();
    $obtener_ventas_anuladas = $ventas->obtener_ventas_anuladas($turno_id);
    $response = [
        'success' => true,
        'obtener_ventas_anuladas' => $obtener_ventas_anuladas,
    ];

    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::get('obtener_comida_personal', function (Request $request) {
    $turno_id = $request->turno_id;
    $ventas = new Venta();
    $ventas_comida_personal = $ventas->obtener_comida_personal($turno_id);
    $response = [
        'success' => true,
        'ventas_comida_personal' => $ventas_comida_personal,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});


Route::get('filter_client_phone', function (Request $request) {
    $cel =  $request->celular;
    $client = Cliente::where('telefono', '=',  $cel)->first();
    if ($client == null) {
        $response = [
            'success' => false,
        ];
        return response($response, 200)->header('Content-Type', 'application/json');
    }
    $response = [
        'success' => true,
        'cliente' => $client,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});



/*REGISTRAR PUNTO DE VENTA FINALIZADO*/
Route::get('registroPuntoVenta', [\App\Http\Controllers\Api\FacturacioEnLineaController::class, 'registroPuntoVentaAPI']);

/*ETAPA 1 : OBTENER CUIS*/
Route::get('obtenerCuis', [\App\Http\Controllers\Api\FacturacioEnLineaController::class, 'obtenerCuisAPI']);


/*ETAPA 2 : SINCRONIZACION DE CATALOGOS PENDIENTE*/
Route::get('sincronizarCatalogos', [\App\Http\Controllers\Api\FacturacioEnLineaController::class, 'sincronizarListaLeyendasFacturaAPI']);

/* ETAPA 3 OBTENER CODIGO CUFD FINALIZADO */
Route::get('obtenerCufdAPI', [\App\Http\Controllers\Api\FacturacioEnLineaController::class, 'obtenerCufdAPI']);


Route::get('sincronizarTotalTipoEmisionAPI', [\App\Http\Controllers\Api\FacturacioEnLineaController::class, 'sincronizarTotalTipoEmisionAPI']);

Route::get('sincronizarTiposDocumentoSector', [\App\Http\Controllers\Siat\SincronizarCatalogosController::class, 'sincronizarTiposDocumentoSector']);

Route::get('ejecutar_pruebas_catalogos', [\App\Http\Controllers\Siat\SincronizarCatalogosController::class, 'ejecutar_pruebas_catalogos']);


Route::get('sincronizarListadoTotalActividades', [\App\Http\Controllers\Siat\SincronizarCatalogosController::class, 'sincronizarListadoTotalActividades']);

Route::get('sincronizarListaLeyendasFactura', [\App\Http\Controllers\Siat\SincronizarCatalogosController::class, 'sincronizarListaLeyendasFactura']);

Route::get('sincronizarFechaHora', [\App\Http\Controllers\Siat\SincronizarCatalogosController::class, 'sincronizarFechaHora']);

/*ETAPA 4 EMISION INDIVIDUAL*/
Route::post('emisionIndividual', [\App\Http\Controllers\Siat\EmisionIndividualController::class, 'emisionIndividual']);

/* 5TA ETAPA EVENTOS SIGNIFICATIVOS */
Route::get('generar_evento_significativo', [\App\Http\Controllers\Siat\EventoSignificativoController::class, 'generar_evento_significativo']);

/*ETAPA 6 EMISION POR PAQUETES*/
Route::get('emisionPaquetes', [\App\Http\Controllers\Siat\EmisionPaqueteController::class, 'emisionPaquetes']);

/* ETAPA 7 ANULACION FACTURAS */
Route::get('test_anulacion_factura', [\App\Http\Controllers\Siat\AnulacionFacturaController::class, 'test_anulacion_factura']);

Route::get('prueba_anulacion', [\App\Http\Controllers\Siat\AnulacionFacturaController::class, 'prueba_anulacion']);

/* ETAPA 8 FIRMA DIGITAL */
Route::get('generar_firma_digital', [\App\Http\Controllers\Siat\FirmaDigitalController::class, 'generar_firma_digital']);

/* ETAPA 9 METODOS EMISION MASIVA  */
Route::get('generar_emision_masiva', [\App\Http\Controllers\Siat\EmisionMasivaController::class, 'generar_emision_masiva']);


Route::get('get_leyendas', function () {

    $obj = new LeyendaFactura();
    $client = $obj->getLeyenda();
    if ($client == null) {
        $response = [
            'success' => false,
        ];
        return response($response, 200)->header('Content-Type', 'application/json');
    }
    $response = [
        'success' => true,
        'leyenda' => $client,
    ];
    return response($response, 200)->header('Content-Type', 'application/json');
});
