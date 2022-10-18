@extends('layouts.app', ['activePage' => 'compras', 'titlePage' => 'Compras'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Compra Nro: {{ $compra->id }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">

                    <div class="card-header">
                        <h4>Datos de la Compra</h4>
                        <div class="col-xl-10 text-right">
                            <a href="{{ route('compras.download-pdf', $compra->id) }}" class="btn btn-danger btn-sm">Exportar a PDF</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"></div>
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr>
                                    <th>Fecha compra:</th>
                                    <td>{{ $compra->fecha_compra }}</td>
                                </tr>
                                <tr>
                                    <th> Proveedor:</th>
                                    <td> <span class="badge badge-success"> {{ $compra->proveedor->nombre }} </span></td>
                                </tr>
                                <tr>
                                    <th> Usuario:</th>
                                    <td>{{$compra->user->name}}</td>
                                </tr>
                                <tr>
                                    <th> Sucursal:</th>
                                    <td>{{ $compra->sucursal->nombre  }}</td>
                                </tr>

                                <tr>
                                    <th> Glosa:</th>
                                    <td>{{ $compra->glosa}}</td>
                                </tr>
                                <tr>
                                    <th> Tipo de Comprobante:</th>
                                    @if ($compra->tipo_comprobante=="S")
                                    <td> <span class="badge badge-info"> Sin Comprobante </span></td>
                                    @endif
                                    @if ($compra->tipo_comprobante=="R")
                                    <td>Recibo</td>
                                    @endif
                                    @if ($compra->tipo_comprobante=="F")
                                    <td>Factura</td>
                                    @endif
                                </tr>
                                @if ($compra->tipo_comprobante=="R")
                                <tr>
                                    <th>Nro de Recibo</th>
                                    <td>
                                        @if(isset($compra->comprobante_recibo->nro_recibo))
                                        {{$compra->comprobante_recibo->nro_recibo}}
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                @if ($compra->tipo_comprobante=="F")
                                <tr>
                                    <th>Nro Factura</th>
                                    <td>
                                        @if(isset($compra->comprobante_factura->numero_factura))
                                        {{$compra->comprobante_factura->numero_factura}}
                                        @endif
                                    </td>
                                </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4>Detalles de la Compra</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <th style="text-align: center;"> Producto </th>
                            <th style="text-align: center;"> UM </th>
                            <th style="text-align: center;"> Precio </th>
                            <th style="text-align: center;"> Cantidad </th>
                            <th style="text-align: center;"> Subtotal </th>

                        </thead>
                        <tbody>
                            @foreach($detalle_compra as $detalle)
                            <tr>

                                <td style="text-align: center;">{{$detalle->producto->nombre}}</td>
                                @if(isset($detalle->producto->unidad_medida_compra->nombre))
                                <td style="text-align: center;">{{$detalle->producto->unidad_medida_compra->nombre}}</td>
                                @else
                                <td style="text-align: center;">Sin UM</td>
                                @endif
                                <td style="text-align: center;">{{$detalle->precio_compra}}</td>
                                <td style="text-align: center;"> {{$detalle->cantidad}}</td>
                                <td style="text-align: center;"> {{$detalle->subtotal}} Bs. </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td colspan="3" style="text-align: center;"> Total Compra</td>
                            <td colspan="1" style="text-align: center;"> {{$compra->total}} Bs. </td>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>


        <div class="button-container ">
            <a href="{{ route('compras.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter"> Editar </a>
        </div>

        <div>

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
    $(document).ready(function() {
     
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
            dom: 'Bfrtip',
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
    });
</script>

@endsection
@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection
@section('page_css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap4.min.css" />
@endsection