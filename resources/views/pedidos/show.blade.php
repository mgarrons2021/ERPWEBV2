@extends('layouts.app', ['activePage' => 'pedidos', 'titlePage' => 'Pedido'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pedido Nro: {{ $pedido->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalle del Pedido</h4>
                        {{-- <div class="col-xl-10 text-right">
                            <a href="{{ route('pedidos.download-pdf', $pedido->id) }}" class="btn btn-danger btn-sm">Exportar a PDF</a>
                    </div> --}}
                </div>
                <div class="card-body">
                    <div class="table-responsive"></div>
                    <table class="table table-bordered table-md">
                        <tbody>
                            @php
                            $hora = new DateTime($pedido->created_at);
                            $hora_solicitado = $hora->format('H:i:s');

                            @endphp

                            <tr>
                                <th>Fecha pedido:</th>
                                <td>{{$pedido->fecha_actual }}</td>
                            </tr>
                            <tr>
                                <th>Hora pedido:</th>
                                <td>{{ $hora_solicitado }}</td>
                            </tr>

                            <tr>
                                <th>Fecha Entrega:</th>
                                <td>{{ $pedido->fecha_pedido }}</td>
                            </tr>

                            <tr>
                                <th> Total Solicitado:</th>
                                <td>{{$pedido->total_solicitado}} Bs</td>
                            </tr>
                            <tr>
                                <th> Sucursal:</th>
                                <td>{{ $pedido->sucursal_principal->nombre  }}</td>
                            </tr>
                            <tr>
                                <th> Estado Pedido:</th>

                                @if ($pedido->estado == 'S' || $pedido->estado == 'P' || $pedido->estado == '0' )
                                        <th> Pendiente </span></th>
                                        @elseif($pedido->estado == 'E' || $pedido->estado == '1' )
                                        <th >
                                           En Espera 
                                        </th>
                                        @elseif($pedido->estado =='A')
                                        <th > Aceptado</th>
                                        @endif
                            </tr>
                            <tr>
                                <th> Realizado Por</th>
                                <td>{{$pedido->user->name}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detalles del Pedido</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="table">
                        <thead class="table-hover table-info">
                            <th style="text-align: center;"> Producto </th>
                            <th style="text-align: center;"> UM </th>
                            <th style="text-align: center;"> Costo Unitario </th>
                            <th style="text-align: center;"> Cantidad Solicitada </th>
                            <th style="text-align: center;"> Subtotal Solicitado</th>
                            <th style="text-align: center;"> Cantidad Enviada </th>
                            <th style="text-align: center;"> Subtotal Enviado</th>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalle_pedidos as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                @if(isset($detalle->producto->unidad_medida_venta->nombre))
                                <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                @else
                                <td style="text-align: center;">Sin UM</td>
                                @endif
                                <td style="text-align: center;">{{$detalle->precio}} Bs</td>
                                <td style="text-align: center;">{{$detalle->cantidad_solicitada}}</td>
                                <td style="text-align: center;"> {{$detalle->subtotal_solicitado}} Bs</td>
                                <td style="text-align: center;">
                                    @if($detalle->cantidad_enviada)
                                    {{$detalle->cantidad_enviada}} 
                                    @else
                                    0 
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if($detalle->subtotal_enviado)
                                    {{$detalle->subtotal_enviado}} Bs
                                    @else
                                    0 Bs
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="4" style="text-align: center;">Total Solicitado</td>
                            <td colspan="1" style="text-align: center;"> {{$pedido->total_solicitado}} Bs. </td>
                            <td colspan="1" style="text-align: center;">Total Enviado</td>
                            <td colspan="1" style="text-align: center;">
                                @if($pedido->total_enviado)
                                {{$pedido->total_enviado}} Bs.
                                @else
                                0 Bs
                                @endif
                            </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{ route('pedidos.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>

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