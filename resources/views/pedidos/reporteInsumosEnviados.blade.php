@extends('layouts.app', ['activePage' => 'predidos', 'titlePage' => 'Pedidos'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte Insumos Traspasados Fecha: {{ $fecha}}</h3>
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
                            <form action="{{route('pedidos.reporteInsumosEnviados')}}" method="GET">

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
                        <h4>Reporte Detallado Insumos</h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-hover" id="table1">
                            <thead class="table-hover table-info">

                                <th style="text-align: center;"> Nombre Producto </th>
                                
                                <th style="text-align: center;"> Insumos Solicitados </th>
                                <th style="text-align: center;"> Insumos Enviados </th>
                                <th style="text-align: center;"> Sub Total </th>

                            </thead>

                            <tbody>
                                @php
                                $totalEnviado=0;
                                $SubtotalEnviado=0;
                                @endphp
                                @foreach($detalle_pedidos as $pedido)
                                <tr>
                                    @php
                                    $totalEnviado+=$pedido->cantidadenviado;
                                    $SubtotalEnviado+=$pedido->TotalEnviada;
                                    @endphp
                                    <td style="text-align: center;">{{$pedido->NombreProducto }}</td>
                                   <!--  @if(isset($pedido->unidadNombre))
                                    <td style="text-align: center;">{{$pedido->unidadNombre }}</td>
                                    @else
                                    <td class="text-center">Sin Um</td>
                                    @endif  -->
                                    <td style="text-align: center;">{{$pedido->cantidadSolicitado}}</td>  
                                    <td style="text-align: center;">{{$pedido->cantidadenviado}}</td>  
                                    <td style="text-align: center;">{{$pedido->TotalEnviada}}</td>         
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td style="text-align: center;">Totales</td>
                                <td style="text-align: center;"></td>
                                <td style="text-align: center;">{{$SubtotalEnviado}} Bs</td>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div id="container"></div>
                </div>

                <a class="btn btn-info" href="{{route('pedidos.index')}}"> VOLVER</a>

            </div>

</section>

@endsection
@section('page_js')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

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
            dom: 'Bftipr',
            buttons: [{
                    //Botón para Excel
                    extend: 'excel',
                    footer: true,
                    title: 'Reporte Insumos Enviados',
                    filename: 'Reporte Insumos Enviados',
                    //Aquí es donde generas el botón personalizado
                    text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
                },
                //Botón para PDF
                {
                    extend: 'pdf',
                    footer: true,
                    title: 'Reporte Insumos Enviados',
                    filename: 'Reporte Insumos Enviados',
                    text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>',
                    customize: function(pdfDocument) {        
                    }
                },
            ]
        });
    
</script>
@endsection

@section('css')

.tablecolor {
background-color: #212121;
}

@endsection
