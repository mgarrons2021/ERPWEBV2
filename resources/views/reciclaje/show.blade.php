@extends('layouts.app', ['activePage' => 'eliminaciones', 'titlePage' => 'Eliminaciones'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reciclaje Nro: {{ $reciclaje->id }} </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Datos Generales del Reciclaje</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="table">
                                <tbody>
                                    <tr>
                                        <th>Fecha de reciclaje:</th>
                                        <td> {{$reciclaje->fecha}}</td>
                                    </tr>
                                    <tr>
                                        <th> Usuario:</th>
                                        <td>{{$reciclaje->user->name}}</td>
                                    </tr>
                                    <tr>
                                        <th> Sucursal:</th>
                                        <td>{{ $reciclaje->sucursal->nombre  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Turno:</th>
                                        <td>{{ $reciclaje->turno->turno  }}</td>
                                    </tr>
                                    <tr>
                                        <th> Inventario:</th>
                                        <td>Numero {{ $reciclaje->inventario->id }}</td>
                                    </tr>
                                    <tr>

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
                        <h4>Detalles del reciclaje</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <th style="text-align: center;"> Producto </th>
                                <th style="text-align: center;"> U.M. </th>
                                <th style="text-align: center;"> Cantidad Eliminada </th>
                                <th style="text-align: center;"> Costo </th>
                                <th style="text-align: center;"> Observacion </th>
                                <th style="text-align: center;"> Subtotal </th>
                            </thead>
                            <tbody>
                                @foreach($reciclaje->detalles_reciclaje as $detalle)
                                <tr>
                                    @if(isset($detalle->producto->nombre))
                                    <td style="text-align: center;" class="table-light">{{$detalle->producto->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                    @endif
                                    @if(isset($detalle->plato->nombre))
                                    <td style="text-align: center;" class="table-light">{{$detalle->plato->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->plato->unidad_medida_venta->nombre}}</td>
                                    @endif

                                    <td style="text-align: center;"> {{ number_format($detalle->cantidad,2) }}</td>
                                    <td style="text-align: center;"> {{$detalle->precio}} Bs. </td>
                                    <td style="text-align: center;"> {{$detalle->observacion}}</td>
                                    <td style="text-align: center;"> {{$detalle->subtotal}} Bs. </td>
                                </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <td colspan="5" style="text-align: center;" class="table-light"> Total Reciclaje</td>
                                <td colspan="1" style="text-align: center;" class="table-light"> {{$reciclaje->total}} Bs. </td>
                            </tfoot>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{route('reciclajes.index')}}" class="btn btn-warning"> Volver </a>
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