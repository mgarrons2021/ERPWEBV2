<ul class="sidebar-menu sidebar">
        <li class="dropdown {{ $activePage == 'home' ? ' active' : '' }}">
                <a href="{{ route('home') }}"><i class="fas fa-home titulo"></i><span class="titulo">Panel Principal</span></a>
        </li>

        @role('Super Admin|Contabilidad')
        <li class="dropdown {{ $activePage === 'proveedores' ? ' active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users titulo"></i> <span class="titulo">Administracion</span></a>
                <ul class="dropdown-menu ">
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('cargos.index') }}" class="nav-link" href="layout-transparent.html">Cargos</a></li>
                        <li class="nav-item{{ $activePage == 'proveedores' ? ' active' : '' }}"><a href="{{ route('proveedores.index') }}" class="nav-link" href="layout-transparent.html">Proveedores</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('roles.index') }}" class="nav-link" href="layout-transparent.html">Roles</a></li>
                </ul>
        </li>
        @endrole


        @role('Super Admin|Contabilidad')
        <li class="dropdown {{ $activePage === 'formulario' ? ' active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users titulo"></i> <span class="titulo">Ventas</span></a>
                <ul class="dropdown-menu ">
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('autorizacion.index') }}" class="nav-link">Registro de Dosificacion</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('autorizacion.reporteVentas') }}" class="nav-link">Reporte de Ventas</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('autorizacion.reporteTransacciones') }}" class="nav-link">Reporte de Transacciones</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('autorizaciones.verificar_codigo') }}" class="nav-link">Verificar Codigo Control</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('autorizaciones.ventas_fiscales') }}" class="nav-link">Reporte Ventas Fiscales</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('pedidos_producciones.reporte_inventario') }}" class="nav-link">Reporte Inventario Fiscal</a></li>
                        <li class="nav-item{{ $activePage == 'roles' ? ' active' : '' }}"><a href="{{ route('horarios.planillaHorarios') }}" class="nav-link">Planilla Horario</a></li>



                </ul>
        </li>
        @endrole


        @role('Super Admin|Contabilidad|Encargado')
        <li class="dropdown {{ $activePage === 'categorias' || $activePage === 'productos' || $activePage === 'productos_proveedores'? ' active': '' }}">
                <a href="inventario" class="nav-link has-dropdown "><i class="fas fa-archive"></i><span>Gestion Sucursales</span></a>
                <ul class="dropdown-menu">
                        @role('Super Admin|Contabilidad')
                        <li class="nav-item{{ $activePage == 'categorias' ? ' active' : '' }}"><a href="{{ route('categorias.index') }}">Categorias</a></li>
                        <li class="nav-item{{ $activePage == 'productos' ? ' active' : '' }}"><a href="{{ route('productos.index') }}">Productos</a></li>
                        <li class="nav-item{{ $activePage == 'productos_proveedores' ? ' active' : '' }}"><a href="{{ route('productos_proveedores.index') }}">Asignar Precio </a></li>
                        <li class="nav-item{{ $activePage == 'asignar_stock' ? ' active' : '' }}"><a href="{{ route('asignar_stock.index') }}">Asignar Stock </a></li>
                        @endrole
                        <li class="nav-item{{ $activePage == 'inventarios' ? ' active' : '' }}"><a href="{{ route('inventarios.index') }}">Inventarios </a></li>
                        <li class="nav-item{{ $activePage == 'eliminaciones' ? ' active' : '' }}"><a href="{{ route('eliminaciones.index') }}">Eliminacion</a></li>
                        <li class="nav-item{{ $activePage == 'eliminaciones' ? ' active' : '' }}"><a href="{{ route('reciclajes.index') }}">Reciclaje</a></li>
                        <li class="nav-item{{ $activePage == 'traspasos' ? ' active' : '' }}"><a href="{{ route('traspasos.index') }}">Traspaso</a></li>
                        <li class="nav-item{{ $activePage == 'partes_producciones' ? ' active' : '' }}"><a href="{{ route('partes_producciones.index') }}">Parte Produccion </a></li>
                </ul>
        </li>
        @endrole


        @role('Super Admin')
        <li class="dropdown {{ $activePage === 'categorias' || $activePage === 'platos' || $activePage === 'platos'? ' active': '' }}">
                <a href="inventario" class="nav-link has-dropdown "><i class="fas fa-hamburger"></i><span>Menu Semanal</span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item{{ $activePage == 'categorias_plato' ? ' active' : '' }}"><a href="{{ route('menus_semanales.index') }}">Menu Semanal</a></li>
                        <li class="nav-item{{ $activePage == 'categorias_plato' ? ' active' : '' }}"><a href="{{ route('categorias_platos.index') }}">Categorias</a></li>
                        <li class="nav-item{{ $activePage == 'platos' ? ' active' : '' }}"><a href="{{ route('platos.index') }}">Platos</a></li>
                        <li class="nav-item{{ $activePage == 'precio_sucursales' ? ' active' : '' }}"><a href="{{ route('platos_sucursales.index') }}">Precio Sucursales</a></li>

                </ul>
        </li>
        @endrole


        @role('Super Admin|Encargado|Contabilidad|Chef Corporativo')
        <li class="dropdown {{ $activePage === 'categorias' || $activePage === 'platos' || $activePage === 'platos'? ' active': '' }}">
                <a href="inventario" class="nav-link has-dropdown "><i class="fas fa-shopping-basket"></i><span>Pedidos</span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item{{ $activePage == 'categorias_plato' ? ' active' : '' }}"><a href="{{ route('pedidos.index') }}">Pedidos Insumos</a></li>
                        <li class="nav-item{{ $activePage == 'categorias_plato' ? ' active' : '' }}"><a href="{{ route('pedidos_producciones.index') }}">Pedidos Produccion</a></li>

                        @role('Chef Corporativo|Super Admin')
                        <li class="nav-item{{ $activePage == 'categorias_plato' ? ' active' : '' }}"><a href="{{ route('pedidos.pedido_especial') }}">Insumos Cdp</a></li>

                        <li class="nav-item{{ $activePage == 'categorias_plato' ? ' active' : '' }}"><a href="{{ route('pedidos_producciones.index') }}">Produccion Cdp</a></li>
                        @endrole

                        @role('Super Admin|Contabilidad')
                        <li class="nav-item "> <a href="{{ route('pedidos.reporteZumos') }}">Hoja de Zumos y Salzas </a> </li>
                        <li class="nav-item "> <a href="{{route('pedidos_producciones.reporteProduccion')}}">Hoja de Produccion </a> </li>
                        <li class="nav-item "> <a href="{{route('asignar_stock.reporteCarnicos')}}">Hoja de Carnes </a> </li>
                        <li class="nav-item "> <a href="{{route('pedidos_producciones.reporteProduccionEnviada')}}">Produccion Enviada </a> </li>
                        <li class="nav-item "> <a href="{{route('keperis.index')}}">Control Keperi </a> </li>
                        <li class="nav-item "> <a href="{{route('costos_cuadriles.index')}}">Cortes Cuadriles </a> </li>
                        @endrole
                </ul>
        </li>
        @endrole

        @role('Super Admin|RRHH|Contabilidad|Encargado')

        <li class="dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-user-friends"></i><span> Gestion </span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item "> <a href="{{ route('personales.reporteMarcadoAsistencia') }}">Marcado de Asistencia </a> </li>
                        @role('Super Admin|RRHH')
                        <li class="nav-item{{ $activePage == 'personales' ? ' active' : '' }}"><a class="nav-link " href="{{ route('personales.index') }}">Personales</a></li>
                        <li class="nav-item{{ $activePage == 'postulantes' ? ' active' : '' }}"><a class="nav-link " href="{{ route('postulantes.index') }}">Postulantes</a></li>
                        <li class="nav-item{{ $activePage == 'contratos' ? ' active' : '' }}"><a class="nav-link " href="{{ route('contratos.index') }}">Contratos</a></li>
                        <li class="nav-item{{ $activePage == 'bonos' ? ' active' : '' }}"><a class="nav-link" href="{{ route('bonos.index') }}">Bonos</a></li>
                        <li class="nav-item{{ $activePage == 'descuentos' ? ' active' : '' }}"><a class="nav-link" href="{{ route('descuentos.index') }}">Descuentos</a></li>
                        <li class="nav-item{{ $activePage == 'sanciones' ? ' active' : '' }}"><a class="nav-link" href="{{ route('sanciones.index') }}">Sanciones</a></li>
                        <li class="nav-item{{ $activePage == 'vacaciones' ? ' active' : '' }}"><a class="nav-link" href="{{ route('vacaciones.index') }}">Vacaciones</a></li>
                        <li class="nav-item{{ $activePage == 'observaciones' ? ' active' : '' }}"><a class="nav-link" href="{{ route('observaciones.index') }}">Observaciones</a></li>
                        <li class="nav-item{{ $activePage == 'observaciones' ? ' active' : '' }}"><a class="nav-link" href="{{ route('manos_obras.reporteManoObraSucursal') }}">MO Sucursales</a></li>
                        <li class="nav-item{{ $activePage == 'horario' ? ' active' : '' }}"><a class="nav-link" href="{{ route('horarios.planillaHorarios') }}">Carga Horaria</a></li>

                        <li class="nav-item "> <a href="{{ route('personales.vencimientoContratos') }}">Vencimiento de Contratos </a> </li>
                        @endrole
                </ul>
        </li>

        @endrole

        @role('Super Admin')
        <li class="dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-cogs"></i><span> Mantenimiento </span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item{{ $activePage == 'mantenimiento' ? ' active' : '' }}"><a class="nav-link " href="{{ route('mantenimiento.index') }}">Registro</a></li>
                        <li class="nav-item{{ $activePage == 'mantenimiento' ? ' active' : '' }}"><a class="nav-link " href="{{ route('mantenimiento.index') }}">Detalle</a></li>
                </ul>
        </li>
        @endrole


        @role('Super Admin|Contabilidad|Encargado' )
        <li class="dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-shopping-cart"></i> <span> Contabilidad</span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item "> <a href="{{ route('compras.index') }}">Compras </a> </li>
                        <li class="nav-item "> <a href="{{ route('cajas_chicas.index') }}">Caja Chica</a> </li>
                        @role('Super Admin|Contabilidad' )
                        <li class="nav-item "> <a href="{{ route('categorias_caja_chica.index') }}">Cat. Caja Chica</a> </li>
                        <li class="nav-item "> <a href="{{ route('pagos.index') }}">Pagos </a> </li>
                        <li class="nav-item "> <a href="{{ route('contabilidad.reporteProveedores') }}">Compras y Pagos</a> </li>
                        <li class="nav-item "> <a href="{{ route('contabilidad.reporteCajaChica') }}">Reporte de Caja Chica</a> </li>
                        @endrole
                </ul>
        </li>
        @endrole

        @role('Super Admin|Almacen|RRHH|Contabilidad|Atencion|Encargado')
        <li class="dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-building"></i> <span> Sucursales</span></a>
                @role('Super Admin|Contabilidad|Encargado|Almacen|RRHH')
                <ul class="dropdown-menu">
                        @role('Super Admin|Contabilidad|RRHH')
                        <li class="nav-item "> <a href="{{ route('retrasosFaltas.index') }}"> Retrasos y Faltas </a> </li>
                        <li class="nav-item "> <a href="{{route('tareas.index')}}"> Actividades </a> </li>
                        <li class="nav-item "> <a href="{{ route('manos_obras.index') }}"> Costo mano de Obra </a> </li>
                        <li class="nav-item "> <a href="{{ route('evaluaciones.index') }}"> Criterios Evaluación </a> </li>

                        <li class="nav-item "> <a href="{{ route('personales.mostrarUsuarios') }}">Sgmt. de Actividades</a> </li>
                        <li class="nav-item "> <a href="{{ route('menus_semanales.reporteMenu') }}">Reporte Menu </a> </li>
                        @endrole
                        <li class="nav-item "> <a href="{{route('personales.listaTareas')}}"> Mis Tareas </a> </li>
                        <li class="nav-item "> <a href="{{ route('personales.listaevaluaciones') }}"> Evaluaciones </a> </li>
                </ul>
                @endrole
        </li>
        @endrole

        <li class="dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-bookmark"></i> <span>Reportes</span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item"> <a href="{{ route('ventas.ventas_sucursal') }}">Ventas por Sucursal</a> </li>
                </ul>

        </li>
        @role('Super Admin')
        <li class="dropdown">
                <a href="" class="nav-link has-dropdown"><i class="fas fa-bookmark"></i> <span>Siat</span></a>
                <ul class="dropdown-menu">
                        <li class="nav-item"> <a href="{{ route('cuis.index') }}">Cuis</a> </li>
                        <li class="nav-item"> <a href="{{ route('cufd.index') }}">Cufd</a> </li>
                        <li class="nav-item"> <a href="{{ route('puntos_ventas.index') }}">Punto Venta</a> </li>
                        <li class="nav-item"> <a href="{{ route('eventos_significativos.index') }}">Registro Contingencias</a> </li>
                        <li class="nav-item"> <a href="{{ route('anulacion_facturas.index') }}">Anular Facturas</a> </li>
                       
                </ul>
        </li>
        @endrole