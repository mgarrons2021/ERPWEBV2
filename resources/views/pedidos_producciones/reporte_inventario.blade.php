@extends('layouts.app', ['activePage' => 'contabilidad', 'titlePage' => 'Contabilidad'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte General de Inventario de la Empresa Donesco Srl.</h3>
    </div>
    <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Seleccione la Fecha a Visualizar</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{route('pedidos_producciones.reporte_inventario')}}" method="GET">

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
                                <th style="text-align: center; "> Cantidad  </th>
                                <th style="text-align: center; "> Unidad Medida </th>
                                <th style="text-align: center;">  Precio</th>
                                <th style="text-align: center;">  Total </th>
                            </thead>
                            <tbody>
                                
                                @php $total_inventario_bs =0; @endphp

                                @foreach($inventarios as $inventario)

                                @php $total_inventario_bs +=$inventario->subtotal @endphp
                                <tr>
                                    <td class="text-center">{{$inventario->producto_nombre}}</td>
                                    <td class="text-center">{{$inventario->cantidad}}</td>
                                    <td class="text-center">{{ isset($inventario->um)? $inventario->um : 'Sin UM'}}</td>
                                    <td class="text-center">{{$inventario->precio}} Bs</td>
                                    <td class="text-center table-success">{{$inventario->subtotal}} Bs</td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>
                                <th style="text-align: center;" colspan="4" class="table-info">Total Inventario:</th>
                                <th style="text-align: center;" class="table-success">{{ $total_inventario_bs}} Bs</th>
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