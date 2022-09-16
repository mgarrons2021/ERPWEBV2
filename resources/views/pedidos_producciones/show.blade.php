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
                                <td>{{$pedido->fecha }}</td>
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
                                <td>{{ $pedido->sucursal_usuario->nombre  }}</td>
                            </tr>
                            <tr>
                                <th> Estado Pedido:</th>

                                @if ($pedido->estado === 'E')
                                <td class="badge badge-success"> Enviado</td>
                                @elseif ($pedido->estado == 'S')
                                <td> <span class="badge badge-warning"> Solicitado </span></td>
                                @else
                                <td> <span class="badge badge-success"> Aceptado </span></td> 
                                @endif

                            </tr>
                            <tr>
                                <th> Solicitado Por: </th>
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
                            <th style="text-align: center;"> Plato </th>
                            <th style="text-align: center;"> Cantidad Solicitada </th>
                            <th style="text-align: center;"> Cantidad Enviado </th>
                            <th style="text-align: center;"> UM </th>
                            <th style="text-align: center;"> Costo  </th>
                            <th style="text-align: center;"> Subtotal Solicitado </th>
                            <th style="text-align: center;"> Subtotal Enviado </th>

                        </thead>
                        <tbody>
                            @foreach($pedido->detalle_pedido_produccion as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->plato->nombre}}</td>

                                <td style="text-align: center;">{{$detalle->cantidad_solicitada}}</td>
                                <td style="text-align: center;">{{$detalle->cantidad_enviada}}</td>
                                @if(isset($detalle->plato->unidad_medida_venta->nombre))
                                <td style="text-align: center;">{{$detalle->plato->unidad_medida_venta->nombre}}</td>
                                @else
                                <td style="text-align: center;">Sin UM</td>
                                @endif
                                <td style="text-align: center;">{{$detalle->precio}}</td>
                                <td style="text-align: center;"> {{$detalle->subtotal_solicitado}}</td>
                                <td style="text-align: center;"> {{$detalle->subtotal_enviado}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="4" style="text-align: center;"> Total Solicitado</td>
                            <td colspan="1" style="text-align: center;"> {{$pedido->total_solicitado}} Bs. </td>
                            <td colspan="1" style="text-align: center;">Total Enviado</td>
                            <td colspan="1" style="text-align: center;">
                                @if(isset($pedido->total_enviado))
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





    <div>

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
</script>@endsection