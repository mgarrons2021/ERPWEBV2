@extends('layouts.app', ['activePage' => 'productos¨_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Productos Asignados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-primary" href="{{route('productos_proveedores.create')}}">Asignar precio </a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff; text-align: center;"> Producto</th>
                                    <th style="color: #fff; text-align: center;">Precio </th>
                                    <th style="color: #fff; text-align: center;">Proveedor </th>
                                    <th style="color: #fff; text-align: center;">Estado del Precio</th>
                                    {{-- <th style="color: #fff; text-align: center;">Estado de la Solicitud de Cambio</th> --}}
                                    <th style="color: #fff; text-align: center;">Fecha Asignación</th>
                                    <th style="color: #fff; text-align: center;"></th>
                                </thead>
                                <tbody>
                                    @foreach ($productos_proveedores as $producto_proveedor)

                                    <tr>
                                        <td style="text-align: center;">
                                            <a href="{{route('productos_proveedores.show', $producto_proveedor->id)}}">{{$producto_proveedor->producto->nombre}} </a>
                                        </td>
                                        <td style="text-align: center;">{{$producto_proveedor->precio}} Bs</td>
                                        <td style="text-align: center;">{{$producto_proveedor->proveedor->nombre}}</td>
                                        <td style="text-align: center;">
                                            @if($producto_proveedor->estado=="" || !isset($producto_proveedor->estado))
                                            <div class="badge badge-pill badge-danger">Sin Estado</div>
                                            @endif
                                            
                                            @if($producto_proveedor->estado=="Habilitado")
                                            <div class="badge badge-pill badge-success">Habilitado</div>
                                            @endif
                                            
                                            @if($producto_proveedor->estado=="Deshabilitado")
                                            <div class="badge badge-pill badge-warning">Deshabilitado</div>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{$producto_proveedor->fecha}}</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('productos_proveedores.verSolicitudes', $producto_proveedor->id) }}">Ver Historial de Solicitudes</a></li>
                                                    <li><a class="dropdown-item " href="{{ route('productos_proveedores.solicitudCambioPrecioView', $producto_proveedor->id) }}">Solicitud de Cambio</a></li>
                                                    <li><a class="dropdown-item " href="{{ route('productos_proveedores.edit', $producto_proveedor->id) }}">Editar</a></li>
                                                    <li>
                                                        <form action="{{route('productos_proveedores.index',$producto_proveedor->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@if (session('solicitud') == 'false')
<script>
    iziToast.warning({
        title: 'WARNING',
        message: "El producto no necesita autorizacion",
        position: 'topRight',
    });
</script>
@endif
@if (session('editar') == 'false')
<script>
    iziToast.warning({
        title: 'WARNING',
        message: "Debe hacer una solicitud previa",
        position: 'topRight',
    });
</script>
@endif


@section('page_js')
<script>
    $('#table').DataTable({

        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningun dato disponible en esta tabla",
            sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Ãšltimo",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Activar para ordenar la columna de manera ascendente",
                sSortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        },
        columnDefs: [{
                orderable: false,
                targets: 5
            },

        ]
    });
</script>
@endsection
@endsection