@extends('layouts.app', ['activePage' => 'pagos', 'titlePage' => 'pagos'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pagos Registrados</h3>

    </div>
    <div class="section-body">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button class="btn btn-success float-right" data-toggle="modal" data-target="#exampleModal">Filtrar Pagos</button> <br><br>
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">
                                    <!-- <th style="text-align: center; color: #fff;"> Pago N° </th> -->
                                    <th style="text-align: center; color: #fff;"> Fecha Pago </th>
                                    <th style="text-align: center; color: #fff;">Proveedor</th>
                                    <th style="text-align: center; color: #fff;">Nro Cheque</th>
                                    <th style="text-align: center; color: #fff;">Monto</th>
                                    <th style="text-align: center; color: #fff;"></th>
                                </thead>
                                <tbody>
                                    @php $total_pago = 0; @endphp
                                    @foreach ($pagos as $pago)
                                    <tr>
                                        <!--   <td style="text-align: center;">
                                            <a href="{{route('pagos.show', $pago->id)}}" target="_blank"> {{$pago->id}}</a>
                                        </td> -->
                                        @php $fecha_formateada = date('d-m-Y', strtotime($pago->fecha)); @endphp
                                        <td style="text-align: center;">{{$fecha_formateada}}</td>

                                        @if(isset($pago->proveedor->nombre))
                                        <td style="text-align: center;">{{$pago->proveedor->nombre}}</td>
                                        @else
                                        <td style="text-align: center;" > Sin Proveedor</td>
                                        @endif

                                        <td style="text-align: center;">{{$pago->nro_cheque}}</td>
                                        <td style="text-align: center;">
                                            <div class="badge badge-pill badge-info">{{$pago->total}} Bs</div>
                                            @php $total_pago +=$pago->total @endphp
                                        </td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{route('pagos.show', $pago->id)}}">Ver detalle</a></li>
                                                    <li>
                                                        <form action="{{route('pagos.index',$pago->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="#">Eliminar</a>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <th class="table-primary text-center"> Total Pagado:</th>
                                <td class="table-danger text-center"> {{ number_format($total_pago,4)}} Bs.</td>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<div class="modal hide fade in" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModal2Label">Ingrese los datos</h5>
                <button type="button" class="close" id="cerrar_modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pagos.filtrarPagos')}}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for="datepicker">Seleccione las Fechas</label>
                            <div class=" input-group" id="datepicker">
                                <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                <span class="input-group-addon">A</span>
                                <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="">
                            <div class="form-group">
                                <label for="proveedor">Seleccione el Proveedor</label>
                                <select name="proveedor_id" id="proveedor_id" class="form-control" style="width: 100%;">
                                    <option value="">Seleccionar Proveedor</option>
                                    @foreach ($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="filtrar_compras">Filtrar Pagos</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script>
    $('#cerrar_modal').on('click', () => {
        $('#exampleModal').modal('close');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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
                targets: 4
            },

        ]
    });
</script>
@endsection
@endsection