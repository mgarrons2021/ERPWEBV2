@extends('layouts.app', ['activePage' => 'categorias_cc', 'titlePage' => 'Categorias_CC'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Categorias de Gastos</h3>

    </div>
    <div class="section-body">
        <div class="row">         
            <div class="col-lg-12">


                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('categorias_gastos_administrativos.create')}}">Nueva categoria</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">ID</th>
                                    <th style="color: #fff;text-align:center">Codigo</th>
                                    <th style="color: #fff;text-align:center">Nombre</th>
                                    <th style="color: #fff;text-align:center">Sub. Categoria</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($categorias_gastos_administrativos as $categoria)
                                    <tr>
                                        <td style="text-align:center">
                                            <a href="{{route('categorias_gastos_administrativos.show', $categoria->id)}}" value="{{$categoria->id}}">{{$categoria->id}} </a>
                                        </td>

                                        <td style="text-align:center">{{$categoria->codigo}}</td>
                                        <td style="text-align:center">{{$categoria->nombre}}</td>
                                        <td style="text-align:center">{{$categoria->sub_categoria->sub_categoria}}</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('categorias_gastos_administrativos.edit', $categoria->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $categoria->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    let ruta_eliminarCategoria = "{{route('categorias_gastos_administrativos.destroy','')}}"
    let ruta_indexCategoria = "{{route('categorias_gastos_administrativos.index')}}"
/*ELIMINAR UNA CATEGORIA DE CAJA CHICA*/
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
                        url: ruta_eliminarCategoria + "/" + id,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        success: function (data) {
                            if (data.success) {
                                swalWithBootstrapButtons
                                    .fire(
                                        "Eliminado!",
                                        "El registro ha sido eliminado.",
                                        "success"
                                    )
                                    .then(function () {
                                        window.location = ruta_indexCategoria;
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
        columnDefs: [
            {
                orderable: false,
                targets: 2
            }
        ]
    });
</script>
@endsection
@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection