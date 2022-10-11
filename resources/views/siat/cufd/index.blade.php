@extends('layouts.app', ['activePage' => 'cuis', 'titlePage' => 'cuis'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro Generados Cufds Siat</h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('cufd.create')}}">Nuevo Cufd</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">ID</th>
                                    <th style="color: #fff;text-align:center">Fecha de Creacion</th>
                                    <th style="color: #fff;text-align:center">Fecha de Expiracion</th>
                                    <th style="color: #fff;text-align:center">Codigo Generado</th>
                                    <th style="color: #fff;text-align:center">Codigo </th>

                                    <th style="color: #fff;text-align:center">Estado</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($cufds as $cufd)
                                    <tr>
                                        <td style="text-align:center">{{$cufd->id}}</td>
                                        <td style="text-align:center">{{$cufd->fecha_generado}}</td>
                                        <td style="text-align:center">{{$cufd->fecha_vigencia}}</td>
                                        <td style="text-align:center">{{$cufd->codigo}}</td>
                                        <td style="text-align:center">{{$cufd->codigo_control}}</td>

                                        @if ($cufd->estado=='V')
                                        <td style="text-align:center"><span class="badge badge-success">Activo</span></td>
                                        @endif
                                        @if ($cufd->estado=='N')
                                        <td style="text-align:center"><span class="badge badge-warning">Vencido</span></td>
                                        @endif
                                        <td style="text-align:center">{{$cufd->sucursal->nombre}}</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                                    <li>
                                                        <form action="{{route('cufd.destroy',$cufd->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar Cufd</a>
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
            },
        },

    });
</script>
@endsection
@endsection