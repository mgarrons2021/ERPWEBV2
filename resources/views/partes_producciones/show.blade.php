@extends('layouts.app', ['activePage' => 'partes producciones', 'titlePage' => 'Parte Produccion'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Parte Produccion Nro: {{ $parte_produccion->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalle del Parte Produccion</h4>
                  
                </div>
                <div class="card-body">
                    <div class="table-responsive"></div>
                    <table class="table table-bordered table-md">
                        <tbody>

                            @php
                            $hora = new DateTime($parte_produccion->created_at);
                            $hora_solicitado = $hora->format('H:i:s');

                            @endphp

                            <tr>
                                <th>Fecha:</th>
                                <td>{{$parte_produccion->fecha }}</td>
                            </tr>
                            <tr>
                                <th>Hora pedido:</th>
                                <td>{{ $hora_solicitado }}</td>
                            </tr>


                            <tr>
                                <th> Total Solicitado:</th>
                                <td>{{$parte_produccion->total}} Bs</td>
                            </tr>
                            <tr>
                                <th> Sucursal:</th>
                                <td>{{ $parte_produccion->sucursal_usuario->nombre  }}</td>
                            </tr>
                            
                          
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detalle Parte Produccion</h4>
                </div>
                <div class="card-body">
                    <table class="table table-hover" id="table">
                        <thead class="table-hover table-info">
                            <th style="text-align: center;"> Producto </th>
                            <th style="text-align: center;"> Cantidad Registrada </th>
                            <th style="text-align: center;"> UM </th>
                            <th style="text-align: center;"> Precio </th>
                            <th style="text-align: center;"> Subtotal  </th>
                            

                        </thead>
                        <tbody>
                            @foreach($parte_produccion->detalle_partes_producciones as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->producto->nombre}}</td>

                                <td style="text-align: center;">{{$detalle->cantidad}}</td>
                                
                                @if(isset($detalle->producto->unidad_medida_venta->nombre))
                                <td style="text-align: center;">{{$detalle->producto->unidad_medida_venta->nombre}}</td>
                                @else
                                <td style="text-align: center;">Sin UM</td>
                                @endif
                                <td style="text-align: center;">{{$detalle->precio}}</td>
                                <td style="text-align: center;"> {{$detalle->subtotal}}</td>
                                

                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="4" style="text-align: center;"> Total Solicitado</td>
                            <td colspan="1" style="text-align: center;"> {{$parte_produccion->total}} Bs. </td>
                            
                            
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{ route('partes_producciones.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>

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