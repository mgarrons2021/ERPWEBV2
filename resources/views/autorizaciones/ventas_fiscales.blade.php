@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'Productos_Proveedores'])

@section('content')

@section('css')
#container {
height: 400px;
min-width: 310px;
}
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte Ventas Fiscales: {{ $fecha}}</h3>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body">

                    </div>
                    <div>

                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-header">
                                    <h4>Reporte Detallado Ventas Fiscales </h4>
                                </div>
                                <div class="card-body">

                                    <table class="table table-hover" id="table">
                                        <thead class="table-hover table-info">

                                            <th style="text-align: center;"> Sucursal </th>
                                            <th style="text-align: center;"> Total Venta </th>
                                            <th style="text-align: center;"> Transacciones </th>
                                            <th style="text-align: center;"> Ticket Promedio </th>


                                        </thead>

                                        <tbody>
                                            @foreach($ventas_fiscales as $venta_fiscal)
                                            <tr>

                                                <td style="text-align: center;">{{$venta_fiscal->nombre_sucursal }}</td>
                                                <td style="text-align: center;">{{$venta_fiscal->total_venta}} Bs</td>
                                                <td style="text-align: center;">{{$venta_fiscal->total_transacciones}} </td>
                                                <td style="text-align: center;">{{$venta_fiscal->ticket_promedio}} </td>
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