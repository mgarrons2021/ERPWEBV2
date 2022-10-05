@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')

@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte Insumos/Produccion Enviada Fecha: {{ $fecha}}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Seleccione la Fecha a Visualizar</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{route('pedidos_producciones.reporteProduccionEnviada')}}" method="GET">

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                            <span class="input-group-addon">A</span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="col-md-4" style="margin: 0 auto;">
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Reporte Detallado Produccion </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table">
                            <thead class="table-hover table-info">
                                <th style="text-align: center;"> Sucursal </th>
                                <th style="text-align: center;"> Produccion Solicitada </th>
                                <th style="text-align: center;"> Produccion Enviada </th>
                                <th style="text-align: center;"> Ver Detalle </th>
                            </thead>

                            <tbody>
                                @php
                                $totalSolicitado=0;
                                
                                $totalEnviado=0;
                                
                                @endphp
                                @foreach($pedidos_producciones as $pedido_produccion)
                                <tr>
                                    @php
                                    $totalSolicitado+=$pedido_produccion->TotalProduccionSolicitada;
                                   
                                    $totalEnviado+=$pedido_produccion->TotalProduccionEnviada;
                             
                                    @endphp
                                    <td style="text-align: center;">{{$pedido_produccion->sucursal_nombre }}</td>
                                    <td style="text-align: center;">{{$pedido_produccion->TotalProduccionSolicitada}} Bs</td>
                                    
                                    <td style="text-align: center;">{{$pedido_produccion->TotalProduccionEnviada}} Bs</td>
                                    

                                    <td style="text-align: center;"><a href="{{ route('pedidos.verDetalleReporteProduccion',[$pedido_produccion->sucursal_id,$fecha_inicial,$fecha_final])}}" class="btn btn-info btn-sm" target="_blank"> <i class="fa fa-eye"></i> </a></td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td style="text-align: center;">Totales:</td>
                                <td style="text-align: center;">{{$totalSolicitado}} Bs</td>
                                
                                <td style="text-align: center;">{{$totalEnviado}} Bs</td>
                                
                            </tfoot>

                        </table>
                    </div>


                </div>



            </div>


            <div class="col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Reporte Detallado Insumos</h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table1">
                            <thead class="table-hover table-info">

                                <th style="text-align: center;"> Sucursal </th>

                                <th style="text-align: center;"> Insumos Solicitados </th>
                                <th style="text-align: center;"> Insumos Enviados </th>
                                <th style="text-align: center;">Ver Detalle</th>


                            </thead>

                            <tbody>
                                @php
                                $totalSolicitado=0;
                                $totalEnviado=0;
                                @endphp
                                @foreach($pedidos as $pedido)
                                <tr>
                                    @php
                                    $totalSolicitado+=$pedido->TotalInsumosSolicitada;
                                    $totalEnviado+=$pedido->TotalInsumosEnviado;

                                    @endphp
                                    <td style="text-align: center;">{{$pedido->sucursal_nombre }}</td>
                                    <td style="text-align: center;">{{$pedido->TotalInsumosSolicitada}} Bs</td>
                                    <td style="text-align: center;">{{$pedido->TotalInsumosEnviado}} Bs</td> 
                                    <td style="text-align: center;"><a href="{{ route('pedidos.verDetalleReporte',[$pedido->sucursal_id,$fecha_inicial,$fecha_final])}}" class="btn btn-info btn-sm" target="_blank"> <i class="fa fa-eye"></i> </a></td>

                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td style="text-align: center;">Totales</td>
                                <td style="text-align: center;">{{$totalSolicitado}} Bs</td>
                                <td style="text-align: center;">{{$totalEnviado}} Bs</td>
                            </tfoot>
                        </table>
                    </div>


                </div>

                <div class="card">
                    <div id="container"></div>
                </div>

                <a class="btn btn-info" href="{{route('pedidos.index')}}"> VOLVER</a>

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

<script>
    $('#table1').DataTable({
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