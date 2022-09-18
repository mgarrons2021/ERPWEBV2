@extends('layouts.app', ['activePage' => 'anular_facturas', 'titlePage' => 'Anular Facturas'])
@section('content')
@include('siat.anulaciones_facturas.modal')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro de Ventas Por Contingencia</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Seleccione la fecha a Filtrar</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{route('eventos_significativos.filtrarEventosSignificativos')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>A:</strong> </span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" required />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon "><strong>Contingencia:</strong> </span>
                                            <select name="evento_significativo_id" id="evento_significativo_id" class="form-control selectric">
                                                @foreach($eventos_significativos as $evento_significativo)
                                                <option value="{{$evento_significativo->id}}">{{$evento_significativo->descripcion}}</option>
                                                @endforeach
                                            </select>
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
            <form action="{{route('eventos_significativos.generar_evento_significativo')}}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="fecha_actual">Fecha Inicio Contingencia</label>
                                        <input type="datetime-local" class="form-control" name="fecha_inicio" value="{{ $fecha_actual }}">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_actual">Fecha Fin Contingencia</label>
                                        <input type="datetime-local" class="form-control" name="fecha_fin">
                                    </div>
                                </div>
                                <input type="hidden" id="ventas" name="ventas" value="{{$ventas}}">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-resposive">
                            <table class="table table-bordered table-md" id="table">
                                <thead>
                                    <th>ID</th>
                                    <th>Fecha Venta</th>
                                    <th>Hora Transaccion</th>
                                    <th>Nro Factura</th>
                                    <th>Tipo Pago </th>
                                    <th>Total Venta </th>
                                    <th>Usuario</th>
                                    <th>Sucursal</th>
                                    <th>Motivo Contingencia</th>
                                    <th>Estado</th>

                                    <th></th>
                                </thead>
                                <tbody>
                                    
                                    @foreach ($ventas as $venta)
                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ $venta->fecha_venta }}</td>
                                        <td>{{ $venta->hora_venta }}</td>
                                        <td>{{ $venta->numero_factura }}</td>
                                        <td>{{ $venta->tipo_pago }}</td>
                                        <td>{{ $venta->total_venta }} Bs</td>
                                        <td>{{ $venta->user->name }} {{$venta->user->apellido}}</td>
                                        <td>{{ $venta->sucursal->nombre }}</td>
                                        @if(isset($venta->evento_significativo))
                                        <td>{{$venta->evento_significativo->descripcion}}</td>
                                        @else
                                        <td><span class="badge badge-warning"> Sin Contingencia</span></td>
                                        @endif

                                        @if($venta->estado == 1)
                                        <td> <span class="badge badge-success"> Vigente </span> </td>
                                        @else
                                        <td> <span class="badge badge-warning"> Anulado </span></td>
                                        @endif

                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                            </div>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Generar Evento Significativo</button>
                    <button type="button" class="btn btn-dark">Close</button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection


@section('scripts')

<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

{{-- <script>
    $('#modalAnulacion').on('show.bs.modal', function(e) {
        let id = $(e.relatedTarget).data('id');
        var modal = $(this)
        console.log(modal)
        //Guardamos el resultado en un input dentro del modal de nombre mnombre
        modal.find('.modal-header #venta_id').html("Anular Factura " + " " + id)
        modal.find('.modal-body #venta_id').val(id)

    });
</script> --}}



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
        columnDefs: [{
                orderable: false,
                targets: 5
            },
            {
                className: 'text-center',
                targets: [0, 1, 2, 3, 4]
            },
        ],
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
                customize: function(pdfDocument) {}
            },
        ]

    });
</script>

<script>
    $(document).ready(function() {
        $('#evento_significativo').select2();
    });
</script>



@endsection
@endsection
@section('page_css')
<style>
    a:link {
        color: rgb(0, 0, 0);
        background-color: transparent;
        text-decoration: none;
    }

    .dato:visited {
        color: rgb(255, 255, 255);
        background-color: transparent;
        text-decoration: none;
    }

    a:hover {
        color: red;
        background-color: transparent;
        text-decoration: underline;
    }

    a:active {
        color: yellow;
        background-color: transparent;
        text-decoration: underline;
    }
</style>
@endsection