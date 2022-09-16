@extends('layouts.app', ['activePage' => 'descuentos', 'titlePage' => 'Descuentos'])

@section('content')
@section('css')
@endsection

<section class="section">

    <div class="section-header">
        <h3 class="page__heading">Descuentos Aplicados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                            Asignar Descuento
                        </button>
                        <p>&nbsp</p>
                        <div class="table-responsive">

                            <table class="table table-striped mt-15 " id="table">
                                <thead style="background-color: #6777ef;">
                                    <!---->
                                    <!--<th style="display:none;">ID</th>-->
                                    <th style="color: #fff;">Nombre</th>
                                    <th style="color: #fff;">Monto</th>
                                    <th style="color: #fff;">Motivo</th>
                                    <th style="color: #fff;">Fecha</th>
                                    <th style="color: #fff;"></th>
                                    <!-- <th style="color: #fff;">Acciones</th> -->
                                </thead>
                                <tbody>
                                    @foreach ($descuentos as $descuento)
                                        <tr>
                                            <td>
                                                <a href="{{ route('descuentos.show', $descuento->id) }}">{{ $descuento->user->name }}
                                                </a>
                                            </td>

                                            <td>{{ $descuento->monto }}</td>
                                            <td>{{ $descuento->motivo }}</td>
                                            <td>{{ $descuento->fecha }}</td>
                                            <td>
                                                <div class="dropdown" style="position: absolute;">
                                                    <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                                        <li>
                                                            <form
                                                                action="{{ route('descuentos.destroy', $descuento->id) }}"
                                                                id="formulario-eliminar2" class="formulario-eliminar"
                                                                method="POST">
                                                                @csrf
                                                                @method('Delete')
                                                                <a class="dropdown-item" href="javascript:;"
                                                                    onclick="document.getElementById('formulario-eliminar2').submit()"
                                                                    id="enlace">Eliminar</a>
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

            </div>
        </div>

    </div>
    </div>




</section>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese los datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('descuentos.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="form-group">
                        <label for="user_id">Seleccione al usuario <span class="required">*</span></label>
                        <div class="selectric-hide-select">
                            <select name="user_id" class="form-control selectric">
                                @foreach ($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="monto" class="col-form-label">Monto a descontar</label>
                        <input type="number" class="form-control" id="monto" name="monto">
                    </div>
                    <div class="form-group">
                        <label for="fecha" class="col-form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                    <div class="form-group">
                        <label for="motivo" class="col-form-label">Motivo del descuento:</label>
                        <textarea class="form-control" id="motivo" name="motivo"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Descontar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_js')
@section('scripts')
    @if (session('eliminar') == 'ok')
        <script>
            Swal.fire(
                'Eliminado!',
                'Tu registro ha sido eliminado.',
                'success'
            )
        </script>
    @endif

    <script>
        $('.formulario-eliminar').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Estas Seguro(a)?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Eliminarlo!'
            }).then((result) => {
                if (result.value) {
                    /*  Swal.fire(
                         'Deleted!',
                         'Your file has been deleted.',
                         'success'
                     ) */
                    console.log(this);
                    this.submit();
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
                    targets: 3
                },
                {
                    orderable: false,
                    targets: 4
                }
            ]
        });
    </script>
@endsection
@endsection
@endsection

@section('page_css')
<style>
.tablecolor {
    background-color: #212121;
}

</style>
@endsection
