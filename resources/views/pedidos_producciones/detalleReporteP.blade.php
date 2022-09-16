@extends('layouts.app', ['activePage' => 'contabilidad', 'titlePage' => 'Contabilidad'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Detalle de Pedido Insumos de {{$pedidos_detalle[0]->sucursal_nombre}}</h3>
    </div>
    @php
    $fecha_inicial_parseada = strtoupper(\Carbon\Carbon::parse($fecha_inicial)->locale('es')->isoFormat(' D MMMM'));
    $fecha_final_parseada = strtoupper(\Carbon\Carbon::parse($fecha_final)->locale('es')->isoFormat(' D MMMM'));
    @endphp
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: center;">
                        <h4>DETALLE DEL {{$fecha_inicial_parseada}} HASTA EL {{$fecha_final_parseada}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <th style="text-align: center; "> Producto </th>
                                <th style="text-align: center; "> Cantidad Solicitada </th>
                                <th style="text-align: center; "> Cantidad Enviada </th>
                                <th style="text-align: center; "> Unidad Medida </th>
                                <th style="text-align: center;">Precio</th>
                                <th style="text-align: center;">Total Enviado</th>
                            </thead>
                            <tbody>
                                
                                @php 
                                $total_enviado_bs =0;
                                $total_solicitado_kilos =0;
                                $total_enviado_kilos =0;
                                @endphp
                                @foreach($pedidos_detalle as $detalle)
                                @php 
                                $total_solicitado_kilos += $detalle->cantidad_solicitada;
                                $total_enviado_kilos += $detalle->cantidadenviado;
                                $total_enviado_bs +=$detalle->TotalEnviada;
                                 @endphp
                                <tr>
                                    <td class="text-center">{{$detalle->NombreProducto}}</td>
                                    <td class="text-center">{{$detalle->cantidad_solicitada}}</td>
                                    <td class="text-center">{{$detalle->cantidadenviado}}</td>
                                    <td class="text-center">{{ isset($detalle->um)? $detalle->um : 'Sin UM'}}</td>
                                    <td class="text-center">{{$detalle->precio}} Bs</td>
                                    <td class="text-center table-success">{{$detalle->TotalEnviada}} Bs</td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <th style="text-align: center;" colspan="" class="table-info">Totales:</th>
                                <th style="text-align: center;" class="table-success">{{ $total_solicitado_kilos}} Kg</th>
                                <th style="text-align: center;" class="table-success">{{ $total_enviado_kilos}} Kg</th>
                                <th style="text-align: center;" colspan="3" class="table-success">{{ $total_enviado_bs}} Bs</th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>
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
        dom: 'Bftipr',
            buttons: [{
                    //Botón para Excel
                    extend: 'excel',
                    footer: true,
                    title: 'Inventarios',
                    filename: 'Inventario',
                    //Aquí es donde generas el botón personalizado
                    text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
                },
                //Botón para PDF
                {
                    extend: 'pdf',
                    footer: true,
                    title: 'Inventarios',
                    filename: 'Inventario',
                    text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>',
                    customize: function(pdfDocument) {        
                    }
                },
            ]
    });
    $('#table2').DataTable({

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
                    title: 'Inventarios',
                    filename: 'Inventario',
                    //Aquí es donde generas el botón personalizado
                    text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
                },
                //Botón para PDF
                {
                    extend: 'pdf',
                    footer: true,
                    title: 'Inventarios',
                    filename: 'Inventario',
                    text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>',
                    customize: function(pdfDocument) {        
                    }
                },
            ]
    });

     $('#table3').DataTable({

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
                    title: 'Inventarios',
                    filename: 'Inventario',
                    //Aquí es donde generas el botón personalizado
                    text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
                },
                //Botón para PDF
                {
                    extend: 'pdf',
                    footer: true,
                    title: 'Inventarios',
                    filename: 'Inventario',
                    text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>',
                    customize: function(pdfDocument) {        
                    }
                },
            ]
    });
</script>
@endsection