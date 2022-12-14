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
            <div class="card">
                <div class="card-body">
                    <div class="table-resposive">
                        <table class="table table-bordered table-md" id="table">
                            <thead>
                                {{-- <th>Fecha Venta</th>
                                <th>Hora Transaccion</th>
                                <th>Nro Factura</th>
                                <th>Tipo Pago </th>
                                <th>Total Venta </th>
                                <th>Usuario</th>
                                <th>Sucursal</th>
                                <th>Motivo Contingencia</th>
                                <th>Estado</th>
                                <th>Estado Siat</th> --}}
                                <th>id</th>
                                <th>Fecha Inicio Contingencia</th>
                                <th>Fecha Fin Contingencia</th>
                                <th>Hora Inicio Contingencia</th>
                                <th>Hora Fin Contingencia</th>
                                <th>estado</th>
                                <th>Evento Significativo</th>
                            </thead>
                            <tbody>
                                @foreach ($contingencias as $contingencia)
                                <tr>
                                    <td> <a href="{{route('eventos_significativos.show',$contingencia->id)}}">{{$contingencia->id}}</a> </td>
                                    <td>{{$contingencia->fecha_inicio_contingencia}}</td>
                                    <td>{{$contingencia->fecha_fin_contingencia}}</td>
                                    <td>{{$contingencia->hora_ini}}</td>
                                    <td>{{$contingencia->hora_fin}}</td>
                                    @if($contingencia->Estado)
                                    <td> <span class="badge badge-success"> Enviado </span> </td>
                                    @else
                                    <td> <span class="badge badge-warning"> Pendiente </span></td>
                                    @endif
                                    <td>{{$contingencia->evento_significativo->descripcion}}</td>
                                </tr>
                                @endforeach
                                {{-- @foreach ($ventas as $venta)
                                <tr>
                                    <td>{{ $venta->fecha_venta }}</td>
                                <td>{{ $venta->hora_venta }}</td>
                                <td>{{ $venta->numero_factura }}</td>
                                <td>{{ $venta->tipo_pago }}</td>
                                <td>{{ number_format($venta->total_venta,2) }} Bs</td>
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

                                @if($venta->estado_emision == "V")
                                <td> <span class="badge badge-success"> Validada por el Siat </span> </td>
                                @endif
                                @if($venta->estado_emision == "R")
                                <td> <span class="badge badge-danger"> Rechazada por el Siat </span> </td>
                                @endif
                                @if($venta->estado_emision == "P")
                                <td> <span class="badge badge-warning"> Pendiente </span> </td>
                                @endif
                                </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" id="registrar_facturas_paquetes" class="btn btn-warning">Registrar Facturar Paquetes</button>
                <button type="button" class="btn btn-dark">Close</button>
            </div> --}}
        </div>
    </div>
</section>

@endsection
@section('scripts')

<script>
    const csrfToken = document.head.querySelector(
        "[name~=csrf-token][content]"
    ).content;
    let registrar_facturas_paquetes = document.getElementById('registrar_facturas_paquetes');
    let fecha_inicio = document.getElementById("fecha_inicio");
    let fecha_fin = document.getElementById("fecha_fin");
    let ventas = document.getElementById('ventas');
    let ruta = "{{ route('eventos_significativos.generar_evento_significativo') }}";
    let rutaIndex = "{{ route('eventos_significativos.index') }}";
    registrar_facturas_paquetes.addEventListener('click', (e) => {
        Swal.fire({
            title: 'Enviando Facturas Por Paquete...',
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
                fecha_inicio: fecha_inicio.value,
                fecha_fin: fecha_fin.value,
                ventas: ventas.value,
            },
            success: function(res) {
                console.log(res);
                let codigo = res.RespuestaServicioFacturacion != undefined ? res.RespuestaServicioFacturacion.codigoEstado : "";
                let descripcion = res.RespuestaServicioFacturacion != undefined ? res.RespuestaServicioFacturacion.codigoDescripcion : "";
                if (res.RespuestaListaEventos != undefined) {
                    codigo = res.RespuestaListaEventos.mensajesList.codigo;
                    descripcion = res.RespuestaListaEventos.mensajesList.descripcion;
                }
                if (codigo === 981) {
                    Swal.close();
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: "Codigo: " + codigo,
                        text: "Mensaje: " + descripcion,
                        showConfirmButton: true,
                        timer: 3500,
                    })
                }
                //VALIDADA
                if (codigo === 908) {
                    Swal.close();
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: "Codigo::" + codigo,
                        text: descripcion,
                        showConfirmButton: true,
                        timer: 3500,
                        willClose: function() {
                            window.location.href = rutaIndex;
                        },
                    })
                }

                //OBSERVADA
                if (codigo === 904) {
                    Swal.close();
                    Swal.fire({
                        position: 'center',
                        icon: 'warning',
                        title: "Codigo::" + codigo,
                        text: descripcion,
                        showConfirmButton: true,
                        timer: 100000,
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
                sLast: "????ltimo",
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
                //Bot??n para Excel
                extend: 'excel',
                footer: true,
                title: 'Inventarios',
                filename: 'Inventario',
                //Aqu?? es donde generas el bot??n personalizado
                text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
            },
            //Bot??n para PDF
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