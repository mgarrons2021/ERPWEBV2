@extends('layouts.app', ['activePage' => 'cuis', 'titlePage' => 'cuis'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Cuis</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('cuis.create')}}">Nuevo Cuis</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Cuis Generado</th>
                                    <th style="color: #fff;text-align:center">Fecha de Creacion</th>
                                    <th style="color: #fff;text-align:center">Fecha de Expiracion</th>
                                    <th style="color: #fff;text-align:center">Estado</th>
                                </thead>
                                <tbody>
                                    @foreach ($cuis as $cui)
                                    <tr>
                                        <td style="text-align:center">{{$cui->sucursal->nombre}}</td>
                                        <td style="text-align:center">{{$cui->codigo_cui}}</td>
                                        <td style="text-align:center">{{$cui->fecha_generado}}</td>
                                        <td style="text-align:center">{{$cui->fecha_expiracion}}</td>
                                        <td style="text-align:center">
                                            @if($cui->estado=='V')
                                            <span class="badge badge-success">Vigente</span>
                                            @else
                                            <span class="badge badge-danger">Caducado</span>
                                            @endif
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