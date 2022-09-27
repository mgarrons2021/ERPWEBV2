@extends('layouts.app', ['activePage' => 'anular_facturas', 'titlePage' => 'Anular Facturas'])
@section('content')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Anular Facturas</h3>
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
                            <form action="{{route('anulacion_facturas.filtrar_facturas')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" required />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>A:</strong> </span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" required />
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
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md" id="table">
                                <thead>
                                    <th>Nro Factura</th>
                                    <th>Fecha Venta</th>
                                    <th>Hora Transaccion</th>
                                    <th>Tipo Pago </th>
                                    <th>Total Venta </th>
                                    <th>Usuario</th>
                                    <th>Sucursal</th>
                                    <th>Estado Siat</th>
                                    <th>Estado Factura</th>
                                    <th>Accion</th>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $key => $venta)
                                    <tr>
                                        <td>{{ $venta->numero_factura }}</td>
                                        <td>{{ $venta->fecha_venta }}</td>
                                        <td>{{ $venta->hora_venta }}</td>
                                        <td>{{ $venta->tipo_pago }}</td>
                                        <td>{{ $venta->total_venta }} Bs</td>
                                        <td>{{ $venta->user->name }} {{$venta->user->apellido}}</td>

                                        <td>{{ $venta->sucursal->nombre }}</td>

                                        @if($venta->estado_emision == "V")
                                        <td> <span class="badge badge-success"> Validada por el Siat </span> </td>
                                        @else
                                        <td> <span class="badge badge-warning"> Rechazada por el Siat </span> </td>
                                        @endif

                                        @if($venta->estado == 1)
                                        <td> <span class="badge badge-success"> Vigente </span> </td>
                                        @else
                                        <td> <span class="badge badge-warning"> Anulado </span></td>
                                        @endif
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAnulacion" data-id="{{$venta->id}}"> Anular Factura</button>
                                        </td>
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
<!-- Form del Modal Anular Facturas-->
<div class="modal fade" id="modalAnulacion" tabindex="-1" role="dialog" aria-labelledby="title_id" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="title_id"> <i class="fas fa-arrow-alt-circle-down icon" aria-hidden="true"></i> Anular Factura </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <table class="table table-bordered">
                    <tbody>
                        <input type="hidden" id="venta_id" name="venta_id" class="form-control">
                        <label for="user_id"> Seleccione Motivo Anulacion <span class="required">*</span></label>
                        <div class="selectric-hide-select">
                            <select name="codigo_clasificador" id="codigo_clasificador" class="form-control selectric">
                                @foreach ($motivos_anulaciones as $motivo_anulacion)
                                <option value="{{$motivo_anulacion->codigo_clasificador}}">{{ $motivo_anulacion->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="anular" class="btn btn-success"> Anular </button>
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    $('#modalAnulacion').on('show.bs.modal', function(e) {
        let id = $(e.relatedTarget).data('id');
        var modal = $(this)
        modal.find('.modal-header #title_id').html("Anular Factura " + " " + id)
        modal.find('.modal-body #venta_id').val(id)
    });
    const csrfToken = document.head.querySelector(
        "[name~=csrf-token][content]"
    ).content;
</script>
<script>
    let codigo_clasificador = document.getElementById('codigo_clasificador');
    let venta_id = document.getElementById('venta_id');
    let anularButton = document.getElementById('anular');
    let ruta = "{{ route('anulacion_facturas.test_anulacion_factura') }}";
    let rutaIndex = "{{ route('anulacion_facturas.index') }}";
    anularButton.addEventListener('click', (e) => {
        Swal.fire({
            title: 'Intentado Anular...',
            allowEscapeKey: false,
            icon: 'info',
            allowOutsideClick: false,
            background: '#19191a',
            showConfirmButton: false,
            onOpen: () => {
                Swal.showLoading();
            },
        });
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            url: ruta,
            type: 'POST',
            data: {
                venta_id: venta_id.value,
                codigo_clasificador: codigo_clasificador.value,
            },
            success: function(res) {
                console.log(res);
                let codigoEstado = res.response.RespuestaServicioFacturacion.codigoEstado;
                let codigoDescripcion = res.response.RespuestaServicioFacturacion.codigoDescripcion;

                if (codigoEstado == 906) {
                    let descripcion = res.response.RespuestaServicioFacturacion.mensajesList.descripcion;
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: codigoDescripcion,
                        text: descripcion,
                        showConfirmButton: true,
                        timer: 3500,
                        willClose: function() {
                            $('#modalAnulacion').modal('hide')
                        }
                    })
                }
                if (codigoEstado == 905) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: codigoDescripcion,
                        showConfirmButton: true,
                        timer: 3500,
                        willClose: function() {
                            window.location.href = rutaIndex;
                        },
                    })
                }
            }
        })
    });
</script>

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