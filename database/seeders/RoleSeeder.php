<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
  
  public function run()                      
  {
    $role1 =  Role::create(['name' => 'Super Admin']);
    $role2 =  Role::create(['name' => 'Admin']);
    $role3 =  Role::create(['name' => 'Encargado']);
    $role4 =  Role::create(['name' => 'RRHH']);
    $role5 =  Role::create(['name' => 'Contabilidad']);
    //                                                                                                            
    $permission1 = Permission::create(['name' => 'home', 'description' => 'Dashboard']);

    $permission2 = Permission::create(['name' => 'proveedores.index', 'description' => 'Ver Proveedores']);
    $permission3 = Permission::create(['name' => 'proveedores.create', 'description' => 'Crear nuevo Proveedor']);
    $permission4 = Permission::create(['name' => 'proveedores.store', 'description' => 'Guarda Proveedor']);
    $permission5 = Permission::create(['name' => 'proveedores.edit', 'description' => 'Editar Proveedor']);
    $permission6 = Permission::create(['name' => 'proveedores.update', 'description' => 'Actualizar Proveedor']);
    $permission7 = Permission::create(['name' => 'proveedores.destroy', 'description' => 'Eliminar Proveedor']);
    $permission8 = Permission::create(['name' => 'proveedores.show', 'description' => 'Ver Info Proveedor']);

    $permission9 =  Permission::create(['name' => 'productos.index', 'description' => 'Ver Productos']);
    $permission10 = Permission::create(['name' => 'productos.create', 'description' => 'Crear nuevo Producto']);
    $permission11 = Permission::create(['name' => 'productos.store', 'description' => 'Guardar Producto']);
    $permission12 = Permission::create(['name' => 'productos.edit', 'description' => 'Editar Producto']);
    $permission13 = Permission::create(['name' => 'productos.update', 'description' => 'Actualizar Producto']);
    $permission14 = Permission::create(['name' => 'productos.destroy', 'description' => 'Eliminar Producto']);
    $permission15 = Permission::create(['name' => 'productos.show', 'description' => 'Info detallada del Producto']);


    $permission16 = Permission::create(['name' => 'encargados.index', 'description' => 'Ver Encargados']);
    $permission17 = Permission::create(['name' => 'encargados.create', 'description' => 'Nuevo Encargado']);
    $permission18 = Permission::create(['name' => 'encargados.store', 'description' => 'Guardar Encargado']);
    $permission19 = Permission::create(['name' => 'encargados.edit', 'description' => 'Editar Encargado']);
    $permission20 = Permission::create(['name' => 'encargados.update', 'description' => 'Actualizar Encargado']);
    $permission21 = Permission::create(['name' => 'encargados.destroy', 'description' => 'Eliminar Encargado']);
    $permission22 = Permission::create(['name' => 'encargados.show', 'description' => 'Info detallada del Encargado']);

    $permission22 = Permission::create(['name' => 'sucursales.index', 'description' => 'Ver Sucursal']);
    $permission23 = Permission::create(['name' => 'sucursales.create', 'description' => 'Crear Sucursal']);
    $permission24 = Permission::create(['name' => 'sucursales.store', 'description' => 'Guardar Sucursal']);
    $permission25 = Permission::create(['name' => 'sucursales.edit', 'description' => 'Editar Sucursal']);
    $permission26 = Permission::create(['name' => 'sucursales.update', 'description' => 'Actualizar Sucursal']);
    $permission27 = Permission::create(['name' => 'sucursales.destroy', 'description' => 'Eliminar Sucursal']);
    $permission28 = Permission::create(['name' => 'sucursales.show', 'description' => 'Info detallada de Sucursal']);

    $permission29 = Permission::create(['name' => 'categorias.index', 'description' => 'Ver Categorias']);
    $permission30 = Permission::create(['name' => 'categorias.create', 'description' => 'Crear Categoria']);
    $permission31 = Permission::create(['name' => 'categorias.store', 'description' => 'Guardar Categoria']);
    $permission32 = Permission::create(['name' => 'categorias.edit', 'description' => 'Editar Categoria']);
    $permission33 = Permission::create(['name' => 'categorias.update', 'description' => 'Actualizar Categoria']);
    $permission34 = Permission::create(['name' => 'categorias.destroy', 'description' => 'Eliminar Categoria']);
    $permission35 = Permission::create(['name' => 'categorias.show', 'description' => 'Mostrar Categoria']);

    $permission36 = Permission::create(['name' => 'productos_proveedores.index', 'description' => 'Ver Producto Proovedor']);
    $permission37 = Permission::create(['name' => 'productos_proveedores.create', 'description' => 'Crear  Producto Proovedor']);
    $permission38 = Permission::create(['name' => 'productos_proveedores.store', 'description' => 'Guardar Producto Proovedor']);

    $permission39 = Permission::create(['name' => 'inventarios.index', 'description' => 'Inventarios']);
    $permission40 = Permission::create(['name' => 'inventarios.create', 'description' => 'Crear Inventarios']);
    $permission41 = Permission::create(['name' => 'inventarios.store', 'description' => 'Guardar Inventario']);


    $permission43 = Permission::create(['name' => 'contratos.index', 'description' => 'Contratos']);
    $permission44 = Permission::create(['name' => 'contratos.create', 'description' => ' Crear nuevo Contrato']);
    $permission45 = Permission::create(['name' => 'contratos.store', 'description' => 'Guardar Contrato']);
    $permission46 = Permission::create(['name' => 'contratos.edit', 'description' => 'Editar Contrato']);
    $permission47 = Permission::create(['name' => 'contratos.update', 'description' => 'Actualizar Contrato']);
    $permission48 = Permission::create(['name' => 'contratos.destroy', 'description' => 'Eliminar Contrato']);
    $permission49 = Permission::create(['name' => 'contratos.show', 'description' => 'Mostrar Contratos']);

    $permission50 = Permission::create(['name' => 'departamentos.index', 'description' => 'Departamentos']);
    $permission51 = Permission::create(['name' => 'departamentos.create', 'description' => 'Crear nuevo Departamento']);
    $permission52 = Permission::create(['name' => 'departamentos.store', 'description' => ' Guardar Departamento']);
    $permission53 = Permission::create(['name' => 'departamentos.edit', 'description' => 'Editar Departamento']);
    $permission54 = Permission::create(['name' => 'departamentos.update', 'description' => 'Actualizar Departamento']);
    $permission55 = Permission::create(['name' => 'departamentos.destroy', 'description' => 'Eliminar Departamento']);
    $permission56 = Permission::create(['name' => 'departamentos.show', 'description' => 'Mostrar Departamento']);


    $permission57 = Permission::create(['name' => 'personales.index', 'description' => 'Informacion del usuario']);
    $permission58 = Permission::create(['name' => 'personales.create', 'description' => 'Crear nuevo usuario']);
    $permission62 = Permission::create(['name' => 'personales.destroy', 'description' => 'Eliminar Usuario']);

    $permission59 = Permission::create(['name' => 'personales.contratar', 'description' => 'Contratar nuevo personal']);
    $permission60 = Permission::create(['name' => 'personales.showDetalleContrato', 'description' => 'Ver Contrato del Personal']);
    $permission61 = Permission::create(['name' => 'personales.editContratoUser', 'description' => 'Editar Contrato del Personal']);

    $permission63 = Permission::create(['name' => 'personales.editDatosBasicos', 'description' => 'Editar datos basicos Usuario']);

    $permission64 = Permission::create(['name' => 'personales.actualizarContratoUser', 'description' => 'Actualizar Contrato del Personal']);
    $permission65 = Permission::create(['name' => 'personales.actualizarDatosBasicos', 'description' => 'Actualizar datos Basicos']);
    $permission66 = Permission::create(['name' => 'personales.vencimientoContratos', 'description' => 'Ver vencimiento de contratos']);
    $permission67 = Permission::create(['name' => 'personales.filtrarContratos', 'description' => 'Reporte y filtro de contratos']);
    $permission68 = Permission::create(['name' => 'personales.cronologiaPersonales', 'description' => 'Ver la cronologia de usuarios']);
    $permission69 = Permission::create(['name' => 'personales.asignarCargo', 'description' => 'Asignar nuevos cargos']);
    $permission70 = Permission::create(['name' => 'personales.saveAsignarCargo', 'description' => 'Guardar nuevos cargos']);



    /*      $permission68=Permission::create(['name'=>'encargados.update']);
      $permission69=Permission::create(['name'=>'encargados.destroy']);
      $permission70=Permission::create(['name'=>'encargados.show']);*/

    $permission71 = Permission::create(['name' => 'cargos.index', 'description' => 'Cargos']);
    $permission72 = Permission::create(['name' => 'cargos.create', 'description' => 'Crear nuevo Cargo']);
    $permission73 = Permission::create(['name' => 'cargos.store', 'description' => 'Guardar Cargo']);
    $permission74 = Permission::create(['name' => 'cargos.edit', 'description' => 'Editar Cargo']);
    $permission75 = Permission::create(['name' => 'cargos.update', 'description' => 'Actualizar Cargo']);
    $permission76 = Permission::create(['name' => 'cargos.destroy', 'description' => 'Eliminar Cargos']);
    $permission77 = Permission::create(['name' => 'cargos.show', 'description' => 'Mostrar Cargos']);


    $permission85 = Permission::create(['name' => 'horarios.index', 'description' => 'Horarios']);
    $permission86 = Permission::create(['name' => 'horarios.create', 'description' => 'Crear Horario']);
    $permission87 = Permission::create(['name' => 'horarios.store', 'description' => 'Guardar Horario']);

    $permission88 = Permission::create(['name' => 'horarios.obtenerSucursal', 'description' => 'Obtener Horario Sucursal']);
    $permission89 = Permission::create(['name' => 'horarios.funcionarios', 'description' => 'Ver Funcionarios']);
    $permission90 = Permission::create(['name' => 'horarios.reporteHorario', 'description' => 'Ver Reporte Mano de Obra']);
    $permission91 = Permission::create(['name' => 'horarios.planillaHorarios', 'description' => 'Ver Planilla de Horarios']);

    $permission93 = Permission::create(['name' => 'horarios.obtenerFuncionarios', 'description' => 'Obtener horarios de funcionarios']);

    $permission94 = Permission::create(['name' => 'bonos.index', 'description' => 'Bonos']);
    $permission95 = Permission::create(['name' => 'bonos.create', 'description' => 'Crear Bono']);
    $permission96 = Permission::create(['name' => 'bonos.store', 'description' => 'Guardar Bono']);
    $permission97 = Permission::create(['name' => 'bonos.edit', 'description' => 'Editar Bono']);
    $permission98 = Permission::create(['name' => 'bonos.update', 'description' => 'Actualizar Bono']);
    $permission99 = Permission::create(['name' => 'bonos.destroy', 'description' => 'Eliminar Bono']);
    $permission100 = Permission::create(['name' => 'bonos.show', 'description' => 'Mostrar Bonos']);

    $permission101 = Permission::create(['name' => 'descuentos.index', 'description' => 'Descuentos']);
    $permission102 = Permission::create(['name' => 'descuentos.create', 'description' => 'Crear Descuento']);
    $permission103 = Permission::create(['name' => 'descuentos.store', 'description' => 'Guardar Descuento']);
    $permission104 = Permission::create(['name' => 'descuentos.edit', 'description' => 'Editar Descuento']);
    $permission105 = Permission::create(['name' => 'descuentos.update', 'description' => 'Actualizar Descuento']);
    $permission106 = Permission::create(['name' => 'descuentos.destroy', 'description' => 'Eliminar Descuento']);
    $permission107 = Permission::create(['name' => 'descuentos.show', 'description' => 'Mostrar Descuento']);

    $permission108 = Permission::create(['name' => 'sanciones.index', 'description' => 'Sanciones']);
    $permission109 = Permission::create(['name' => 'sanciones.create', 'description' => 'Crear Sancion']);
    $permission110 = Permission::create(['name' => 'sanciones.store', 'description' => 'Guardar Sancion']);
    $permission111 = Permission::create(['name' => 'sanciones.edit', 'description' => 'Editar Sancion']);
    $permission112 = Permission::create(['name' => 'sanciones.update', 'description' => 'Actualizar Sancion']);
    $permission113 = Permission::create(['name' => 'sanciones.destroy', 'description' => 'Eliminar Sancion']);
    $permission114 = Permission::create(['name' => 'sanciones.show', 'description' => 'Ver Sanciones']);

    $permission116 = Permission::create(['name' => 'vacaciones.create', 'description' => 'Crear Vacaciones']);
    $permission115 = Permission::create(['name' => 'vacaciones.index', 'description' => 'Ver Vacaciones']);
    $permission117 = Permission::create(['name' => 'vacaciones.store', 'description' => 'Guardar Vacaciones']);
    $permission118 = Permission::create(['name' => 'vacaciones.edit', 'description' => 'Editar Vacaciones']);
    $permission119 = Permission::create(['name' => 'vacaciones.update', 'description' => 'Actualizar Vacaciones']);
    $permission120 = Permission::create(['name' => 'vacaciones.destroy', 'description' => 'Eliminar Vacaciones']);
    $permission121 = Permission::create(['name' => 'vacaciones.show', 'description' => 'Mostrar Vacaciones']);
    $permission122 = Permission::create(['name' => 'inventario', 'description' => 'Menu Inventario']);

    $permission123 = Permission::create(['name' => 'compras.index', 'description' => 'Ver Compras']);
    $permission124 = Permission::create(['name' => 'compras.detalleCompra', 'description' => 'Ver Detalle Compra']);
    $permission125 = Permission::create(['name' => 'compras.create', 'description' => 'Guardar Compra']);

    $permission126 = Permission::create(['name' => 'pagos.index', 'description' => 'Ver Pagos']);
    $permission127 = Permission::create(['name' => 'pagos.create', 'description' => 'Guardar Pago']);

    $permission128 = Permission::create(['name' => 'retrasosFaltas.index', 'description' => 'Ver Retrasos']);
    $permission129 = Permission::create(['name' => 'retrasosFaltas.create', 'description' => 'Crear Retrasos']);
    $permission130 = Permission::create(['name' => 'retrasosFaltas.show', 'description' => 'Ver Detalle Retrasos']);
    $permission131 = Permission::create(['name' => 'retrasosFaltas.destroy', 'description' => 'Eliminar Retrasos']);

    $permission132 = Permission::create(['name' => 'personales.listaTareas', 'description' => 'Lista de Tareas']);
    $permission133 = Permission::create(['name' => 'personales.saveTareas', 'description' => 'Guardar Tareas']);
    $permission134 = Permission::create(['name' => 'personales.reporteTareas', 'description' => 'Reporte de Tareas']);
    $permission135 = Permission::create(['name' => 'personales.actividadesUsuario', 'description' => 'Actividades de Usuario']);


    $permission136 = Permission::create(['name' => 'personales_contratos.update', 'description' => 'Actualizar Contrato del Personal']);
    $permission137 = Permission::create(['name' => 'personales_contratos.eliminar', 'description' => 'Eliminar contratos de personal']);
    $permission138 = Permission::create(['name' => 'personales_vacaciones.agregarVacacion', 'description' => 'Agregar vacaciones al personal']);
    $permission139 = Permission::create(['name' => 'personales_vacaciones.guardarVacacion', 'description' => 'Guardar las vacaciones del personal']);
    $permission140 = Permission::create(['name' => 'personales.editDescountUser', 'description' => 'Editar descuento de usuarios']);
    $permission141 = Permission::create(['name' => 'personales.editSanctionsUser', 'description' => 'Editar sanciones de usuarios']);
    $permission142 = Permission::create(['name' => 'personales.reporteEvaluaciones', 'description' => 'Ver reporte de evalucaciones de personal']);
    $permission143 = Permission::create(['name' => 'personales.evaluacionesUsuario', 'description' => 'Evaluar usuarios']);
    $permission144 = Permission::create(['name' => 'personales.filtrarEvaluacionUsuario', 'description' => 'Filtrar evaluaciones de usuario']);
    $permission145 = Permission::create(['name' => 'personales_contratos.edit', 'description' => 'Editar contratos']);

    $permission146 = Permission::create(['name' => 'personales.filtrarActividades', 'description' => 'Filtrar actividades del personal']);
    $permission147 = Permission::create(['name' => 'personales.reporteMarcadoAsistencia', 'description' => 'Reporte de marcar asistencia del personal']);
    $permission148 = Permission::create(['name' => 'personales.filtrarMarcadoAsistencia', 'description' => 'Filtrar marcado de asistencia del personal']);
    $permission149 = Permission::create(['name' => 'personales.assignTurnView', 'description' => 'Asignar turnos de personal vista GET']);
    $permission150 = Permission::create(['name' => 'personales.assignTurn', 'description' => 'Aignar turnos de personal POST']);
    $permission151 = Permission::create(['name' => 'personales.listaevaluaciones', 'description' => 'Listar evaluaciones del personal']);
    $permission152 = Permission::create(['name' => 'personales.guardarEvaluaciones', 'description' => 'Guardar evaluaciones del personal']);
    $permission153 = Permission::create(['name' => 'personales.reporteSeguimientoActividades', 'description' => 'Reporte de las actividades del personal']);
    $permission154 = Permission::create(['name' => 'personales.mostrarUsuarios', 'description' => 'Mostrar usuarios ']);


    $permission156 = Permission::create(['name' => 'compras.registrarCompra', 'description' => 'Registrar compras']);
    $permission157 = Permission::create(['name' => 'compras.obtenerproductos', 'description' => 'Obtener productos para compras']);
    $permission158 = Permission::create(['name' => 'compras.obtenerprecios', 'description' => 'Obtener precios de compras']);
    $permission159 = Permission::create(['name' => 'compras.guardarDetalle', 'description' => 'Guardar detalle de compras']);
    $permission160 = Permission::create(['name' => 'compras.eliminarDetalle', 'description' => 'Eliminar detalle de compras']);
    $permission161 = Permission::create(['name' => 'compras.filtrarCompras', 'description' => 'Filtrar compras']);
    $permission162 = Permission::create(['name' => 'compras.download-pdf', 'description' => 'Decargar pdf de compras']);

    $permission163 = Permission::create(['name' => 'pagos.filtrarPagos', 'description' => 'Filtrar pagos']);
    $permission164 = Permission::create(['name' => 'pagos.download-pdf', 'description' => 'Descargar pdf de pagos']);
    $permission165 = Permission::create(['name' => 'contabilidad.reporteProveedores', 'description' => 'Reporte de proveedores']);
    $permission166 = Permission::create(['name' => 'contabilidad.filtrarComprasyPagos', 'description' => 'Filtrar compras y pagos']);
    $permission167 = Permission::create(['name' => 'contabilidad.reporteCajaChica', 'description' => 'Reporte de caja chica']);
    $permission168 = Permission::create(['name' => 'contabilidad.filtrarCajaChica', 'description' => 'Filtrar caja chica']);
    $permission169 = Permission::create(['name' => 'contabilidad.detalleComprasyPagos', 'description' => 'Detalle de compras y pagos']);

    $permission170 = Permission::create(['name' => 'tareas.actualizar', 'description' => 'Actualizar tareas']);

    $permission171 = Permission::create(['name' => 'evaluaciones.actualizar', 'description' => 'Actualizar evaluaciones']);

    $permission172 = Permission::create(['name' => 'platos.index', 'description' => 'Pagina principal de platos']);
    $permission173 = Permission::create(['name' => 'platos.asignarReceta', 'description' => 'Asignar receta del plato']);
    $permission174 = Permission::create(['name' => 'platos.create', 'description' => 'Crear nuevos platos visual  ']);
    $permission175 = Permission::create(['name' => 'platos.store', 'description' => ' Crear nuevos platos no visual ']);
    $permission176 = Permission::create(['name' => 'platos.edit', 'description' => ' Editar los platos ']);
    $permission177 = Permission::create(['name' => 'platos.destroy', 'description' => ' Eliminar platos ']);
    $permission178 = Permission::create(['name' => 'platos.update', 'description' => ' Actualizar los platos ']);
    $permission179 = Permission::create(['name' => 'platos.show', 'description' => ' Ver los platos ']);
    $permission180 = Permission::create(['name' => 'platos.showPdf', 'description' => ' Ver y decargar pdf de los platos ']);

    $permission181 = Permission::create(['name' => 'platos_sucursales.index', 'description' => ' Vista parcial de platos_sucursales ']);
    $permission182 = Permission::create(['name' => 'platos_sucursales.create', 'description' => ' Crear platos_sucursales  vista']);
    $permission183 = Permission::create(['name' => 'platos_sucursales.store', 'description' => ' Crear platos_sucursales no vista']);
    $permission184 = Permission::create(['name' => 'platos_sucursales.edit', 'description' => ' Editar  platos_sucursales vista']);
    $permission185 = Permission::create(['name' => 'platos_sucursales.destroy', 'description' => ' Eliminar  platos_sucursales no vista']);
    $permission186 = Permission::create(['name' => 'platos_sucursales.update', 'description' => ' Actualizar platos_sucursales no vista']);
    $permission187 = Permission::create(['name' => 'platos_sucursales.filtrarPlatos', 'description' => ' Filtrar platos_sucursales no vista']);
    $permission188 = Permission::create(['name' => 'platos_sucursales.enviarPlato', 'description' => ' Enviar plato a platos_sucursales no vista']);
    $permission189 = Permission::create(['name' => 'platos_sucursales.eliminarPlato', 'description' => 'Eliminar plato de platos_sucursales no vista ']);
    $permission190 = Permission::create(['name' => 'platos_sucursales.guardarPlato', 'description' => ' Guardar platos_sucursales ']);
    $permission191 = Permission::create(['name' => 'platos_sucursales.obtenerPlato', 'description' => ' Obtener platos_sucursales ']);
    $permission192 = Permission::create(['name' => 'platos_sucursales.eliminarDetalle', 'description' => ' Eliminar detalle de platos_sucursales']);

    $permission193 = Permission::create(['name' => 'recetas.index', 'description' => ' Vista de todas las recetas']);
    $permission194 = Permission::create(['name' => 'recetas.create', 'description' => 'Crear nueva receta vista ']);
    $permission195 = Permission::create(['name' => 'recetas.obtenerplatos', 'description' => 'Obtener platos de las recetas no vista ']);
    $permission196 = Permission::create(['name' => 'recetas.obtenerproductos', 'description' => ' Obtener productos de recetas no vista']);
    $permission197 = Permission::create(['name' => 'recetas.obtenerprecio', 'description' => ' Obtener precio de recetas productos no vista']);
    $permission198 = Permission::create(['name' => 'recetas.store', 'description' => ' Crear nueva receta no vista']);
    $permission199 = Permission::create(['name' => 'recetas.show', 'description' => ' Ver una receta en especifico']);
    $permission200 = Permission::create(['name' => 'recetas.agregarDetalle', 'description' => ' Agregar detalle de receta no vista']);
    $permission201 = Permission::create(['name' => 'recetas.eliminarDetalle', 'description' => ' Eliinar detalle de recetas']);
    $permission202 = Permission::create(['name' => 'recetas.registrarReceta', 'description' => ' Registrar receta']);
    $permission203 = Permission::create(['name' => 'recetas.edit', 'description' => ' Editar receta vista']);
    $permission204 = Permission::create(['name' => 'recetas.actualizarReceta', 'description' => ' Editar receta no vista']);

    $permission205 = Permission::create(['name' => 'cajas_chicas.registrarCajaChica', 'description' => ' Registrar caja chica']);
    $permission206 = Permission::create(['name' => 'cajas_chicas.agregarDetalle', 'description' => ' Agregar detalle de caja chica']);
    $permission207 = Permission::create(['name' => 'cajas_chicas.eliminarDetalle', 'description' => ' Eliminar detalle de caja chica']);

    $permission208 = Permission::create(['name' => 'categorias_caja_chica.index', 'description' => 'Vista parcial de categorias de caja chica  ']);
    $permission209 = Permission::create(['name' => 'categorias_caja_chica.create', 'description' => 'Crear nueva categoria de caja chica vista  ']);
    $permission210 = Permission::create(['name' => 'categorias_caja_chica.store', 'description' => 'Crear nueva categoria de caja chica no vista  ']);
    $permission211 = Permission::create(['name' => 'categorias_caja_chica.edit', 'description' => 'Editar categoria de caja chica vista  ']);
    $permission212 = Permission::create(['name' => 'categorias_caja_chica.update', 'description' => ' Editar categoria de caja chica no vista ']);
    $permission213 = Permission::create(['name' => 'categorias_caja_chica.show', 'description' => ' Ver registro de una categoria especifica de caja chica ']);
    $permission214 = Permission::create(['name' => 'categorias_caja_chica.destroy', 'description' => ' Eliminar categoria de caja chica']);

    $permission215 = Permission::create(['name' => 'mantenimiento.registrarCajaChica', 'description' => 'Registrar caja chica para mantenimiento']);
    $permission216 = Permission::create(['name' => 'mantenimiento.agregarDetalle', 'description' => ' Agregar detalle para mantenimiento']);
    $permission217 = Permission::create(['name' => 'mantenimiento.eliminarDetalle', 'description' => ' Eliminar detalle de mantenimiento']);

    $permission218 = Permission::create(['name' => 'eliminaciones.agregarDetalle', 'description' => ' Agregar detalle de eliminaciones']);
    $permission219 = Permission::create(['name' => 'eliminaciones.eliminarDetalle', 'description' => 'Eliminar detalle de eliminaciones ']);
    $permission220 = Permission::create(['name' => 'eliminaciones.obtenerDatosProducto', 'description' => 'Obtener productos de eliminaciones ']);
    $permission221 = Permission::create(['name' => 'eliminaciones.registrarEliminacion', 'description' => 'Registrar eliminacion en eliminaciones']);
    $permission222 = Permission::create(['name' => 'eliminaciones.actualizarEliminacion', 'description' => 'Actualizar eliminacion en eliminaciones']);

    $permission223 = Permission::create(['name' => 'reciclajes.obtenerDatosProducto', 'description' => 'Obtener atos producto de reciclaje']);
    $permission224 = Permission::create(['name' => 'reciclajes.agregarDetalle', 'description' => 'Agregar detalle para reciclajes']);
    $permission225 = Permission::create(['name' => 'reciclajes.eliminarDetalle', 'description' => 'Eliminar detalle para reciclajes']);
    $permission226 = Permission::create(['name' => 'reciclajes.registrarReciclaje', 'description' => 'Registrar nuevo reciclaje']);
    $permission227 = Permission::create(['name' => 'reciclajes.actualizarReciclaje', 'description' => 'Actualizar reciclaje']);

    $permission228 = Permission::create(['name' => 'traspasos.index', 'description' => ' Vista parcial de de traspasos']);
    $permission229 = Permission::create(['name' => 'traspasos.agregarDetalle', 'description' => 'Agregar detalle a un traspaso']);
    $permission230 = Permission::create(['name' => 'traspasos.eliminarDetalle', 'description' => 'Eliminar detalle de un traspaso']);
    $permission231 = Permission::create(['name' => 'traspasos.obtenerDatosProducto', 'description' => 'Obtener datos de producto de un traspaso']);
    $permission232 = Permission::create(['name' => 'traspasos.registrarTraspaso', 'description' => 'Registrar nuevo traspaso']);
    $permission233 = Permission::create(['name' => 'traspasos.actualizarTraspaso', 'description' => 'Actualizar traspaso']);

    $permission234 = Permission::create(['name' => 'costos_cuadriles.registrarCajaChica', 'description' => 'Registrar caja chica de costos_cuadriles']);
    $permission235 = Permission::create(['name' => 'costos_cuadriles.agregarDetalle', 'description' => 'Agregar detalle de costos_cuadriles']);
    $permission236 = Permission::create(['name' => 'costos_cuadriles.eliminarDetalle', 'description' => 'Eliminar detalle de costos_cuadriles']);

    $permission237 = Permission::create(['name' => 'keperis.index', 'description' => 'Visa parcial de keperi']);
    $permission238 = Permission::create(['name' => 'keperis.create', 'description' => 'Crear nuevo keperi vista']);
    $permission239 = Permission::create(['name' => 'keperis.store', 'description' => 'Crear nuevo keperi no vista']);
    $permission240 = Permission::create(['name' => 'keperis.edit', 'description' => 'Editar nuevo keperi vista']);
    $permission241 = Permission::create(['name' => 'keperis.update', 'description' => 'Editar nuevo keperi no vista']);
    $permission242 = Permission::create(['name' => 'keperis.show', 'description' => 'Ver un keperi en especifico']);
    $permission243 = Permission::create(['name' => 'keperis.destroy', 'description' => 'Eliminar un keperi']);

    $permission244 = Permission::create(['name' => 'menus_semanales.index', 'description' => 'Vista parcial del menu semanal']);
    $permission245 = Permission::create(['name' => 'menus_semanales.create', 'description' => 'Crear un nuevo menu semanal vista']);
    $permission246 = Permission::create(['name' => 'menus_semanales.store', 'description' => 'Agregar un nuevo menu semanal no vista']);
    $permission247 = Permission::create(['name' => 'menus_semanales.edit', 'description' => 'Editar un menu semanal vista']);
    $permission248 = Permission::create(['name' => 'menus_semanales.destroy', 'description' => 'Eliminar un menu semanal']);
    $permission249 = Permission::create(['name' => 'menus_semanales.update', 'description' => 'Actualizar un menu semanal no vista']);
    $permission250 = Permission::create(['name' => 'menus_semanales.show', 'description' => 'Ver un menu semanal']);
    $permission251 = Permission::create(['name' => 'menus_semanales.agregarPlato', 'description' => 'Agregar plato a un menu semanal']);
    $permission252 = Permission::create(['name' => 'menus_semanales.eliminarPlato', 'description' => 'Eliminar plato de un menu semanal']);
    $permission253 = Permission::create(['name' => 'menus_semanales.guardarPedido', 'description' => 'Guardar pedido de un menu semanal']);
    $permission254 = Permission::create(['name' => 'menus_semanales.obtenerPrecios', 'description' => 'Obtener precios de un menu semanal']);

    $permission255 = Permission::create(['name' => 'pedidos_producciones.index', 'description' => 'Vista parcial de pedidos_producciones']);
    $permission256 = Permission::create(['name' => 'pedidos_producciones.create', 'description' => 'Crear un nuevo pedidos_producciones vista']);
    $permission257 = Permission::create(['name' => 'pedidos_producciones.store', 'description' => 'Crear un nuevo pedidos_producciones no vista']);
    $permission258 = Permission::create(['name' => 'pedidos_producciones.edit', 'description' => 'Editar pedidos_producciones vista']);
    $permission259 = Permission::create(['name' => 'pedidos_producciones.destroy', 'description' => 'Eliminar pedidos_producciones']);
    $permission260 = Permission::create(['name' => 'pedidos_producciones.update', 'description' => 'Actualizar pedidos_producciones no vista']);
    $permission261 = Permission::create(['name' => 'pedidos_producciones.show', 'description' => 'Ver pedidos_producciones especificamente']);
    $permission262 = Permission::create(['name' => 'pedidos_producciones.VaucherPdf', 'description' => 'Ver vaucherpdf de pedidos_producciones']);
    $permission263 = Permission::create(['name' => 'pedidos_producciones.actualizarPedido', 'description' => 'Actualizar pedido de pedidos_producciones']);
    $permission264 = Permission::create(['name' => 'pedidos_producciones.agregarPlato', 'description' => 'Agregar plato a pedidos_producciones']);
    $permission265 = Permission::create(['name' => 'pedidos_producciones.eliminarPlato', 'description' => 'Eliminar plato de pedidos_producciones']);
    $permission266 = Permission::create(['name' => 'pedidos_producciones.guardarPedido', 'description' => 'Guardar pedido de pedidos_producciones']);
    $permission267 = Permission::create(['name' => 'pedidos_producciones.obtenerCosto', 'description' => 'Obtener costo para pedidos_producciones']);

    $permission268 = Permission::create(['name' => 'pedidos.index', 'description' =>  'Vista parcial de pedidos']);
    $permission269 = Permission::create(['name' => 'pedidos.create', 'description' => 'Crear pedidos vista ']);
    $permission270 = Permission::create(['name' => 'pedidos.store', 'description' => ' Crear pedidos no vista']);
    $permission271 = Permission::create(['name' => 'pedidos.edit', 'description' => ' Editar pedidos vista']);
    $permission272 = Permission::create(['name' => 'pedidos.destroy', 'description' => 'Eliminar pedidos ']);
    $permission273 = Permission::create(['name' => 'pedidos.update', 'description' => ' Actualizar pedidos no vista']);
    $permission274 = Permission::create(['name' => 'pedidos.show', 'description' => ' Ver pedidos especificamente']);
    $permission275 = Permission::create(['name' => 'pedidos.VaucherPdf', 'description' => ' Ver vaucher pdf pedidos']);
    $permission276 = Permission::create(['name' => 'pedidos.actualizarPedido', 'description' => ' Actualizar pedido']);
    $permission277 = Permission::create(['name' => 'pedidos.filtrarZumos', 'description' => ' Filtrar zumos ']);
    $permission278 = Permission::create(['name' => 'pedidos.reporteZumos', 'description' => ' Sacar reporte de zumos']);
    $permission279 = Permission::create(['name' => 'pedidos.guardarPedido', 'description' => ' Guardar pedido ']);
    $permission280 = Permission::create(['name' => 'pedidos.obtenerPrecios', 'description' => ' Obtener precios de productos']);
    $permission281 = Permission::create(['name' => 'pedidos.agregarInsumo', 'description' => ' Agregar insumo para pedidos']);
    $permission282 = Permission::create(['name' => 'pedidos.eliminarInsumo', 'description' => ' Eliminar insumo ']);

    $permission283 = Permission::create(['name' => 'roles.index', 'description' => 'Ver Roles']);
    $permission284 = Permission::create(['name' => 'roles.create', 'description' => 'Crear nuevo Rol']);
    $permission285 = Permission::create(['name' => 'roles.store', 'description' => 'Guarda Rol']);
    $permission286 = Permission::create(['name' => 'roles.edit', 'description' => 'Editar Rol']);
    $permission287 = Permission::create(['name' => 'roles.update', 'description' => 'Actualizar Rol']);
    $permission288 = Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar Rol']);
    $permission289 = Permission::create(['name' => 'roles.show', 'description' => 'Ver Info Rol']);

    $permission290 = Permission::create(['name' => 'inventarios.obtenerInsumos', 'description' => 'Obtener insumos ']);
    $permission291 = Permission::create(['name' => 'inventarios.guardarDetalleInventario', 'description' => ' Guardar detalle de inventario']);
    $permission292 = Permission::create(['name' => 'inventarios.eliminarDetalle', 'description' => ' Eliminar detalle de inventario']);
    $permission293 = Permission::create(['name' => 'inventarios.obtenerUM', 'description' => ' Obtener unidad de medida de inventario']);
    $permission294 = Permission::create(['name' => 'inventarios.registrarInventario', 'description' => ' Registrar inventario ']);
    $permission295 = Permission::create(['name' => 'inventarios.actualizarInventario', 'description' => ' Actualizar inventario']);
    $permission296 = Permission::create(['name' => 'inventarios.obtenerPrecios', 'description' => ' Obtener precios de inventario']);
    $permission297 = Permission::create(['name' => 'inventarios.obtenerProductosxId', 'description' => ' Obtener productos por id de inventarios']);

    $permission298 = Permission::create(['name' => 'inventarios.edit', 'description' => 'Editar Inventario']);

    $permission299 = Permission::create(['name' => 'partes_producciones.index', 'description' => 'Index parte producciones']);
    $permission300 = Permission::create(['name' => 'partes_producciones.create', 'description' => 'Crear partes produccionesitar Inventario']);
    $permission301 = Permission::create(['name' => 'partes_producciones.store', 'description' => 'Crear partes producciones no vista']);
    $permission302 = Permission::create(['name' => 'partes_producciones.guardarPedido', 'description' => 'Guardar pedido de partes producciones']);
    $permission303 = Permission::create(['name' => 'partes_producciones.agregarInsumo', 'description' => 'Agregar insumo a partes producciones']);
    $permission304 = Permission::create(['name' => 'partes_producciones.obtenerPrecios', 'description' => 'Obtener precios de partes producciones']);
    $permission305 = Permission::create(['name' => 'partes_producciones.show', 'description' => 'Ver registro de partes producciones']);
    $permission306 = Permission::create(['name' => 'partes_producciones.eliminarInsumo', 'description' => 'Eliminar insumo de partes producciones']);
    $permission307 = Permission::create(['name' => 'partes_producciones.edit', 'description' => 'Editar de partes de producciones']);
    $permission308 = Permission::create(['name' => 'partes_producciones.destroy', 'description' => 'Eliminar un registro de parte de producciones']);
    $permission309 = Permission::create(['name' => 'partes_producciones.update', 'description' => 'Actualizar registro de parte de producciones vista']);
    $permission310 = Permission::create(['name' => 'partes_producciones.actualizarPedido', 'description' => 'Editar registro de parte de producciones no vistaInventari']);



    $role5->syncPermissions(
      $permission299,
      $permission300,
      $permission301,
      $permission302,
      $permission303,
      $permission304,
      $permission305,
      $permission306,
      $permission307,
      $permission308,
      $permission309,
      $permission310,
      $permission2,
      $permission3,
      $permission4,
      $permission5,
      $permission6,
      $permission7,
      $permission8,
      $permission9,
      $permission10,
      $permission11,
      $permission12,
      $permission13,
      $permission14,
      $permission15,
      $permission29,
      $permission30,
      $permission31,
      $permission32,
      $permission33,
      $permission34,
      $permission35,
      $permission36,
      $permission37,
      $permission38,
      $permission39,
      $permission40,
      $permission41,
      $permission123,
      $permission124,
      $permission125,
      $permission126,
      $permission127,
    );

    $role1->syncPermissions(
      $permission299,
      $permission300,
      $permission301,
      $permission302,
      $permission303,
      $permission304,
      $permission305,
      $permission306,
      $permission307,
      $permission308,
      $permission309,
      $permission310,
      $permission298,
      $permission1,
      $permission2,
      $permission3,
      $permission4,
      $permission5,
      $permission6,
      $permission7,
      $permission8,
      $permission9,
      $permission10,
      $permission11,
      $permission12,
      $permission13,
      $permission14,
      $permission15,
      $permission16,
      $permission17,
      $permission18,
      $permission19,
      $permission20,
      $permission21,
      $permission22,
      $permission23,
      $permission24,
      $permission25,
      $permission26,
      $permission27,
      $permission28,
      $permission29,
      $permission30,
      $permission31,
      $permission32,
      $permission33,
      $permission34,
      $permission35,
      $permission36,
      $permission37,
      $permission38,
      $permission39,
      $permission40,
      $permission41,
      $permission43,
      $permission44,
      $permission45,
      $permission46,
      $permission47,
      $permission48,
      $permission49,
      $permission50,
      $permission51,
      $permission52,
      $permission53,
      $permission54,
      $permission55,
      $permission56,
      $permission57,
      $permission58,
      $permission59,
      $permission60,
      $permission61,
      $permission62,
      $permission63,
      $permission64,
      $permission65,
      $permission66,
      $permission67,
      $permission71,
      $permission72,
      $permission73,
      $permission74,
      $permission75,
      $permission76,
      $permission77,
      $permission85,
      $permission86,
      $permission87,
      $permission88,
      $permission89,
      $permission90,
      $permission91,
      $permission93,
      $permission94,
      $permission95,
      $permission96,
      $permission97,
      $permission98,
      $permission99,
      $permission100,
      $permission101,
      $permission102,
      $permission103,
      $permission104,
      $permission105,
      $permission106,
      $permission107,
      $permission108,
      $permission109,
      $permission110,
      $permission111,
      $permission112,
      $permission113,
      $permission114,
      $permission115,
      $permission116,
      $permission117,
      $permission118,
      $permission119,
      $permission120,
      $permission121,
      $permission122,
      $permission123,
      $permission124,
      $permission125,
      $permission126,
      $permission127,
      $permission128,
      $permission129,
      $permission130,
      $permission131,
      $permission132,
      $permission133,
      $permission134,
      $permission135,
      $permission136,
      $permission137,
      $permission138,
      $permission139,
      $permission140,
      $permission141,
      $permission142,
      $permission143,
      $permission144,
      $permission145,
      $permission146,
      $permission147,
      $permission148,
      $permission149,
      $permission150,
      $permission151,
      $permission152,
      $permission153,
      $permission154,
      $permission156,
      $permission157,
      $permission158,
      $permission159,
      $permission160,
      $permission161,
      $permission162,
      $permission163,
      $permission164,
      $permission165,
      $permission166,
      $permission167,
      $permission168,
      $permission169,
      $permission170,
      $permission171,
      $permission172,
      $permission173,
      $permission174,
      $permission175,
      $permission176,
      $permission177,
      $permission178,
      $permission179,
      $permission180,
      $permission181,
      $permission182,
      $permission183,
      $permission184,
      $permission185,
      $permission186,
      $permission187,
      $permission188,
      $permission189,
      $permission190,
      $permission191,
      $permission192,
      $permission193,
      $permission194,
      $permission195,
      $permission196,
      $permission197,
      $permission198,
      $permission199,
      $permission200,
      $permission201,
      $permission202,
      $permission203,
      $permission204,
      $permission205,
      $permission206,
      $permission207,
      $permission208,
      $permission209,
      $permission210,
      $permission211,
      $permission212,
      $permission213,
      $permission214,
      $permission215,
      $permission216,
      $permission217,
      $permission218,
      $permission219,
      $permission220,
      $permission221,
      $permission222,
      $permission223,
      $permission224,
      $permission225,
      $permission226,
      $permission227,
      $permission228,
      $permission229,
      $permission230,
      $permission231,
      $permission232,
      $permission233,
      $permission234,
      $permission235,
      $permission236,
      $permission237,
      $permission238,
      $permission239,
      $permission240,
      $permission241,
      $permission242,
      $permission243,
      $permission244,
      $permission245,
      $permission246,
      $permission247,
      $permission248,
      $permission249,
      $permission250,
      $permission251,
      $permission252,
      $permission253,
      $permission254,
      $permission255,
      $permission256,
      $permission257,
      $permission258,
      $permission259,
      $permission260,
      $permission261,
      $permission262,
      $permission263,
      $permission264,
      $permission265,
      $permission266,
      $permission267,
      $permission268,
      $permission269,
      $permission270,
      $permission271,
      $permission272,
      $permission273,
      $permission274,
      $permission275,
      $permission276,
      $permission277,
      $permission278,
      $permission279,
      $permission280,
      $permission281,
      $permission282,
      $permission283,
      $permission284,
      $permission285,
      $permission286,
      $permission287,
      $permission288,
      $permission289,
      $permission290,
      $permission291,
      $permission292,
      $permission293,
      $permission294,
      $permission295,
      $permission296,
      $permission297,

    );

    $role2->syncPermissions(
      $permission298,
      $permission1,
      $permission2,
      $permission3,
      $permission4,
      $permission5,
      $permission6,
      $permission7,
      $permission8,
      $permission9,
      $permission10,
      $permission11,
      $permission12,
      $permission13,
      $permission14,
      $permission15,
      $permission16,
      $permission17,
      $permission18,
      $permission19,
      $permission20,
      $permission21,
      $permission22,
      $permission23,
      $permission24,
      $permission25,
      $permission26,
      $permission27,
      $permission28,
      $permission29,
      $permission30,
      $permission31,
      $permission32,
      $permission33,
      $permission34,
      $permission35,
      $permission36,
      $permission37,
      $permission38,
      $permission39,
      $permission40,
      $permission41,
      $permission43,
      $permission44,
      $permission45,
      $permission46,
      $permission47,
      $permission48,
      $permission49,
      $permission50,
      $permission51,
      $permission52,
      $permission53,
      $permission54,
      $permission55,
      $permission56,
      $permission57,
      $permission58,
      $permission59,
      $permission60,
      $permission61,
      $permission62,
      $permission63,
      $permission64,
      $permission65,
      $permission66,
      $permission67,
      $permission71,
      $permission72,
      $permission73,
      $permission74,
      $permission75,
      $permission76,
      $permission77,
      $permission85,
      $permission86,
      $permission87,
      $permission88,
      $permission89,
      $permission90,
      $permission91,
      $permission93,
      $permission94,
      $permission95,
      $permission96,
      $permission97,
      $permission98,
      $permission99,
      $permission100,
      $permission101,
      $permission102,
      $permission103,
      $permission104,
      $permission105,
      $permission106,
      $permission107,
      $permission108,
      $permission109,
      $permission110,
      $permission111,
      $permission112,
      $permission113,
      $permission114,
      $permission115,
      $permission116,
      $permission117,
      $permission118,
      $permission119,
      $permission120,
      $permission121,
      $permission122,
      $permission123,
      $permission124,
      $permission125,
      $permission126,
      $permission127,
      $permission128,
      $permission129,
      $permission130,
      $permission131,
      $permission132,
      $permission133,
      $permission134,
      $permission135,
      $permission136,
      $permission137,
      $permission138,
      $permission139,
      $permission140,
      $permission141,
      $permission142,
      $permission143,
      $permission144,
      $permission145,
      $permission146,
      $permission147,
      $permission148,
      $permission149,
      $permission150,
      $permission151,
      $permission152,
      $permission153,
      $permission154,
      $permission156,
      $permission157,
      $permission158,
      $permission159,
      $permission160,
      $permission161,
      $permission162,
      $permission163,
      $permission164,
      $permission165,
      $permission166,
      $permission167,
      $permission168,
      $permission169,
      $permission170,
      $permission171,
      $permission172,
      $permission173,
      $permission174,
      $permission175,
      $permission176,
      $permission177,
      $permission178,
      $permission179,
      $permission180,
      $permission181,
      $permission182,
      $permission183,
      $permission184,
      $permission185,
      $permission186,
      $permission187,
      $permission188,
      $permission189,
      $permission190,
      $permission191,
      $permission192,
      $permission193,
      $permission194,
      $permission195,
      $permission196,
      $permission197,
      $permission198,
      $permission199,
      $permission200,
      $permission201,
      $permission202,
      $permission203,
      $permission204,
      $permission205,
      $permission206,
      $permission207,
      $permission208,
      $permission209,
      $permission210,
      $permission211,
      $permission212,
      $permission213,
      $permission214,
      $permission215,
      $permission216,
      $permission217,
      $permission218,
      $permission219,
      $permission220,
      $permission221,
      $permission222,
      $permission223,
      $permission224,
      $permission225,
      $permission226,
      $permission227,
      $permission228,
      $permission229,
      $permission230,
      $permission231,
      $permission232,
      $permission233,
      $permission234,
      $permission235,
      $permission236,
      $permission237,
      $permission238,
      $permission239,
      $permission240,
      $permission241,
      $permission242,
      $permission243,
      $permission244,
      $permission245,
      $permission246,
      $permission247,
      $permission248,
      $permission249,
      $permission250,
      $permission251,
      $permission252,
      $permission253,
      $permission254,
      $permission255,
      $permission256,
      $permission257,
      $permission258,
      $permission259,
      $permission260,
      $permission261,
      $permission262,
      $permission263,
      $permission264,
      $permission265,
      $permission266,
      $permission267,
      $permission268,
      $permission269,
      $permission270,
      $permission271,
      $permission272,
      $permission273,
      $permission274,
      $permission275,
      $permission276,
      $permission277,
      $permission278,
      $permission279,
      $permission280,
      $permission281,
      $permission282,
      $permission290,
      $permission291,
      $permission292,
      $permission293,
      $permission294,
      $permission295,
      $permission296,
      $permission297,
    );

    $role4->syncPermissions(
      $permission132,
      $permission133,
      $permission134,
      $permission135,
      $permission136,
      $permission137,
      $permission138,
      $permission139,
      $permission140,
      $permission141,
      $permission142,
      $permission143,
      $permission144,
      $permission145,
      $permission146,
      $permission147,
      $permission148,
      $permission149,
      $permission150,
      $permission151,
      $permission152,
      $permission153,
      $permission154,
      $permission43,
      $permission44,
      $permission45,
      $permission46,
      $permission47,
      $permission48,
      $permission49,
      $permission94, 
      $permission95 ,
      $permission96 ,
      $permission97 ,
      $permission98 ,
      $permission99 ,
      $permission100,
      $permission101,
      $permission102,
      $permission103,
      $permission104,
      $permission105,
      $permission106,
      $permission107,
      $permission108,
      $permission109,
      $permission110,
      $permission111,
      $permission112,
      $permission113,
      $permission114,
      $permission116,
      $permission115,
      $permission117,
      $permission118,
      $permission119,
      $permission120,
      $permission121,
      $permission122,


    );

    $role3->syncPermissions(
      $permission299,
      $permission300,
      $permission301,
      $permission302,
      $permission303,
      $permission304,
      $permission305,
      $permission306,
      $permission307,
      $permission308,
      $permission309,
      $permission310,
      $permission298,
      $permission39,
      $permission40,
      $permission41,
      $permission132,
      $permission290,
      $permission291,
      $permission293,
      $permission294,
      $permission296,
      $permission297,
      $permission223,
      $permission224,
      $permission226,
      $permission218,
      $permission220,
      $permission221,
      $permission228,
      $permission229,
      $permission231,
      $permission232,
      $permission153
    );

  }
}
