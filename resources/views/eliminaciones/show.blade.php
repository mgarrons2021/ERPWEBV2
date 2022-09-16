@extends('layouts.app', ['activePage' => 'eliminaciones', 'titlePage' => 'Eliminaciones'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Eliminacion Nro: {{ $eliminacion->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos Generales de la Eliminacion</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tbody>
                                    <tr>
                                        <th>Fecha de eliminacion:</th>
                                        <td>{{ $eliminacion->fecha }}</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{$eliminacion->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{ $eliminacion->sucursal->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Turno:</th>
                                        <td>{{ $eliminacion->turno->turno  }}</td>
                                    </tr>
                                    @if(isset($eliminacion->inventario->id))
                                    <tr>
                                        <th> Inventario del Que se Elimino:</th>
                                        <td>Numero {{ $eliminacion->inventario->id }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th> ¿ Tiene Eliminacion ?</th>
                                        @if ($eliminacion->estado=="Con Eliminacion")
                                        <td> <span class="badge badge-info">Con Eliminacion</span></td>
                                        @endif
                                        @if ($eliminacion->estado=="Sin Eliminacion")
                                        <td><span class="badge badge-info">Sin Eliminacion</span></td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de la Eliminacion</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <th style="text-align: center;"> Insumo </th>
                                <th style="text-align: center;"> UM </th>
                                <th style="text-align: center;"> Cantidad Eliminada </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Observacion </th>
                                <th style="text-align: center;"> Subtotal </th>
                            </thead>
                            <tbody>
                                @foreach($eliminacion->detalles_eliminacion as $detalle)
                                <tr>
                                    @if(isset($detalle->producto->nombre))
                                    <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->producto->unidad_medida_compra->nombre}}</td>
                                    @endif
                                    @if(isset($detalle->plato->nombre))
                                    <td style="text-align: center;">{{$detalle->plato->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->plato->unidad_medida_compra->nombre}}</td>
                                    @endif
                                    <td style="text-align: center;"> {{ number_format($detalle->cantidad,2) }}</td>
                                    <td style="text-align: center;"> {{$detalle->precio}} Bs. </td>
                                    <td style="text-align: center;"> {{$detalle->observacion}}</td>
                                    <td style="text-align: center;"> {{$detalle->subtotal}} Bs. </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="5" style="text-align: center;"> Total Eliminacion</td>
                                <td colspan="1" style="text-align: center;"> {{$eliminacion->total}} Bs. </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{ route('eliminaciones.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter"> Editar </a>
        </div>
    </div>
</section>
@endsection

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