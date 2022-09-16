@extends('layouts.app', ['activePage' => 'pedido', 'titlePage' => 'Pedidos'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Pedidos Registrados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card">
                @role('Super Admin|Contabilidad|Chef Corporativo')
                <div class="card-header">
                    <h4>Seleccione la fecha a Filtrar</h4>
                </div>
                @endrole
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('pedidos.filtrarPedidos')}}" method="POST">
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
                        <a class="btn btn-outline-danger" href="{{route('pedidos.create')}}">Nuevo Pedido</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-15 " id="table">
                                <thead class="bg-info">
                                    <!---->
                                    <th class="text-center" style="color: #424242;">Codigo</th>
                                    <th class="text-center" style="color: #424242;">Fecha Pedido</th>
                                    <th class="text-center" style="color: #424242;">Fecha Entrega</th>
                                    <th class="text-center" style="color: #424242;">Hora Pedido</th>
                                    <th class="text-center" style="color: #424242;">De Sucursal</th>
                                    <th class="text-center" style="color: #424242;">Usuario</th>
                                    <th class="text-center" style="color: #424242;">Total Solicitado</th>
                                    <th class="text-center" style="color: #424242;">Total Enviado</th>
                                    @role('Super Admin|Contabilidad|Chef Corporativo')
                                    <th class="text-center" style="color: #424242;">Estado</th>
                                    @endrole
                                    <th class="text-center" style="color: #424242;">Opciones</th>
                                    @role('Super Admin|Contabilidad|Chef Corporativo')
                                    <th class="text-center" style="color: #fff;"></th>
                                    @endrole

                                </thead>
                                <tbody>
                                    @foreach($pedidos as $pedido)
                                    @php
                                    $hora = new DateTime($pedido->created_at);
                                    $hora_solicitado = $hora->format('H:i:s')
                                    @endphp
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('pedidos.show', $pedido->id) }}" value=""> {{$pedido->id}} - {{$pedido->sucursal_principal->id}} </a>
                                        </td>
                                        <td class="text-center">{{$pedido->fecha_actual}}</td>
                                        <td class="text-center">{{$pedido->fecha_pedido}} </td>
                                        <td class="text-center">{{$hora_solicitado}}</td>

                                         <td class="text-center">{{$pedido->sucursal_principal->nombre}}</td>
                                        <td class="text-center">{{$pedido->user->name}}</td>
                                        <td class="text-center">{{$pedido->total_solicitado}} Bs</td>
                                        <td class="text-center">
                                            @if(is_null($pedido->total_enviado))
                                            <span class="badge badge-warning"> Sin Enviar</span>
                                            @else
                                            {{$pedido->total_enviado}} Bs
                                            @endif 
                                        </td>


                                        @if ($pedido->estado == 'S' || $pedido->estado == 'P' || $pedido->estado == '0' )
                                        <td class="text-center"> <span class="badge badge-danger"> Pendiente </span></td>
                                        @elseif($pedido->estado == 'E' || $pedido->estado == '1' )
                                        <td class="text-center">
                                            <button class="btn btn-warning btn-sm" onclick="cambiarEstado('{{$pedido->id}}')">Aceptar Pedido</button>
                                        </td>
                                        @elseif($pedido->estado =='A')
                                        <td class="text-center"> <span class="badge badge-success">Aceptado</span></td>
                                        @endif

                                        @role('Super Admin|Contabilidad|Chef Corporativo')

                                        @if($pedido->estado_impresion=="N")
                                        <td style="text-align: center;"> <a href="{{ route('pedidos.VaucherPdf', $pedido->id) }}" class="btn btn-light btn-sm " style="border-radius: 8px;color:red">PDF</a></td>
                                        @else
                                        <td style="text-align: center;"> <a href="{{ route('pedidos.VaucherPdf', $pedido->id) }}" class="btn btn-light btn-sm " style="border-radius: 8px;color:green">PDF</a></td>
                                        @endif
                                    @endrole
                                      
                                    @role('Super Admin|Contabilidad|Chef Corporativo')

                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <a class="dropdown-item " href="{{ route('pedidos.edit', $pedido->id) }}">Editar</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item " href="{{ route('pedidos.editPedidoEnviado', $pedido->id) }}">Envio de Insumos</a>
                                                    </li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $pedido->id }}" onclick="deleteItem(this)">Eliminar</a></li>

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<script>
    let ruta_eliminarPedido = "{{ route('pedidos.destroy','') }}";
    let ruta_indexPedido = "{{ route('pedidos.index') }}";
    let ruta_cambiarestado = "{{route('pedidos.cambiarEstado')}}";
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
                        console.log(data);
                        if(data.status){
                            iziToast.success({
                                title: 'SUCCESS!',
                                message: 'Pedido Aceptado',
                                position: "topRight",
                                timeout: 1500,
                                onClosed() {
                                    window.location.href = ruta_indexPedido
                                }
                            })
                        }else{
                            iziToast.warning({
                                title: 'WARNING!',
                                message: 'Pedido no se actualizo correctamente',
                                position: "topRight",
                                timeout: 1500,                                
                            })
                        }
                       
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


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@if(session('eliminar')=='ok')

<script>
    Swal.fire(
        'Eliminado!',
        'Tu registro ha sido eliminado.',
        'success'
    )
</script>
@endif

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
                            url: ruta_eliminarPedido + "/" + id,
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
                                            window.location = ruta_indexPedido;
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