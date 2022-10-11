<?php

    use App\Http\Controllers\Api\AuthController;
    use App\Http\Controllers\CategoriaPlatoController;
    use App\Http\Controllers\MantenimientoController;
    use App\Http\Controllers\CompraController;
    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\VacacionController;
    use App\Http\Controllers\CronologiaController;
    use App\Http\Controllers\EvaluacionController;
    use App\Http\Controllers\GaranteController;
    use App\Http\Controllers\InventarioController;
    use App\Http\Controllers\ObservacionController;
    use App\Http\Controllers\PagoController;
    use App\Http\Controllers\RetrasoyFaltaController;
    use App\Http\Controllers\TareaController;
    use App\Http\Controllers\CajaChicaController;
    use App\Http\Controllers\CostoCuadrilController;
    use App\Http\Controllers\EliminacionController;
    use App\Http\Controllers\KeperiController;
    use App\Http\Controllers\MenuSemanalController;
    use App\Http\Controllers\PedidoController;
    use App\Http\Controllers\ReciclajeController;
    use App\Http\Controllers\PedidoProduccionController;
    use App\Http\Controllers\TraspasoController;
    use App\Http\Controllers\AsignarStockController;
use App\Http\Controllers\ChanchoController;
use App\Http\Controllers\PostulantesController;
    use App\Http\Controllers\ParteProduccionController;

    use App\Models\CajaChica;
    use App\Models\Sucursal;
    use App\Models\UsuarioSucursal;
    use App\Models\ParteProduccion;
    
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\MenuCalificacionController;
use App\Http\Controllers\siat\AnulacionFacturaController;
use App\Http\Controllers\Siat\RegistrarPuntoVentaController;
use App\Http\Controllers\VentaController;
    /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Route::get('/', function () {
        $sucursales = Sucursal::all();
        return view('auth.login', compact('sucursales'));
    });

    Auth::routes(['register' => false]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::post('/login_nuevo', [AuthController::class, 'login_nuevo'])->name('login_nuevo') ;


    Route::get('/marcadoAsistencia', function () {
        return view('marcadoAsistencia');
    })->name('marcadoAsistencia');

    Route::post('/marcadoAsistencia', [App\Http\Controllers\UserController::class, 'marcar_asistencia'])->name('personales.marcar_asistencia');
    /*Auth */
    Route::post('/auth/find', [App\Http\Controllers\LoginManualController::class, 'authenticate'])->name('auth.find');

    /*Rutas Proveedores */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
        Route::get('/proveedores', [App\Http\Controllers\ProveedorController::class, 'index'])->name('proveedores.index');
        Route::get('/proveedores/create', [App\Http\Controllers\ProveedorController::class, 'create'])->name('proveedores.create');
        Route::post('/proveedores', [App\Http\Controllers\ProveedorController::class, 'store'])->name('proveedores.store');
        Route::get('/proveedores/edit/{id}', [App\Http\Controllers\ProveedorController::class, 'edit'])->name('proveedores.edit');
        Route::put('/proveedores/{id}', [App\Http\Controllers\ProveedorController::class, 'update'])->name('proveedores.update');
        Route::delete('/proveedores/{id}', [\App\Http\Controllers\ProveedorController::class, 'destroy'])->name('proveedores.destroy');
        Route::get('/proveedores/show/{id}', [App\Http\Controllers\ProveedorController::class, 'show'])->name('proveedores.show');
    });

    /*Rutas Productos */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Chef Corporativo']], function () {
        Route::get('/productos', [App\Http\Controllers\ProductoController::class, 'index'])->name('productos.index');
        Route::get('/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('productos.create');
        Route::post('/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('productos.store');
        Route::get('/productos/edit/{id}', [App\Http\Controllers\ProductoController::class, 'edit'])->name('productos.edit');
        Route::put('/productos/{id}', [App\Http\Controllers\ProductoController::class, 'update'])->name('productos.update');
        Route::delete('/productos/{id}', [\App\Http\Controllers\ProductoController::class, 'destroy'])->name('productos.destroy');
        Route::get('/productos/show/{id}', [App\Http\Controllers\ProductoController::class, 'show'])->name('productos.show');
    });
    /* Rutas Sucursales*/
    Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {
        Route::get('/sucursales', [App\Http\Controllers\SucursalController::class, 'index'])->name('sucursales.index');
        Route::get('/sucursales/create', [App\Http\Controllers\SucursalController::class, 'create'])->name('sucursales.create');
        Route::post('/sucursales', [App\Http\Controllers\SucursalController::class, 'store'])->name('sucursales.store');
        Route::get('/sucursales/edit/{id}', [App\Http\Controllers\SucursalController::class, 'edit'])->name('sucursales.edit');
        Route::put('/sucursales/{id}', [App\Http\Controllers\SucursalController::class, 'update'])->name('sucursales.update');
        Route::get('/sucursales/show/{id}', [App\Http\Controllers\SucursalController::class, 'show'])->name('sucursales.show');
        Route::delete('/sucursales/{id}', [\App\Http\Controllers\SucursalController::class, 'destroy'])->name('sucursales.destroy');
    });

    /* Rutas Categorias*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Chef Corporativo']], function () {
        Route::get('/categorias', [App\Http\Controllers\CategoriaController::class, 'index'])->name('categorias.index');
        Route::get('/categorias/create', [App\Http\Controllers\CategoriaController::class, 'create'])->name('categorias.create');
        Route::post('/categorias', [App\Http\Controllers\CategoriaController::class, 'store'])->name('categorias.store');
        Route::get('/categorias/edit/{id}', [App\Http\Controllers\CategoriaController::class, 'edit'])->name('categorias.edit');
        Route::put('/categorias/{id}', [App\Http\Controllers\CategoriaController::class, 'update'])->name('categorias.update');
        Route::get('/categorias/show/{id}', [App\Http\Controllers\CategoriaController::class, 'show'])->name('categorias.show');
        Route::delete('/categorias/{id}', [\App\Http\Controllers\CategoriaController::class, 'destroy'])->name('categorias.destroy');
    });

    /*Rutas Producto Proveedor */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Chef Corporativo']], function () {
        Route::get('/productos_proveedores/create', [App\Http\Controllers\ProductoProveedorController::class, 'create'])->name('productos_proveedores.create');
        Route::get('/productos_proveedores/edit/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'edit'])->name('productos_proveedores.edit');
        Route::post('/productos_proveedores', [App\Http\Controllers\ProductoProveedorController::class, 'store'])->name('productos_proveedores.store');
        Route::put('/productos_proveedores/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'update'])->name('productos_proveedores.update');
        
        Route::post('productos_proveedores/enviarDetalle', [App\Http\Controllers\ProductoProveedorController::class, 'guardarDetalle'])->name('productos_proveedores.guardarDetalle');
        Route::post('productos_proveedores/eliminarDetalle', [App\Http\Controllers\ProductoProveedorController::class, 'eliminarDetalle'])->name('productos_proveedores.eliminarDetalle');
        Route::post('productos_proveedores/registrarPrecios', [App\Http\Controllers\ProductoProveedorController::class, 'store'])->name('productos_proveedores.registrarPrecios');
        Route::get('productos_proveedores/solicitudCambioPrecio/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'solicitudCambioPrecioView'])->name('productos_proveedores.solicitudCambioPrecioView');
        Route::get('productos_proveedores/solicitudCambioPrecio', [App\Http\Controllers\ProductoProveedorController::class, 'solicitudCambioPrecioSave'])->name('productos_proveedores.solicitudCambioPrecioSave');
        Route::get('productos_proveedores/verSolicitudes/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'verSolicitudes'])->name('productos_proveedores.verSolicitudes');
    });
    Route::get('/productos_proveedores', [App\Http\Controllers\ProductoProveedorController::class, 'index'])->name('productos_proveedores.index');
    Route::get('/productos_proveedores/show/{id}', [App\Http\Controllers\ProductoProveedorController::class, 'show'])->name('productos_proveedores.show');

    /*Rutas Asignar Stock */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Chef Corporativo']], function () {
        Route::get('/asignar_stock', [App\Http\Controllers\AsignarStockController::class, 'index'])->name('asignar_stock.index');
        Route::get('/asignar_stock/create', [App\Http\Controllers\AsignarStockController::class, 'create'])->name('asignar_stock.create');
        Route::get('/asignar_stock/edit/{id}', [App\Http\Controllers\AsignarStockController::class, 'edit'])->name('asignar_stock.edit');
        Route::post('/asignar_stock', [App\Http\Controllers\AsignarStockController::class, 'store'])->name('asignar_stock.store');
        Route::put('/asignar_stock/{id}', [App\Http\Controllers\AsignarStockController::class, 'update'])->name('asignar_stock.update');
        Route::get('/asignar_stock/show/{id}', [App\Http\Controllers\AsignarStockController::class, 'show'])->name('asignar_stock.show');
        Route::post('/asignar_stock/guardarDetalle', [App\Http\Controllers\AsignarStockController::class, 'guardarDetalle'])->name('asignar_stock.guardarDetalle');
        Route::post('/asignar_stock/eliminarDetalle', [App\Http\Controllers\AsignarStockController::class, 'eliminarDetalle'])->name('asignar_stock.eliminarDetalle');
        Route::post('/asignar_stock/registrar_Stock', [App\Http\Controllers\AsignarStockController::class, 'store'])->name('asignar_stock.registrar_Stock');
        Route::get('/asignar_stock/reporteCarnicos', [App\Http\Controllers\AsignarStockController::class, 'reporteCarnicos'])->name('asignar_stock.reporteCarnicos');
        Route::post('/asignar_stock/filtrarReporteCarnes', [AsignarStockController::class, 'filtrarReporteCarnes'])->name('asignar_stock.filtrarReporteCarnes');
        Route::post('/asignar_stock/actualizarStock', [AsignarStockController::class, 'actualizarStock'])->name('asignar_stock.actualizarStock');
    
    });

    /*Rutas Inventario*/
    Route::resource('inventarios', InventarioController::class);
    Route::post('/inventarios/filtrarinventario', [InventarioController::class, 'filtrarinventario'])->name('inventarios.filtrarInventario');
    Route::get('/inventarios/showInventarioSistema/{id}', [InventarioController::class, 'showInventarioSistema'])->name('inventarios.showInventarioSistema');
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado|Contabilidad|Chef Corporativo']], function () {

        Route::post('/inventarios/obtenerInsumos', [App\Http\Controllers\InventarioController::class, 'obtenerInsumos'])->name('inventarios.obtenerInsumos');
        Route::post('/inventarios/guardarDetalleInventario', [App\Http\Controllers\InventarioController::class, 'guardarDetalleInventario'])->name('inventarios.guardarDetalleInventario');
        Route::post('/inventarios/obtenerUM', [InventarioController::class, 'obtenerUM'])->name('inventarios.obtenerUM');
        Route::post('/inventarios/registrarInventario', [InventarioController::class, 'registrarInventarios'])->name('inventarios.registrarInventario');
        Route::post('/inventarios/obtenerPrecio', [InventarioController::class, 'obtenerPrecios'])->name('inventarios.obtenerPrecios');
        Route::post('/inventarios/obtenerProductoxId', [InventarioController::class, 'obtenerProductosxId'])->name('inventarios.obtenerProductosxId');
        Route::post('/inventarios/eliminarDetalle', [InventarioController::class, 'eliminarDetalle'])->name('inventarios.eliminarDetalle');
        Route::post('/inventarios/actualizarInventario', [InventarioController::class, 'actualizarInventarios'])->name('inventarios.actualizarInventario');
        
    
    });

    /*  Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {
        Route::get('/inventarios/show', [InventarioController::class, 'show'] )->name('inventarios.show');
        Route::get('/inventarios/edit', [InventarioController::class, 'edit'])->name('inventarios.edit');
        Route::post('/inventarios/actualizarInventario', [InventarioController::class, 'actualizarInventarios'])->name('inventarios.actualizarInventario');
    }); */

    /*Rutas Encargado*/

    Route::get('/encargados', [App\Http\Controllers\EncargadoController::class, 'index'])->name('encargados.index');
    Route::get('/encargados/create', [App\Http\Controllers\EncargadoController::class, 'create'])->name('encargados.create');
    Route::post('/encargados', [App\Http\Controllers\EncargadoController::class, 'store'])->name('encargados.store');


    /* Rutas Contratos*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::get('/contratos', [App\Http\Controllers\ContratoController::class, 'index'])->name('contratos.index');
        Route::get('/contratos/create', [App\Http\Controllers\ContratoController::class, 'create'])->name('contratos.create');
        Route::post('/contratos', [App\Http\Controllers\ContratoController::class, 'store'])->name('contratos.store');
        Route::get('/contratos/edit/{id}', [App\Http\Controllers\ContratoController::class, 'edit'])->name('contratos.edit');
        Route::put('/contratos/{id}', [App\Http\Controllers\ContratoController::class, 'update'])->name('contratos.update');
        Route::get('/contratos/show/{id}', [App\Http\Controllers\ContratoController::class, 'show'])->name('contratos.show');
        Route::delete('/contratos/{id}', [\App\Http\Controllers\ContratoController::class, 'destroy'])->name('contratos.destroy');
    });

    /*Rutas Departamentos */
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::get('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'index'])->name('departamentos.index');
        Route::get('/departamentos/create', [App\Http\Controllers\DepartamentoController::class, 'create'])->name('departamentos.create');
        Route::post('/departamentos', [App\Http\Controllers\DepartamentoController::class, 'store'])->name('departamentos.store');
        Route::get('/departamentos/edit/{id}', [App\Http\Controllers\DepartamentoController::class, 'edit'])->name('departamentos.edit');
        Route::put('/departamentos/{id}', [App\Http\Controllers\DepartamentoController::class, 'update'])->name('departamentos.update');
        Route::delete('/departamentos/{id}', [\App\Http\Controllers\DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
    });

    /*Rutas Postulantes */
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Contabilidad']], function () {
        
        Route::get('/postulantes/create', [App\Http\Controllers\PostulantesController::class, 'create'])->name('postulantes.create');
        Route::post('/postulantes/contratar', [App\Http\Controllers\PostulantesController::class, 'contratar'])->name('postulantes.contratar');
        Route::delete('/postulantes/{id}', [\App\Http\Controllers\PostulantesController::class, 'destroy'])->name('postulantes.destroy');
        Route::get('/postulantes/datosbasicos/{id}', [App\Http\Controllers\PostulantesController::class, 'editDatosBasicos'])->name('postulantes.editDatosBasicos');
        Route::post('/postulantes/datosbasicos/{id}', [App\Http\Controllers\PostulantesController::class, 'actualizarDatosBasicos'])->name('postulantes.actualizarDatosBasicos');
        Route::get('/postulantes', [App\Http\Controllers\PostulantesController::class, 'index'])->name('postulantes.index');
       
    

    });

    /*Rutas Contrato de Personal */
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Contabilidad']], function () {
        
        Route::get('/personales/create', [App\Http\Controllers\UserController::class, 'create'])->name('personales.create');
        Route::post('/personales', [App\Http\Controllers\UserController::class, 'contratar'])->name('personales.contratar');
        
        Route::delete('/personales/{id}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('personales.destroy');
        Route::get('/personales/editContratoUser/{id}', [App\Http\Controllers\UserController::class, 'editContratoUser'])->name('personales.editContratoUser');
        Route::get('/personales/editDatosBasicos/{id}', [App\Http\Controllers\UserController::class, 'editDatosBasicos'])->name('personales.editDatosBasicos');
        Route::post('/personales/editContratoUser', [App\Http\Controllers\UserController::class, 'actualizarContratoUser'])->name('personales.actualizarContratoUser');
        Route::put('/personales/editDatosBasicos/{id}', [App\Http\Controllers\UserController::class, 'actualizarDatosBasicos'])->name('personales.actualizarDatosBasicos');
        Route::get('/personales/rolesPersonales/{id}', [App\Http\Controllers\UserController::class, 'rolesPersonales'])->name('personales.rolesPersonales');
        Route::get('/personales/retiroForm/{id}', [App\Http\Controllers\UserController::class, 'retiroForm'])->name('personales.retiroForm');
        Route::post('/personales/retiroForm', [App\Http\Controllers\UserController::class, 'retiroFormSave'])->name('personales.retiroFormSave');
        Route::get('/personales/asignarSucursal/{id}', [App\Http\Controllers\UserController::class, 'asignarSucursal'])->name('personales.asignarSucursal');
        Route::put('/personales/asignar_Sucursal/{id}', [App\Http\Controllers\UserController::class, 'saveasignarSucursal'])->name('personales.saveasignarSucursal');
        Route::get('/personales/editBonoUser/{id}', [App\Http\Controllers\UserController::class, 'editBonoUser'])->name('personales.editBonoUser');

        Route::get('/personales/reportes/vencimientoContratos', [App\Http\Controllers\UserController::class, 'vencimientoContratos'])->name('personales.vencimientoContratos');
        Route::post('/personales/vencimientoContratos', [App\Http\Controllers\UserController::class, 'filtrarContratos'])->name('personales.filtrarContratos');
        Route::get('/personales/reportes/cronologiaPersonales/{id}', [App\Http\Controllers\UserController::class, 'cronologiaPersonales'])->name('personales.cronologiaPersonales');
        Route::get('/personales/asignarCargo/{id}', [App\Http\Controllers\UserController::class, 'asignarCargo'])->name('personales.asignarCargo');
        Route::put('/personales/save_cargo/{id}', [App\Http\Controllers\UserController::class, 'saveAsignarCargo'])->name('personales.saveAsignarCargo');
    });

    Route::get('/personales', [App\Http\Controllers\UserController::class, 'index'])->name('personales.index');
    Route::get('/personales/show/{id}', [App\Http\Controllers\UserController::class, 'showDetalleContrato'])->name('personales.showDetalleContrato');

    
        Route::get('personales/contratos/editarContrato/{id}', [\App\Http\Controllers\DetalleContratoController::class, 'edit'])->name('personales_contratos.edit');
        Route::put('personales/contratos/editarContrato/{id}', [\App\Http\Controllers\DetalleContratoController::class, 'update'])->name('personales_contratos.update');
        Route::delete('personales/contratos/editarContrato/{id}', [\App\Http\Controllers\DetalleContratoController::class, 'eliminar'])->name('personales_contratos.eliminar');
        Route::get('personales/vacaciones/agregarVacacion/{id}', [\App\Http\Controllers\VacacionController::class, 'agregarVacacion'])->name('personales_vacaciones.agregarVacacion');
        Route::post('personales/vacaciones/agregarVacacion/{id}', [\App\Http\Controllers\VacacionController::class, 'guardarVacacion'])->name('personales_vacaciones.guardarVacacion');
        Route::get('/personales/editDescountUser/{id}', [App\Http\Controllers\UserController::class, 'editDescountUser'])->name('personales.editDescountUser');
        Route::get('/personales/evaluaciones/reporteEvaluaciones', [App\Http\Controllers\UserController::class, 'reporteEvaluaciones'])->name('personales.reporteEvaluaciones');
        Route::get('/personales/evaluaciones/evaluacionesUsuario/{id}', [App\Http\Controllers\UserController::class, 'evaluacionesUsuario'])->name('personales.evaluacionesUsuario');
        Route::post('/personales/evaluaciones/evaluacionesUsuario/{id}', [App\Http\Controllers\UserController::class, 'filtrarEvaluacionUsuario'])->name('personales.filtrarEvaluacionUsuario');
    

    
        Route::get('/personales/tareas/tarea', [App\Http\Controllers\UserController::class, 'listaTareas'])->name('personales.listaTareas');
        Route::post('/personales/tareas/saveTareas/{id}', [App\Http\Controllers\UserController::class, 'saveTareas'])->name('personales.saveTareas');
        Route::get('/personales/tareas/reporteTareas', [App\Http\Controllers\UserController::class, 'reporteTareas'])->name('personales.reporteTareas');
        Route::get('/personales/tareas/actividadesUsuario/{id}', [App\Http\Controllers\UserController::class, 'actividadesUsuario'])->name('personales.actividadesUsuario');
        Route::post('/personales/tareas/actividadesUsuario/{id}', [App\Http\Controllers\UserController::class, 'filtrarActividades'])->name('personales.filtrarActividades');
        Route::get('/personales/reportes/reporteMarcadoAsistencia/', [App\Http\Controllers\UserController::class, 'reporteMarcadoAsistencia'])->name('personales.reporteMarcadoAsistencia');
        Route::post('/personales/filtrarMarcadoAsistencia/', [App\Http\Controllers\UserController::class, 'filtrarMarcadoAsistencia'])->name('personales.filtrarMarcadoAsistencia');
        Route::get('/personales/assignTurnView/{id}', [App\Http\Controllers\UserController::class, 'assignTurnView'])->name('personales.assignTurnView');
        Route::put('/personales/assignTurn/{id}', [App\Http\Controllers\UserController::class, 'assignTurn'])->name('personales.assignTurn');
        Route::get('/personales/evaluaciones/evaluacion', [App\Http\Controllers\UserController::class, 'listaEvaluaciones'])->name('personales.listaevaluaciones');
        Route::post('/personales/evaluaciones/guardarEvaluaciones/{id}', [App\Http\Controllers\UserController::class, 'guardarEvaluaciones'])->name('personales.guardarEvaluaciones');
        Route::post('/personales/reportes/actividades', [App\Http\Controllers\UserController::class, 'reporteSeguimientoActividades'])->name('personales.reporteSeguimientoActividades');
        Route::get('/personales/reportes/ver', [App\Http\Controllers\UserController::class, 'mostrarUsuarios'])->name('personales.mostrarUsuarios');
    


    /*Rutas Cargos  1 */
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::get('/cargos', [App\Http\Controllers\CargoController::class, 'index'])->name('cargos.index');
        Route::get('/cargos/edit/{id}', [App\Http\Controllers\CargoController::class, 'edit'])->name('cargos.edit');
        Route::get('/cargos/create', [App\Http\Controllers\CargoController::class, 'create'])->name('cargos.create');
        Route::post('/cargos', [App\Http\Controllers\CargoController::class, 'store'])->name('cargos.store');
        Route::delete('/cargos/{id}', [\App\Http\Controllers\CargoController::class, 'destroy'])->name('cargos.destroy');
    });

    /*Rutas Sanciones  1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Contabilidad']], function () {
        Route::get('/sanciones', [App\Http\Controllers\SancionesController::class, 'index'])->name('sanciones.index');
        Route::get('/sanciones/filtrar', [App\Http\Controllers\SancionesController::class, 'filtrarSanciones'])->name('sanciones.filtrarSanciones');
        Route::get('/sanciones/create', [App\Http\Controllers\SancionesController::class, 'create'])->name('sanciones.create');
        Route::post('/sanciones', [App\Http\Controllers\SancionesController::class, 'store'])->name('sanciones.store');
        Route::get('/sanciones/show/{id}', [App\Http\Controllers\SancionesController::class, 'show'])->name('sanciones.show');
        Route::get('/sanciones/edit/{id}', [App\Http\Controllers\SancionesController::class, 'edit'])->name('sanciones.edit');
        Route::post('/sanciones/{id}', [App\Http\Controllers\SancionesController::class, 'update'])->name('sanciones.update');
        Route::delete('/sanciones/{id}', [\App\Http\Controllers\SancionesController::class, 'destroy'])->name('sanciones.destroy');
        Route::get('/personales/editSanctionsUser/{id}', [App\Http\Controllers\UserController::class, 'editSanctionsUser'])->name('personales.editSanctionsUser');
    });
    /*Ruta Horarios 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::get('/horarios', [App\Http\Controllers\HorarioController::class, 'index'])->name('horarios.index');
        Route::get('/horarios/create', [App\Http\Controllers\HorarioController::class, 'create'])->name('horarios.create');
        Route::post('/horarios', [App\Http\Controllers\HorarioController::class, 'store'])->name('horarios.store');
        Route::post('/horarios/create', [App\Http\Controllers\HorarioController::class, 'obtenerSucursal'])->name('horarios.obtenerSucursal');
        Route::post('/funcionarios', [App\Http\Controllers\HorarioController::class, 'funcionarios'])->name('sucursal.funcionarios');
        Route::get('horarios/reporteHorario', [App\Http\Controllers\HorarioController::class, 'reporteHorario'])->name('horarios.reporteHorario');
        Route::get('/planillaHorarios', [App\Http\Controllers\HorarioController::class, 'planillaHorarios'])->name('horarios.planillaHorarios');
      
        Route::post('/planillaHorarios', [App\Http\Controllers\HorarioController::class, 'obtenerFuncionarios'])->name('horarios.obtenerFuncionarios');
    });

    /*Rutas Bonos 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::get('/bonos', [App\Http\Controllers\BonoController::class, 'index'])->name('bonos.index');
        Route::get('/bonos/create', [App\Http\Controllers\BonoController::class, 'create'])->name('bonos.create');
        Route::post('/bonos', [App\Http\Controllers\BonoController::class, 'store'])->name('bonos.store');
        Route::get('/bonos/show/{id}', [App\Http\Controllers\BonoController::class, 'show'])->name('bonos.show');
        Route::delete('/bonos/{id}', [\App\Http\Controllers\BonoController::class, 'destroy'])->name('bonos.destroy');
    });

    /*Rutas descuentos 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::get('/descuentos', [App\Http\Controllers\DescuentoController::class, 'index'])->name('descuentos.index');
        Route::get('/descuentos/create', [App\Http\Controllers\DescuentoController::class, 'create'])->name('descuentos.create');
        Route::post('/descuentos', [App\Http\Controllers\DescuentoController::class, 'store'])->name('descuentos.store');
        Route::get('/descuentos/show/{id}', [App\Http\Controllers\DescuentoController::class, 'show'])->name('descuentos.show');
        Route::delete('/descuentos/{id}', [\App\Http\Controllers\DescuentoController::class, 'destroy'])->name('descuentos.destroy');
    });
    /*Rutas vacaciones ?*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::resource('vacaciones', VacacionController::class);
        Route::post('/vacaciones/cambiarestado/{id}', [App\Http\Controllers\VacacionController::class, 'cambiarestado'])->name('vacaciones.cambiarestado');

    });

    /*Rutas Roles ?*/
    Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {
        Route::resource('roles', RoleController::class);
    });
    /*Rutas 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Encargado']], function () {
        Route::resource('compras', CompraController::class);
        Route::post('compras/registrarComprar', [CompraController::class, 'registrarCompra'])->name('compras.registrarCompra');
        Route::post('compras/create', [CompraController::class, 'obtenerProductos'])->name('compras.obtenerproductos');
        Route::post('compras/obtener', [CompraController::class, 'obtenerPrecios'])->name('compras.obtenerprecios');
        Route::post('compras/enviarDetalle', [CompraController::class, 'guardarDetalle'])->name('compras.guardarDetalle');
        Route::post('compras/eliminarDetalle', [CompraController::class, 'eliminarDetalle'])->name('compras.eliminarDetalle');
        Route::post('compras/filtrarCompras', [CompraController::class, 'filtrarCompras'])->name('compras.filtrarCompras');
        Route::get('compras/download-pdf/{id}', [CompraController::class, 'downloadPdf'])->name('compras.download-pdf');
        Route::get('compras/obtenerDetallePago', [CompraController::class, 'obtenerDetallePago'])->name('compras.obtenerDetallePago');
    });
    /*Rutas */
    Route::group(['middleware' => ['auth, role:Super Admin|RRHH']], function () {
        Route::resource('cronologias', CronologiaController::class);
    });
    /*Rutas ?*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::resource('observaciones', ObservacionController::class);
    });

    /*Rutas   1 */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
        Route::resource('pagos', PagoController::class);

        Route::post('compras/filtrarPagos', [PagoController::class, 'filtrarPagos'])->name('pagos.filtrarPagos');
        Route::get('pagos/download-pdf/{id}', [PagoController::class, 'downloadPdf'])->name('pagos.download-pdf');
        Route::get('contabilidad/reportes/reporteProveedores', [PagoController::class, 'reporteProveedores'])->name('contabilidad.reporteProveedores');
        Route::post('contabilidad/reportes/reporteProveedores', [PagoController::class, 'filtrarComprasyPagos'])->name('contabilidad.filtrarComprasyPagos');
        Route::get('contabilidad/reportes/reporteCajaChica', [CajaChicaController::class, 'reporteCajaChica'])->name('contabilidad.reporteCajaChica');
        Route::post('contabilidad/reportes/reporteCajaChica', [CajaChicaController::class, 'filtrarCajaChica'])->name('contabilidad.filtrarCajaChica');
        Route::get('contabilidad/reportes/reporteProveedores/detalle/{id}/{fecha_inicial}/{fecha_final}', [PagoController::class, 'detalleComprasyPagos'])->name('contabilidad.detalleComprasyPagos');
    });
    /*Rutas   ?*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::resource('garantes', GaranteController::class);
    });
    /*Rutas   ?*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Encargado']], function () {
        Route::resource('retrasosFaltas', RetrasoyFaltaController::class);
    });
    /*Rutas   1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Contabilidad']], function () {
        Route::resource('tareas', TareaController::class);
        Route::post('tareas/actualizar/{id}', [TareaController::class, 'actualizar'])->name('tareas.actualizar');
    });
    /*Rutas   1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH']], function () {
        Route::resource('evaluaciones', EvaluacionController::class);
        Route::post('evaluaciones/actualizar/{id}', [EvaluacionController::class, 'actualizar'])->name('evaluaciones.actualizar');
    });
    /*Rutas   1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Chef Corporativo']], function () {
        Route::get('/categorias_platos', [App\Http\Controllers\CategoriaPlatoController::class, 'index'])->name('categorias_platos.index');
        Route::get('/categorias_platos/create', [App\Http\Controllers\CategoriaPlatoController::class, 'create'])->name('categorias_platos.create');

        Route::post('/categorias_platos', [App\Http\Controllers\CategoriaPlatoController::class, 'store'])->name('categorias_platos.store');
        Route::get('/categorias_platos/edit/{id}', [App\Http\Controllers\CategoriaPlatoController::class, 'edit'])->name('categorias_platos.edit');
        Route::delete('/categorias_platos/{id}', [\App\Http\Controllers\CategoriaPlatoController::class, 'destroy'])->name('categorias_platos.destroy');
        Route::put('/categorias_platos/{id}', [App\Http\Controllers\CategoriaPlatoController::class, 'update'])->name('categorias_platos.update');
    });
    /*Rutas   1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|RRHH|Chef Corporativo']], function () {
        Route::get('/platos', [App\Http\Controllers\PlatoController::class, 'index'])->name('platos.index');
        Route::get('/platos/asignarReceta/{id}', [App\Http\Controllers\PlatoController::class, 'asignarReceta'])->name('platos.asignarReceta');
        Route::get('/platos/create', [App\Http\Controllers\PlatoController::class, 'create'])->name('platos.create');
        Route::post('/platos', [App\Http\Controllers\PlatoController::class, 'store'])->name('platos.store');
        Route::get('/platos/edit/{id}', [App\Http\Controllers\PlatoController::class, 'edit'])->name('platos.edit');
        Route::delete('/platos/{id}', [\App\Http\Controllers\PlatoController::class, 'destroy'])->name('platos.destroy');
        Route::post('/platos/{id}', [App\Http\Controllers\PlatoController::class, 'update'])->name('platos.update');
        Route::get('/platos/show/{id}', [App\Http\Controllers\PlatoController::class, 'show'])->name('platos.show');
        Route::get('platos/show-PDF/{id}', [App\Http\Controllers\PlatoController::class, 'showPdf'])->name('platos.showPdf');
    });
    /*Rutas Asignar Platos a Sucursales */
    /*Rutas   1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Chef Corporativo']], function () {
        Route::get('/platos_sucursales', [App\Http\Controllers\PlatoSucursalController::class, 'index'])->name('platos_sucursales.index');
        Route::get('/platos_sucursales/create', [App\Http\Controllers\PlatoSucursalController::class, 'create'])->name('platos_sucursales.create');
        Route::post('/platos_sucursales', [App\Http\Controllers\PlatoSucursalController::class, 'store'])->name('platos_sucursales.store');
        Route::get('/platos_sucursales/edit/{id}', [App\Http\Controllers\PlatoSucursalController::class, 'edit'])->name('platos_sucursales.edit');
        Route::delete('/platos_sucursales/{id}', [\App\Http\Controllers\PlatoSucursalController::class, 'destroy'])->name('platos_sucursales.destroy');
        Route::put('/platos_sucursales/{id}', [App\Http\Controllers\PlatoSucursalController::class, 'update'])->name('platos_sucursales.update');
        Route::post('/platos_sucursales/filtrarPlatos', [App\Http\Controllers\PlatoSucursalController::class, 'filtrarPlatos'])->name('platos_sucursales.filtrarPlatos');
        Route::post('platos_sucursales/create/enviarPlato', [App\Http\Controllers\PlatoSucursalController::class, 'enviarPlato'])->name('platos_sucursales.enviarPlato');

        Route::post('platos_sucursales/eliminarPlato', [App\Http\Controllers\PlatoSucursalController::class, 'eliminarPlato'])->name('platos_sucursales.eliminarPlato');
        Route::post('platos_sucursales/create/guardarPlato', [App\Http\Controllers\PlatoSucursalController::class, 'store'])->name('platos_sucursales.guardarPlato');
        Route::post('platos_sucursales/create/obtenerPlato', [App\Http\Controllers\PlatoSucursalController::class, 'obtenerPlato'])->name('platos_sucursales.obtenerPlato');
        Route::delete('/platos_sucursales/eliminarDetalle/{id}', [\App\Http\Controllers\PlatoSucursalController::class, 'eliminarDetalle'])->name('platos_sucursales.eliminarDetalle');
    });

    /* Rutas Recetas 1 */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Almacen|Chef Corporativo']], function () {
        Route::get('/recetas', [App\Http\Controllers\PlatoProductoController::class, 'index'])->name('recetas.index');
        Route::get('/recetas/create', [App\Http\Controllers\PlatoProductoController::class, 'create'])->name('recetas.create');
        Route::post('recetas/create', [App\Http\Controllers\PlatoProductoController::class, 'obtenerPlatos'])->name('recetas.obtenerplatos');
        Route::post('recetas/obtenerproductos', [App\Http\Controllers\PlatoProductoController::class, 'obtenerProductos'])->name('recetas.obtenerproductos');
        Route::post('recetas/obtenerprecios', [App\Http\Controllers\PlatoProductoController::class, 'obtenerPrecio'])->name('recetas.obtenerprecio');
        Route::post('/recetas', [App\Http\Controllers\PlatoSucursalController::class, 'store'])->name('recetas.store');
        Route::get('/recetas/show/{id}', [App\Http\Controllers\PlatoSucursalController::class, 'show'])->name('recetas.show');
        Route::post('/recetas/agregarDetalle', [App\Http\Controllers\PlatoProductoController::class, 'agregarDetalle'])->name('recetas.agregarDetalle');
        Route::post('/recetas/eliminarDetalle', [App\Http\Controllers\PlatoProductoController::class, 'eliminarDetalle'])->name('recetas.eliminarDetalle');
        Route::post('recetas/registrarReceta', [App\Http\Controllers\PlatoProductoController::class, 'registrarReceta'])->name('recetas.registrarReceta');
        Route::get('/recetas/edit/{id}', [App\Http\Controllers\PlatoProductoController::class, 'edit'])->name('recetas.edit');
        Route::post('/recetas/actualizarInventario', [App\Http\Controllers\PlatoProductoController::class, 'actualizarReceta'])->name('recetas.actualizarReceta');
    });
    /* Rutas Categorias Caja Chica 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Encargado']], function () {
        Route::resource('/cajas_chicas', CajaChicaController::class);
        Route::post('/cajas_chicas/registrarCajaChica', [App\Http\Controllers\CajaChicaController::class, 'registrarCajaChica'])->name('cajas_chicas.registrarCajaChica');
        Route::post('/cajas_chicas/agregarDetalle', [App\Http\Controllers\CajaChicaController::class, 'agregarDetalle'])->name('cajas_chicas.agregarDetalle');
        Route::post('/cajas_chicas/eliminarDetalle', [App\Http\Controllers\CajaChicaController::class, 'eliminarDetalle'])->name('cajas_chicas.eliminarDetalle');
    });

    /* Rutas Categorias Caja Chica 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
        Route::get('/categorias_caja_chica', [App\Http\Controllers\CategoriaCajaChicaController::class, 'index'])->name('categorias_caja_chica.index');
        Route::get('/categorias_caja_chica/create', [App\Http\Controllers\CategoriaCajaChicaController::class, 'create'])->name('categorias_caja_chica.create');
        Route::post('/categorias_caja_chica', [App\Http\Controllers\CategoriaCajaChicaController::class, 'store'])->name('categorias_caja_chica.store');
        Route::get('/categorias_caja_chica/edit/{id}', [App\Http\Controllers\CategoriaCajaChicaController::class, 'edit'])->name('categorias_caja_chica.edit');
        Route::put('/categorias_caja_chica/{id}', [App\Http\Controllers\CategoriaCajaChicaController::class, 'update'])->name('categorias_caja_chica.update');
        Route::get('/categorias_caja_chica/show/{id}', [App\Http\Controllers\CategoriaCajaChicaController::class, 'show'])->name('categorias_caja_chica.show');
        Route::post('contabilidad/caja_chica/filtrarIndexCajaChica', [CajaChicaController::class, 'filtrarIndexCajaChica'])->name('contabilidad.filtrarIndexCajaChica');
        Route::delete('/categorias_caja_chica/{id}', [\App\Http\Controllers\CategoriaCajaChicaController::class, 'destroy'])->name('categorias_caja_chica.destroy');
    });

    /* Rutas Mantenimiento 1 */
    Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {
        Route::resource('/mantenimiento', MantenimientoController::class);
        Route::post('/mantenimiento/registrarCajaChica', [App\Http\Controllers\MantenimientoController::class, 'registrarCajaChica'])->name('mantenimiento.registrarCajaChica');
        Route::post('/mantenimiento/agregarDetalle', [App\Http\Controllers\MantenimientoController::class, 'agregarDetalle'])->name('mantenimiento.agregarDetalle');
        Route::post('/mantenimiento/eliminarDetalle', [App\Http\Controllers\MantenimientoController::class, 'eliminarDetalle'])->name('mantenimiento.eliminarDetalle');
    });

    /* Rutas 1 */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado|Contabilidad|Chef Corporativo']], function () {
        Route::get('/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos.index');
        Route::get('/pedidos/create', [App\Http\Controllers\PedidoController::class, 'create'])->name('pedidos.create');
        Route::post('/pedidos', [App\Http\Controllers\PedidoController::class, 'store'])->name('pedidos.store');
        Route::post('pedidos/create/guardarPedido', [App\Http\Controllers\PedidoController::class, 'store'])->name('pedidos.guardarPedido');
        Route::post('pedidos/create/obtenerPrecios', [App\Http\Controllers\PedidoController::class, 'obtenerPrecios'])->name('pedidos.obtenerPrecios');
        Route::post('pedidos/create/agregarInsumo', [App\Http\Controllers\PedidoController::class, 'agregarInsumo'])->name('pedidos.agregarInsumo');
        Route::post('platos_sucursales/create/eliminarInsumo', [App\Http\Controllers\PedidoController::class, 'eliminarInsumo'])->name('pedidos.eliminarInsumo');
        Route::get('/pedidos/show/{id}', [App\Http\Controllers\PedidoController::class, 'show'])->name('pedidos.show');
        Route::post('/pedidos/cambiarestado', [App\Http\Controllers\PedidoController::class, 'cambiarEstado'])->name('pedidos.cambiarEstado');
        Route::get('/pedidos/verDetalleReporte/{sucursal_id}/{fecha_inicial}/{fecha_final}', [App\Http\Controllers\PedidoController::class, 'verDetalleReporte'])->name('pedidos.verDetalleReporte');
        Route::get('/pedidos/verDetalleReporteProduccion/{sucursal_id}/{fecha_inicial}/{fecha_final}', [App\Http\Controllers\PedidoProduccionController::class, 'verDetalleReporteProduccion'])->name('pedidos.verDetalleReporteProduccion');

        Route::get('/pedidos/total_insumos_solicitados', [App\Http\Controllers\PedidoController::class, 'total_insumos_solicitados'])->name('pedidos.total_insumos_solicitados');

        Route::get('/pedidos/pedido_especial', [App\Http\Controllers\PedidoController::class, 'pedido_especial'])->name('pedidos.pedido_especial');
        Route::post('/pedidos/pedido_especial_store', [App\Http\Controllers\PedidoController::class, 'pedido_especial_store'])->name('pedidos.pedido_especial_store');
        Route::get('/pedidos/reporteInsumosEnviados', [App\Http\Controllers\PedidoController::class, 'reporteInsumosEnviados'])->name('pedidos.reporteInsumosEnviados');
        Route::get('/productosinsumos/create', [App\Http\Controllers\ProductosInsumosController::class, 'create'])->name('productosinsumos.create');
        Route::post('/productosinsumos/store', [App\Http\Controllers\ProductosInsumosController::class, 'store'])->name('productosinsumos.store');
        Route::post('/productosinsumos/destroy', [App\Http\Controllers\ProductosInsumosController::class, 'destroy'])->name('productosinsumos.destroy');
        Route::post('/pedidos/filtrarPedidos', [PedidoController::class, 'filtrarPedidos'])->name('pedidos.filtrarPedidos');

    });

    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Chef Corporativo']], function () {
        Route::get('/pedidos/edit/{id}', [App\Http\Controllers\PedidoController::class, 'edit'])->name('pedidos.edit');
        Route::get('/pedidos/editPedidoEnviado/{id}', [App\Http\Controllers\PedidoController::class, 'editPedidoEnviado'])->name('pedidos.editPedidoEnviado');
        Route::delete('/pedidos/{id}', [\App\Http\Controllers\PedidoController::class, 'destroy'])->name('pedidos.destroy');
        Route::put('/pedidos/{id}', [App\Http\Controllers\PedidoController::class, 'update'])->name('pedidos.update');

        Route::get('/pedidos/VaucherPdf/{id}', [App\Http\Controllers\PedidoController::class, 'VaucherPdf'])->name('pedidos.VaucherPdf');
        Route::post('/pedidos/actualizarPedido', [PedidoController::class, 'actualizarPedido'])->name('pedidos.actualizarPedido');

        Route::post('/pedidos/actualizarPedidoEnviado', [PedidoController::class, 'actualizarPedidoEnviado'])->name('pedidos.actualizarPedidoEnviado');
        Route::post('/pedidos/filtrarZumos', [PedidoController::class, 'filtrarZumos'])->name('pedidos.filtrarZumos');
       
        Route::get('/pedidos/reporteZumos', [PedidoController::class, 'reporteZumos'])->name('pedidos.reporteZumos');
    });

    /*Rutas Eliminacion 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado']], function () {
        Route::resource('eliminaciones', EliminacionController::class);
        Route::post('/eliminaciones/agregarDetalle', [App\Http\Controllers\EliminacionController::class, 'agregarDetalle'])->name('eliminaciones.agregarDetalle');
        Route::post('/eliminaciones/eliminarDetalle', [EliminacionController::class, 'eliminarDetalle'])->name('eliminaciones.eliminarDetalle');
        Route::post('/eliminaciones/obtenerDatosProducto', [EliminacionController::class, 'obtenerDatosProducto'])->name('eliminaciones.obtenerDatosProducto');
        Route::post('/eliminaciones/registrarEliminacion', [EliminacionController::class, 'registrarEliminacion'])->name('eliminaciones.registrarEliminacion');

        Route::post('/eliminaciones/actualizarEliminacion', [EliminacionController::class, 'actualizarEliminacion'])->name('eliminaciones.actualizarEliminacion');
        Route::post('/eliminaciones/filtrareliminacion', [EliminacionController::class, 'filtrarEliminacion'])->name('eliminaciones.filtrarEliminacion');
    });

    /*Rutas Reciclaje 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado']], function () {
        Route::resource('reciclajes', ReciclajeController::class);
        Route::post('/reciclajes/obtenerDatosProducto', [ReciclajeController::class, 'obtenerDatosProducto'])->name('reciclajes.obtenerDatosProducto');
        Route::post('/reciclajes/agregarDetalle', [App\Http\Controllers\ReciclajeController::class, 'agregarDetalle'])->name('reciclajes.agregarDetalle');
        Route::post('/reciclajes/eliminarDetalle', [ReciclajeController::class, 'eliminarDetalle'])->name('reciclajes.eliminarDetalle');
        Route::post('/reciclajes/registrarReciclaje', [ReciclajeController::class, 'registrarReciclaje'])->name('reciclajes.registrarReciclaje');
        Route::post('/reciclajes/actualizarReciclaje', [App\Http\Controllers\ReciclajeController::class, 'actualizarReciclaje'])->name('reciclajes.actualizarReciclaje');
        Route::post('/reciclajes/filtrar', [App\Http\Controllers\ReciclajeController::class, 'filtrarreciclaje'])->name('reciclajes.filtrarreciclaje');
    });


    /*Rutas Eliminacion 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado']], function () {
        Route::resource('traspasos', TraspasoController::class);
        Route::get('/traspasos', [App\Http\Controllers\TraspasoController::class, 'index'])->name('traspasos.index');
        Route::post('/traspasos/agregarDetalle', [App\Http\Controllers\TraspasoController::class, 'agregarDetalle'])->name('traspasos.agregarDetalle');
        Route::post('/traspasos/eliminarDetalle', [TraspasoController::class, 'eliminarDetalle'])->name('traspasos.eliminarDetalle');
        Route::post('/traspasos/obtenerDatosProducto', [TraspasoController::class, 'obtenerDatosProducto'])->name('traspasos.obtenerDatosProducto');
        Route::post('/traspasos/registrarTraspaso', [TraspasoController::class, 'registrarTraspaso'])->name('traspasos.registrarTraspaso');
        Route::post('/traspasos/actualizarTraspaso', [TraspasoController::class, 'actualizarTraspaso'])->name('traspasos.actualizarTraspaso');
        Route::post('/traspasos/filtrar', [TraspasoController::class, 'filtrartraspaso'])->name('traspasos.filtrartraspaso');
    });

    Route::resource('/costos_cuadriles', CostoCuadrilController::class);
    Route::post('/costos_cuadriles/registrarCajaChica', [App\Http\Controllers\CostoCuadrilController::class, 'registrarCajaChica'])->name('costos_cuadriles.registrarCajaChica');
    Route::post('/costos_cuadriles/agregarDetalle', [App\Http\Controllers\CostoCuadrilController::class, 'agregarDetalle'])->name('costos_cuadriles.agregarDetalle');
    Route::post('/costos_cuadriles/eliminarDetalle', [App\Http\Controllers\CostoCuadrilController::class, 'eliminarDetalle'])->name('costos_cuadriles.eliminarDetalle');
    Route::post('/costos_cuadriles/filtrarCortes', [CostoCuadrilController::class, 'filtrarCortes'])->name('costos_cuadriles.filtrarCortes');

    /* Keperis Rutas 1* */

        Route::get('/keperis', [App\Http\Controllers\KeperiController::class, 'index'])->name('keperis.index');
        Route::get('/keperis/create', [App\Http\Controllers\KeperiController::class, 'create'])->name('keperis.create');
        Route::post('/keperis', [App\Http\Controllers\KeperiController::class, 'store'])->name('keperis.store');
        Route::get('/keperis/edit/{id}', [App\Http\Controllers\KeperiController::class, 'edit'])->name('keperis.edit');
        Route::put('/keperis/{id}', [App\Http\Controllers\KeperiController::class, 'update'])->name('keperis.update');
        Route::get('/keperis/show/{id}', [App\Http\Controllers\KeperiController::class, 'show'])->name('keperis.show');
        Route::delete('/keperis/{id}', [\App\Http\Controllers\KeperiController::class, 'destroy'])->name('keperis.destroy');
        Route::post('/keperis/filtrarKeperis', [KeperiController::class, 'filtrarKeperis'])->name('keperis.filtrarKeperis');
        
 
    
    /*Rutas Reportes 1* */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado']], function () {
        Route::resource('traspasos', TraspasoController::class);
        Route::get('/traspasos', [App\Http\Controllers\TraspasoController::class, 'index'])->name('traspasos.index');
        Route::post('/traspasos/agregarDetalle', [App\Http\Controllers\TraspasoController::class, 'agregarDetalle'])->name('traspasos.agregarDetalle');
        Route::post('/traspasos/eliminarDetalle', [TraspasoController::class, 'eliminarDetalle'])->name('traspasos.eliminarDetalle');
        Route::post('/traspasos/obtenerDatosProducto', [TraspasoController::class, 'obtenerDatosProducto'])->name('traspasos.obtenerDatosProducto');
        Route::post('/traspasos/registrarTraspaso', [TraspasoController::class, 'registrarTraspaso'])->name('traspasos.registrarTraspaso');
        Route::post('/traspasos/actualizarTraspaso', [TraspasoController::class, 'actualizarTraspaso'])->name('traspasos.actualizarTraspaso');
    });

    /*Rutas 1*/
    Route::group(['middleware' => ['auth', 'role:Super Admin|Admin|Chef Corporativo']], function () {
        Route::get('/menus_semanales', [App\Http\Controllers\MenuSemanalController::class, 'index'])->name('menus_semanales.index');
        Route::get('/menus_semanales/create', [App\Http\Controllers\MenuSemanalController::class, 'create'])->name('menus_semanales.create');
        Route::post('/menus_semanales', [App\Http\Controllers\MenuSemanalController::class, 'store'])->name('menus_semanales.store');
        Route::get('/menus_semanales/edit/{id}', [App\Http\Controllers\MenuSemanalController::class, 'edit'])->name('menus_semanales.edit');

        Route::delete('/menus_semanales/{id}', [\App\Http\Controllers\MenuSemanalController::class, 'destroy'])->name('menus_semanales.destroy');
        Route::put('/menus_semanales/{id}', [App\Http\Controllers\MenuSemanalController::class, 'update'])->name('menus_semanales.update');
        Route::get('/menus_semanales/show/{id}', [App\Http\Controllers\MenuSemanalController::class, 'show'])->name('menus_semanales.show');
        Route::post('menus_semanales/create/agregarPlato', [App\Http\Controllers\MenuSemanalController::class, 'agregarPlato'])->name('menus_semanales.agregarPlato');
        Route::post('menus_semanales/create/eliminarPlato', [App\Http\Controllers\MenuSemanalController::class, 'eliminarPlato'])->name('menus_semanales.eliminarPlato');
        Route::post('menus_semanales/create/guardarPedido', [App\Http\Controllers\MenuSemanalController::class, 'store'])->name('menus_semanales.guardarPedido');
        Route::post('menus_semanales/create/obtenerDatosPlatos', [App\Http\Controllers\MenuSemanalController::class, 'obtenerDatosPlatos'])->name('menus_semanales.obtenerDatosPlatos');
        Route::get('/menus_semanales/create/reporte', [App\Http\Controllers\MenuSemanalController::class, 'reporteMenu'])->name('menus_semanales.reporteMenu');
        Route::post('/menus_semanales/create/actualizarMenu', [App\Http\Controllers\MenuSemanalController::class, 'actualizarMenu'])->name('menus_semanales.actualizarMenu');
        Route::post('/menus_semanales/menucalificacion', [App\Http\Controllers\MenuCalificacionController::class, 'agregarCalificacion'])->name('menus_semanales.agregarCalificacion');
        Route::get('/menus_semanales/vermenuevaluados/{id}', [App\Http\Controllers\MenuCalificacionController::class, 'verEvaluados'])->name('menus_semanales.verEvaluados');
        Route::get('/menus_semanales/menuGeneral', [App\Http\Controllers\MenuCalificacionController::class, 'menuGeneral'])->name('menus_semanales.menuGeneral');
        //menuGeneralw
    });

    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado|Contabilidad|Chef Corporativo']], function () {
        Route::get('/pedidos_producciones', [App\Http\Controllers\PedidoProduccionController::class, 'index'])->name('pedidos_producciones.index');
        Route::get('/pedidos_producciones/create', [App\Http\Controllers\PedidoProduccionController::class, 'create'])->name('pedidos_producciones.create');
        Route::post('/pedidos_producciones', [App\Http\Controllers\PedidoProduccionController::class, 'store'])->name('pedidos_producciones.store');
        Route::post('pedidos_producciones/create/guardarPedido', [App\Http\Controllers\PedidoProduccionController::class, 'store'])->name('pedidos_producciones.guardarPedido');
        Route::post('pedidos_producciones/create/obtenerCosto', [App\Http\Controllers\PedidoProduccionController::class, 'obtenerCosto'])->name('pedidos_producciones.obtenerCosto');
        Route::post('pedidos_producciones/create/obtenerCostoPlato', [App\Http\Controllers\PedidoProduccionController::class, 'obtenerCostoPlato'])->name('pedidos_producciones.obtenerCostoPlato');
        Route::post('pedidos_producciones/create/agregarPlato', [App\Http\Controllers\PedidoProduccionController::class, 'agregarPlato'])->name('pedidos_producciones.agregarPlato');
        Route::post('platos_sucursales/create/eliminarPlato', [App\Http\Controllers\PedidoProduccionController::class, 'eliminarPlato'])->name('pedidos_producciones.eliminarPlato');
        Route::get('/pedidos_producciones/show/{id}', [App\Http\Controllers\PedidoProduccionController::class, 'show'])->name('pedidos_producciones.show');
        Route::get('/pedidos_producciones/enviarInsumo/{id}', [App\Http\Controllers\PedidoProduccionController::class, 'editarInsumos'])->name('pedidos_producciones.editarInsumos');
        Route::post('/pedidos_producciones/obtenerprecio', [App\Http\Controllers\PedidoProduccionController::class, 'obtenerPrecioPlato'])->name('pedidos_producciones.obtenerPrecioPlato');
        Route::post('/pedidos_producciones/cambiarestado', [PedidoProduccionController::class, 'cambiarEstado'])->name('pedidos_producciones.cambiarEstado');
        Route::post('/pedidos_producciones/obtenerplato', [PedidoProduccionController::class, 'obtenerDatosPlato'])->name('pedidos_producciones.obtenerDatosPlato');

        
    });
    /* RUTA* */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad|Chef Corporativo']], function () {
        Route::get('/pedidos_producciones/edit/{id}', [App\Http\Controllers\PedidoProduccionController::class, 'edit'])->name('pedidos_producciones.edit');
        Route::delete('/pedidos_producciones/{id}', [\App\Http\Controllers\PedidoProduccionController::class, 'destroy'])->name('pedidos_producciones.destroy');
        Route::put('/pedidos_producciones/{id}', [App\Http\Controllers\PedidoProduccionController::class, 'update'])->name('pedidos_producciones.update');
        Route::post('/pedidos_producciones/actualizarPedidoEnviado', [PedidoProduccionController::class, 'actualizarPedidoEnviado'])->name('pedidos_producciones.actualizarPedidoEnviado');
        Route::get('/pedidos_producciones/VaucherPdf/{id}', [App\Http\Controllers\PedidoProduccionController::class, 'VaucherPdf'])->name('pedidos_producciones.VaucherPdf');
        Route::post('/pedidos_producciones/actualizarPedido', [PedidoProduccionController::class, 'actualizarPedido'])->name('pedidos_producciones.actualizarPedido');
        Route::get('/pedidos_producciones/reporteProduccion', [PedidoProduccionController::class, 'reporteProduccion'])->name('pedidos_producciones.reporteProduccion');
        Route::post('/pedidos_producciones/filtrarReporte', [PedidoProduccionController::class, 'filtrarReporte'])->name('pedidos_producciones.filtrarReporte');
        Route::post('/pedidos_producciones/filtrarPedidosProduccion', [PedidoProduccionController::class, 'filtrarPedidosProduccion'])->name('pedidos_producciones.filtrarPedidosProduccion');

        Route::get('/pedidos_producciones/reporteProduccionEnviada', [PedidoProduccionController::class, 'reporteProduccionEnviada'])->name('pedidos_producciones.reporteProduccionEnviada');
        Route::get('/pedidos_producciones/reporte_inventario', [App\Http\Controllers\PedidoProduccionController::class, 'reporte_inventario'])->name('pedidos_producciones.reporte_inventario');
    });
    /*RUTA Parte Produccion* */
    Route::group(['middleware' => ['auth', 'role:Super Admin|Encargado|Contabilidad|Chef Corporativo']], function () {
        Route::get('/partes_producciones', [App\Http\Controllers\ParteProduccionController::class, 'index'])->name('partes_producciones.index');
        Route::get('/partes_producciones/create', [App\Http\Controllers\ParteProduccionController::class, 'create'])->name('partes_producciones.create');
        Route::post('/partes_producciones', [App\Http\Controllers\ParteProduccionController::class, 'store'])->name('partes_producciones.store');
        Route::post('partes_producciones/create/guardarPedido', [App\Http\Controllers\ParteProduccionController::class, 'store'])->name('partes_producciones.guardarPedido');
        Route::post('partes_producciones/create/agregarInsumo', [App\Http\Controllers\ParteProduccionController::class, 'agregarInsumo'])->name('partes_producciones.agregarInsumo');
        Route::post('partes_producciones/create/obtenerPrecios', [App\Http\Controllers\ParteProduccionController::class, 'obtenerPrecios'])->name('partes_producciones.obtenerPrecios');
        Route::get('/partes_producciones/show/{id}', [App\Http\Controllers\ParteProduccionController::class, 'show'])->name('partes_producciones.show');
        Route::post('partes_producciones/eliminarInsumo', [App\Http\Controllers\ParteProduccionController::class, 'eliminarInsumo'])->name('partes_producciones.eliminarInsumo');
        Route::post('/partes_producciones/filtrarpartes_producciones', [ParteProduccionController::class, 'filtrarpartes_producciones'])->name('partes_producciones.filtrarpartes_producciones');
        Route::get('/partes_producciones/edit/{id}', [App\Http\Controllers\ParteProduccionController::class, 'edit'])->name('partes_producciones.edit');
        Route::delete('/partes_producciones/{id}', [\App\Http\Controllers\ParteProduccionController::class, 'destroy'])->name('partes_producciones.destroy');
        Route::put('/partes_producciones/{id}', [App\Http\Controllers\ParteProduccionController::class, 'update'])->name('partes_producciones.update');
        Route::post('partes_producciones/actualizarPedido', [App\Http\Controllers\ParteProduccionController::class, 'actualizarPedido'])->name('partes_producciones.actualizarPedido');
       
    });

    Route::post('/enviaremail', [App\Http\Controllers\MailController::class, 'sendEmail'])->name('mail.sendEmail');


    Route::group(['middleware' => ['auth', 'role:Super Admin|Contabilidad']], function () {
        Route::get('/manos_obras', [App\Http\Controllers\ManoObraController::class, 'index'])->name('manos_obras.index');
        Route::get('/manos_obras/create', [App\Http\Controllers\ManoObraController::class, 'create'])->name('manos_obras.create');
        Route::post('/manos_obras', [App\Http\Controllers\ManoObraController::class, 'store'])->name('manos_obras.store');
        Route::get('/manos_obras/show/{id}', [App\Http\Controllers\ManoObraController::class, 'show'])->name('manos_obras.show');
        Route::get('/manos_obras/edit/{id}', [App\Http\Controllers\ManoObraController::class, 'edit'])->name('manos_obras.edit');
        Route::put('/manos_obras/{id}', [App\Http\Controllers\ManoObraController::class, 'update'])->name('manos_obras.update');
        Route::post('manos_obras/create/agregarFuncionario', [App\Http\Controllers\ManoObraController::class, 'agregarFuncionario'])->name('manos_obras.agregarFuncionario');
        Route::post('manos_obras/eliminarFuncionario', [App\Http\Controllers\ManoObraController::class, 'eliminarFuncionario'])->name('manos_obras.eliminarFuncionario');
        Route::get('/manos_obras/reporteManoObraSucursal/', [App\Http\Controllers\ManoObraController::class, 'reporteManoObraSucursal'])->name('manos_obras.reporteManoObraSucursal');
        Route::get('/manos_obras/detalle_mo_sucursal/{sucursal_id}', [App\Http\Controllers\ManoObraController::class, 'detalle_mo_sucursal'])->name('manos_obras.detalle_mo_sucursal');
        
        
    });

    Route::group(['middleware' => ['auth', 'role:Super Admin']], function () {
        Route::get('/autorizaciones/index', [App\Http\Controllers\AutorizacionController::class, 'index'])->name('autorizacion.index');
        Route::get('/autorizaciones/formdosificacion', [App\Http\Controllers\AutorizacionController::class, 'create'])->name('autorizacion.create');
        Route::post('/autorizaciones/formdosificacion', [App\Http\Controllers\AutorizacionController::class, 'store'])->name('autorizacion.store');
        Route::get('/autorizaciones/reporteventas', [App\Http\Controllers\AutorizacionController::class, 'reporteVentas'])->name('autorizacion.reporteVentas');
        Route::get('/ventas/reportes/reporteTransacciones', [App\Http\Controllers\AutorizacionController::class, 'reporteTransacciones'])->name('autorizacion.reporteTransacciones');
        Route::get('/autorizaciones/verificar_codigo', [App\Http\Controllers\AutorizacionController::class, 'verificar_cod_control'])->name('autorizaciones.verificar_codigo');
        Route::get('/autorizaciones/ventas_fiscales', [App\Http\Controllers\AutorizacionController::class, 'ventas_fiscales'])->name('autorizaciones.ventas_fiscales');
        Route::get('/autorizaciones/ventas_fiscales', [App\Http\Controllers\AutorizacionController::class, 'ventas_fiscales'])->name('autorizaciones.ventas_fiscales');
          
        //reporteVentas
    });

    //formulariodoficacion
    Route::get('/reportes/ventas_sucursal', [App\Http\Controllers\VentaController::class, 'ventas_sucursal'])->name('ventas.ventas_sucursal');


    /* RUTAS FACTURACION EN LINEA */
    Route::get('/cuis/index', [App\Http\Controllers\Siat\CuisController::class, 'index'])->name('cuis.index');
    Route::get('/cuis/create', [App\Http\Controllers\Siat\CuisController::class, 'create'])->name('cuis.create');
    Route::post('/cuis', [App\Http\Controllers\Siat\CuisController::class, 'store'])->name('cuis.store');
    Route::get('/cufd/index', [App\Http\Controllers\Siat\CufdController::class, 'index'])->name('cufd.index');
    Route::get('/cufd/create', [App\Http\Controllers\Siat\CufdController::class, 'create'])->name('cufd.create');
    Route::post('/cufd/create', [App\Http\Controllers\Siat\CufdController::class, 'store'])->name('cufd.store');
    Route::delete('/cufd/{id}', [App\Http\Controllers\Siat\CufdController::class, 'destroy'])->name('cufd.destroy');

        /* REGISTRO PUNTO VENTA */
    Route::resource('puntos_ventas', RegistrarPuntoVentaController::class);

    /* Sincronizar Catalogos */
    Route::get('/sincronizar_catalogos/ejecutar_pruebas_catalogos', [App\Http\Controllers\Siat\SincronizarCatalogosController::class, 'ejecutar_pruebas_catalogos'])->name('sincronizar_catalogos.ejecutar_pruebas_catalogos');

    /* 5TA ETAPA EVENTOS SIGNIFICATIVOS */

    Route::get('/eventos_significativos/index', [App\Http\Controllers\Siat\EventoSignificativoController::class, 'index'])->name('eventos_significativos.index');
    Route::post('/eventos_significativos/filtrarEventosSignificativos', [\App\Http\Controllers\Siat\EventoSignificativoController::class, 'filtrarEventosSignificativos'])->name('eventos_significativos.filtrarEventosSignificativos');
    Route::post('generar_evento_significativo', [\App\Http\Controllers\Siat\EventoSignificativoController::class, 'generar_evento_significativo'])->name('eventos_significativos.generar_evento_significativo');  

    /* Anular Facturas */
    Route::get('/anulacion_facturas/index', [App\Http\Controllers\Siat\AnulacionFacturaController::class, 'index'])->name('anulacion_facturas.index');
    Route::post('/anulacion_facturas/filtrar_facturas', [AnulacionFacturaController::class, 'filtrar_facturas'])->name('anulacion_facturas.filtrar_facturas');
    Route::post('/anulacion_facturas/test_anulacion_factura', [App\Http\Controllers\Siat\AnulacionFacturaController::class, 'test_anulacion_factura'])->name('anulacion_facturas.test_anulacion_factura');    //filtrar_facturas


    

    Route::get('/chanchos', [App\Http\Controllers\ChanchoController::class, 'index'])->name('chanchos.index');
    Route::get('/chanchos/create', [App\Http\Controllers\ChanchoController::class, 'create'])->name('chanchos.create');
    Route::post('/chanchos', [App\Http\Controllers\ChanchoController::class, 'store'])->name('chanchos.store');
    Route::get('/chanchos/edit/{id}', [App\Http\Controllers\ChanchoController::class, 'edit'])->name('chanchos.edit');
    Route::put('/chanchos/{id}', [App\Http\Controllers\ChanchoController::class, 'update'])->name('chanchos.update');
    Route::get('/chanchos/show/{id}', [App\Http\Controllers\ChanchoController::class, 'show'])->name('chanchos.show');
    Route::delete('/chanchos/{id}', [\App\Http\Controllers\ChanchoController::class, 'destroy'])->name('chanchos.destroy');
    Route::post('/chanchos/filtrarChanchos', [\App\Http\Controllers\ChanchoController::class, 'filtrarChanchos'])->name('chanchos.filtrarChanchos');


