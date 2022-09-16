@extends('layouts.app', ['activePage' => 'cronologias', 'titlePage' => 'Cronologias'])

@section('content')
@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Cronologias</h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{ route('cronologias.create') }}">Nueva
                            Cronologia</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;">ID</th>
                                    <th style="color: #fff;">Funcionario Encargado</th>
                                    <th style="color: #fff;">Fecha</th>
                                    <th style="color: #fff;">Descripcion</th>
                                    <th style="color: #fff;">Funcionario Observado</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($cronologias as $cronologia)
                                        <tr>
                                            <td>
                                                <a href="{{ route('cronologias.show', $cronologia->id) }}"
                                                    value="{{ $cronologia->id }}">{{ $cronologia->id }} </a>
                                            </td>

                                            <td>{{ $cronologia->user->name }}</td>
                                            <td>{{ $cronologia->fecha_cronologia }}</td>
                                            <td>{{ $cronologia->descripcion }}</td>
                                            <td>{{ $cronologia->detalle_Cronologia->user->name}} </td>
                                            <td>
                                                <div class="dropdown" style="position: absolute;">
                                                    <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li><a class="dropdown-item "
                                                                href="{{ route('cronologias.edit', $cronologia->id) }}">Editar</a>
                                                        </li>
                                                        <li><a href="#" class="dropdown-item"
                                                                data-id="{{ $cronologia->id }}"
                                                                onclick="deleteItem(this)">Eliminar</a></li>
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
<script type="application/javascript">
    function deleteItem(e) {
        let id = e.getAttribute('data-id');
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: true
        });
        swalWithBootstrapButtons.fire({
            title: 'Esta seguro de que desea eliminar este registro?',
            text: "Este cambio no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!',
            cancelButtonText: 'No, Cancelar!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {
                    let id = e.getAttribute('data-id');
                    $.ajax({
                        type: 'DELETE',
                        url: '{{ route('cronologias.destroy', '') }}/' + id,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success) {
                                swalWithBootstrapButtons.fire(
                                    'Eliminado!',
                                    'El registro ha sido eliminado.',
                                    "success",
                                ).then(function() {
                                    window.location = "cronologias";
                                });
                            }
                        }
                    });
                }
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'No se registro la eliminación',
                    'error'
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
            columnDefs: [{
                    orderable: false,
                    targets: 3
                }

            ]
        });
    </script>
@endsection
@endsection

@section('css')
@endsection
