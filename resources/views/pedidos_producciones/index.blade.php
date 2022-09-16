@extends('layouts.app', ['activePage' => 'pedido', 'titlePage' => 'Pedidos'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pedidos Produccion Registrados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Seleccione la fecha a Filtrar</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('pedidos_producciones.filtrarPedidosProduccion')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-daterange input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>A:</strong> </span>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <a class="btn btn-outline-danger" href="{{route('pedidos_producciones.create')}}">Nuevo Pedido</a><br><br>
                        <div class="table-responsive">

                            <table class="table table-bordered mt-15 " id="table">
                                <thead class="bg-info">
                                    <!---->
                                    <th class="text-center" style="color: #424242;">Codigo</th>
                                    <th class="text-center" style="color: #424242;">Fecha Pedido</th>
                                    <th class="text-center" style="color: #424242;">Hora Pedido</th>

                                    <th class="text-center" style="color: #424242;">De Sucursal</th>

                                    <th class="text-center" style="color: #424242;">Total Solicitado</th>
                                    <th class="text-center" style="color: #424242;">Total Enviado</th>
                                    <th class="text-center" style="color: #424242;">Fecha Entrega</th>
                                    <th class="text-center" style="color: #424242;">A Sucursal </th>
                                    <th class="text-center" style="color: #424242;">Estado</th>
                                    @role('Super Admin|Contabilidad|Chef Corporativo')
                                    <th style="color: #fff;"></th>
                                    @endrole
                                </thead>
                                <tbody>
                                    @foreach ($pedidos_producciones as $pedido_produccion)
                                    @php
                                    $hora = new DateTime($pedido_produccion->created_at);
                                    $hora_solicitado = $hora->format('H:i:s')
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('pedidos_producciones.show', $pedido_produccion->id) }}" value=""> {{$pedido_produccion->id}} - {{$pedido_produccion->sucursal_usuario->id}} </a>
                                        </td>
                                        <td class="text-center">{{$pedido_produccion->fecha_pedido}}</td>
                                        <td class="text-center">{{$hora_solicitado}}</td>
                                        <td class="text-center">{{$pedido_produccion->sucursal_usuario->nombre}}</td>

                                        <td class="text-center">{{$pedido_produccion->total_solicitado}} Bs</td>
                                        <td class="text-center">{{$pedido_produccion->total_enviado}} Bs</td>
                                        <td class="text-center">{{$pedido_produccion->fecha_pedido}} </td>
                                        <td class="text-center">{{$pedido_produccion->sucursal_pedido->nombre}}</td>

                                        @if ($pedido_produccion->estado == 'S' )
                                        <td class="text-center"> <span class="badge badge-warning"> Solicitado </span></td>
                                        @elseif($pedido_produccion->estado == 'E' )
                                        <td class="text-center"> <button class="btn btn-success" onclick="cambiarEstado('{{$pedido_produccion->id}}')">Aceptar Pedido</button></td>
                                        @elseif($pedido_produccion->estado =='A')
                                        <td class="text-center"> <span class="badge badge-info">Aceptado</button></td>
                                        @endif
                                        @role('Super Admin|Contabilidad|Chef Corporativo')
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <a class="dropdown-item " href="{{ route('pedidos_producciones.edit', $pedido_produccion->id) }}">Editar</a>
                                                    </li>
                                                    <li></li>
                                                        <a class="dropdown-item " href="{{ route('pedidos_producciones.editarInsumos', $pedido_produccion->id) }}">Envio de Insumos</a>
                                                    </li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $pedido_produccion->id }}" onclick="deleteItem(this)">Eliminar</a></li>

                                                </ul>
                                            </div>
                                        </td>
                                        @endrole
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

@endsection

@section('scripts')

<script>
    let ruta_eliminar_pedido = "{{ route('pedidos_producciones.destroy','') }}";
    let ruta_index_pedido = "{{ route('pedidos_producciones.index') }}";

    let ruta_cambiarestado = "{{route('pedidos_producciones.cambiarEstado')}}";
    const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
</script>

<script>

    function cambiarEstado(e) {
        console.log(e);
        Swal.fire({
            title: 'Aceptar pedido ',
            text: "Desea aceptar el pedido enviado ? COD : " + e,
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Aceptar el pedido'
        }).then((result) => {
            if (result.isConfirmed) {
                //cambiar estado falta cambiar nomas, pero envia el id y listo

                fetch(ruta_cambiarestado, {
                        method: "POST",
                        body: JSON.stringify({
                            idpedido: e
                        }),
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": csrfToken,
                        },
                    })
                    .then((response) => {
                        return response.json();
                    })
                    .then((data) => {
                        iziToast.success({
                            title: 'SUCCESS!',
                            message: 'Pedido Aceptado',
                            position: "topRight",
                            timeout: 1500,
                            onClosed() {
                                window.location.href = ruta_index_pedido
                            }
                        })
                    })
                    .catch((error) => {
                        iziToast.error({
                            title: "ERROR",
                            message: "Error al aceptar el pedido",
                            position: "topRight",
                            timeout: 1500,

                        });
                    });
            }
        })
    }
</script>

<script>
    /*ELIMINAR UN PEDIDO*/
    function deleteItem(e) {
        let id = e.getAttribute("data-id");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: true,
        });
        swalWithBootstrapButtons
            .fire({
                title: "Esta seguro de que desea eliminar este registro?",
                text: "Este cambio no se puede revertir!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Si, Eliminar!",
                cancelButtonText: "No, Cancelar!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.value) {
                    if (result.isConfirmed) {
                        let id = e.getAttribute("data-id");
                        $.ajax({
                            type: "DELETE",
                            url: ruta_eliminar_pedido + "/" + id,
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                    "content"
                                ),
                            },
                            success: function(data) {
                                if (data.success) {
                                    swalWithBootstrapButtons
                                        .fire(
                                            "Eliminado!",
                                            "El registro ha sido eliminado.",
                                            "success"
                                        )
                                        .then(function() {
                                            window.location = ruta_index_pedido;
                                        });
                                }
                            },
                        });
                    }
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        "Cancelado",
                        "No se registro la eliminación",
                        "error"
                    );
                }
            });
    }
</script>

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
    });

</script>
@endsection
@endsection
@section('css')

.tablecolor {
background-color: #212121;
}

@endsection



