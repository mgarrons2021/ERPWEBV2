@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventarios'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        {{-- <h3 class="page__heading">Inventario Nro: {{ is_null($inventario)?'':$inventario->id }}</h3> --}}
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles del Inventario</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="table">
                            <thead>
                                <th style="text-align: center;"> Item </th>
                                <th style="text-align: center;"> Inventario </th>
                                <th style="text-align: center;"> Precio </th>
                                <th style="text-align: center;"> Compras </th>
                                <th style="text-align: center;"> Pedidos </th>
                                <th style="text-align: center;"> Eliminacion </th>
                                <th style="text-align: center;"> Inv Sistema </th>
                                <th style="text-align: center;"> Inv Final </th>
                                <th style="text-align: center;"> Dif </th>
                                <th style="text-align: center;"> Total Dif </th>
                            </thead>
                            <tbody>


                                @foreach($detalleAjustes as $detalle)
                                <tr>
                                    <td style="text-align: center;">{{$detalle->producto}}</td>
                                    <td style="text-align: center;">{{$detalle->inventario_ini}}</td>
                                    <td style="text-align: center;">{{$detalle->precio}}</td>
                                    <td style="text-align: center;">{{$detalle->compras}}</td>
                                    <td style="text-align: center;">{{$detalle->pedido}}</td>
                                    <td style="text-align: center;">{{$detalle->eliminacion}}</td>
                                    <td style="text-align: center;">{{$detalle->inventario_sis}}</td>
                                    <td style="text-align: center;">{{$detalle->inventario_fin}}</td>
                                    <td style="text-align: center;">{{$detalle->diferencia}}</td>
                                    <td style="text-align: center;">{{$detalle->total_diferencia_bs}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="4" style="text-align: center;"> Total Ajuste de Inventario</td>
                                <td colspan="6" style="text-align: right;"> {{ is_null($detalleAjustes)?0:number_format($sumaTotalDiferencia,2) }} Bs. </td>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-container ">
            {{-- <a href="{{ route('inventarios.index') }}" class="btn btn-warning btn-twitter mr-2"> Volver </a> --}}
            {{-- <a href="" class="btn btn-info btn-twitter"> Editar </a> --}}
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
        columnDefs: [{
            orderable: false,
            targets: 6
        }]
    });



</script>

@endsection