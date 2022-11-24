@extends('layouts.app', ['activePage' => 'anular_facturas', 'titlePage' => 'Anular Facturas'])
@section('content')
@include('siat.anulaciones_facturas.modal')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro - Detalle de Ventas Por Contingencia</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <div class="table-resposive">
                        <table class="table table-bordered table-md" id="table">
                            <thead>
                                <th>id</th>
                                <th>Fecha Emision</th>
                                <th>Hora Emision</th>
                                <th>Sucursal</th>
                                <th>Nro Factura</th>
                                <th>Total Venta</th>
                            </thead>
                            <tbody>
                            @foreach ($detalleContingencias as $detalleContingencia)
                                <tr>
                                    <td>{{$detalleContingencia->id}}</td>
                                    <td>{{$detalleContingencia->fecha_venta}}</td>
                                    <td>{{$detalleContingencia->hora_venta}}</td>
                                    <td>{{$detalleContingencia->sucursal->nombre}}</td>
                                    <td>{{$detalleContingencia->nro_transaccion}}</td>
                                    <td>{{$detalleContingencia->total_neto}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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