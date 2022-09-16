@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'productos_proveedores'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Historial de Solicitudes de Cambio de Precio</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-body">
                    <table class="table table-bordered table-striped " id="table">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Producto</th>
                                <th style="text-align: center;">Fecha</th>
                                <th style="text-align: center;">Estado</th>
                                <th style="text-align: center;">Motivo de Cambio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($solicitudes as $solicitud)
                            <tr>
                                <td style="text-align: center;">{{$solicitud->producto_proveedor->producto->nombre}}</td>
                                <td style="text-align: center;">{{$solicitud->fecha}}</td>
                                <td style="text-align: center;">
                                    @if($solicitud->estado=="PENDIENTE")
                                    <div class="badge badge-pill badge-danger">{{$solicitud->estado}}</div>
                                    @endif
                                    @if($solicitud->estado=="ACEPTADO")
                                    <div class="badge badge-pill badge-success">{{$solicitud->estado}}</div>
                                    @endif
                                </td>
                                <td style="text-align: center;">{{$solicitud->motivo_cambio}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="button-container ">
                        <a href="{{ route('productos_proveedores.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@section('scripts')
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

    });
</script>


@endsection


@endsection