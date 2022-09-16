@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')

@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Detallle Reporte M.O de la Sucursal: 
            @if(isset($detalles_manos_obras_am[0]->sucursal_nombre))
            {{$detalles_manos_obras_am[0]->sucursal_nombre}}</h3>
            @else 
            Sin Datos 
            @endif
    </div>
    <div class="section-body">
        <div class="row">          
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 > Seleccione la Fecha a Visualizar </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            {{-- <form action="{{route('manos_obras.detalle_mo_sucursal')}}" method="GET"> --}}

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
                        <h4>Reporte Detallado M.O </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table">
                            <thead class="table-hover table-info">

                                <th style="text-align: center;"> Horas Trabajadas PM </th>
                                <th style="text-align: center;"> Costo Horas Trabajadas </th>
                                <th style="text-align: center;"> Ventas Am </th>
                                <th style="text-align: center;"> Horas Trabajadas PM </th>
                                <th style="text-align: center;"> Costo Horas Trabajadas </th>
                                <th style="text-align: center;"> Ventas Pm </th>
                                <th style="text-align: center;"> Total Ventas  </th>
                                <th style="text-align: center;"> % M.O  </th>


                            </thead>

                            <tbody>
                               
                                @foreach($detalles_manos_obras_am as $detalle)
                                    @php
                                    $costo_horas =8.84;
                                    $total_ventas =  $ventas_dia_am[0]->ventas_am + $ventas_dia_pm[0]->ventas_pm;
                                    $costo_horas_am = $detalle->horas_trabajadas_am * $costo_horas;   
                                    $costo_horas_pm = $detalles_manos_obras_pm[0]->horas_trabajadas_pm * $costo_horas;
                                    $total_costo_horas = $costo_horas_am + $costo_horas_pm;
                                    $porcentaje_mo = ($total_costo_horas / $total_ventas) *100;
                                    @endphp
                                <tr>
                                  
                                    <td style="text-align: center;">{{$detalle->horas_trabajadas_am }} Hrs</td>
                                    <td style="text-align: center;">{{$costo_horas_am}} Bs </td>
                                    @if ($ventas_dia_am[0]->ventas_am != null)
                                    <td style="text-align: center;">{{number_format($ventas_dia_am[0]->ventas_am),2 }} Bs </td>
                                    @else
                                    <td style="text-align: center;">0.00 Bs </td>
                                    @endif

                                    <td style="text-align: center;">{{$detalles_manos_obras_pm[0]->horas_trabajadas_pm}} Hrs </td>
                                    <td style="text-align: center;">{{$costo_horas_pm}} Bs </td>

                                    @if ($ventas_dia_pm[0]->ventas_pm != null)
                                    <td style="text-align: center;">{{number_format($ventas_dia_pm[0]->ventas_pm),2 }} Bs</td>
                                    @else
                                    <td style="text-align: center;">0.00 Bs </td>
                                    @endif
                                    
                                    <td style="text-align: center;">{{$total_ventas}} Bs </td>
                                    <td style="text-align: center;">{{number_format($porcentaje_mo,2) }} % </td>
                                    
                                    
                                </tr>
                                @endforeach
                            </tbody>
                          {{--   <tfoot>
                                <td style="text-align: center;">Totales:</td>
                                <td style="text-align: center;">{{$totalSolicitado}} Bs</td>
                                
                                <td style="text-align: center;">{{$totalEnviado}} Bs</td>
                                
                            </tfoot> --}}

                        </table>
                    </div>


                </div>



            </div>


            {{-- <div class="col-lg-12">

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

            </div> --}}



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