@extends('layouts.app', ['activePage' => 'ventas_por_sucursal', 'titlePage' => 'Ventas_por_Sucursal'])

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection
<section class="section">
    <div class="section-header">
        <h1 class="text-center">Reporte Ajuste de Inventario Semanal</h1>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: hidden">
            <form action="{{ route('reportes.ajuste_inventario_semanal') }} " method="POST" class="form-horizontal">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>A:</strong> </span>
                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-control" id="sucursal" name="sucursal" aria-label="Default select example">
                            <option selected>Sucursal</option>
                            @foreach($sucursales as $sucursal)
                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-4" style="margin: 0 auto;">
                        <input class="form-control btn btn-primary" value="Filtrar" type="submit" id="filtrar" name="filtrar">
                    </div>
                    {{-- <a href="{{ route('reportes.ventas_por_sucursalId') }}">Consultar</a> --}}
                </div>
            </form>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card"></div>
                <div class="card-body">

                    <div class="table-responsive ">
                        <table id="table" class="table">
                            <thead style="background-color: #6777ef;">
                                <tr>
                                    <th style="text-align: center;  color: white"> Item </th>
                                    <th style="text-align: center;  color: white"> Inventario </th>
                                    <th style="text-align: center;  color: white"> Precio </th>
                                    <th style="text-align: center;  color: white"> Compras </th>
                                    <th style="text-align: center;  color: white"> Pedidos </th>
                                    <th style="text-align: center;  color: white"> Eliminacion </th>
                                    <th style="text-align: center;  color: white"> Inv Sistema </th>
                                    <th style="text-align: center;  color: white"> Inv Final </th>
                                    <th style="text-align: center;  color: white"> Dif </th>
                                    <th style="text-align: center;  color: white"> Total Dif </th>
                                </tr>

                            </thead>
                            <tbody id="tbody">
                                @foreach($newCollection as $detalle)
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
                                <td colspan="6" style="text-align: right;"> {{ is_null($newCollection)?0:number_format($sumaTotalDiferencia,2) }} Bs. </td>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </form>
    <div class="col-lg-12">
    </div>
</section>

@endsection
@section('scripts')
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
                targets: 3
            },
        ]
    });
</script>

@section('page_js')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
{{-- <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

@endsection

@endsection