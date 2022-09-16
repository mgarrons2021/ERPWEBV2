@extends('layouts.app', ['activePage' => 'postulantes', 'titlePage' => 'Reclutamientos de Personal'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Personal Reclutado</h3>

    </div>
    <div class="section-body">
        <div class="row">
            {{-- <a class="btn btn-outline-info" href="{{ route('postulantes.create') }}">Nuevo personal</a><br><br> --}}
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{ route('postulantes.create') }}">Nuevo personal</a>
                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">
                                    
                                    <th style="color: #fff;">Nombre y Apellido</th>
                                    <th style="color: #fff;">Celular Personal</th>
                                    <th style="color: #fff;">Observaciones</th>
                                    <th style="color: #fff;">Estado Entrevistado</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($postulante as $personal)
                                        <tr> 
                                            <td>{{ $personal->name }} {{ $personal->apellido }}</td>
                                            <td>{{ $personal->celular_personal }} </td>
                                            <td>{{ $personal->observacion }} </td>
                                            @if ($personal->estado == 1)
                                                <td>
                                                    <div class="badge badge-success">Entrevistado</div>
                                                </td>
                                            @endif
                                            @if ($personal->estado == 0)
                                                <td>
                                                    <div class="badge badge-danger">No Entrevistado</div>
                                                </td>
                                            @endif
                                        <td>
                                                <div class="dropdown" style="position: absolute;">
                                                    <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                        <li><a href="{{route('postulantes.editDatosBasicos', $personal->id) }}" class="dropdown-item ">Actualizar</a></li>
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
@if (session('eliminar') == 'ok')
    <script>
        Swal.fire(
            'Eliminado!',
            'Tu registro ha sido eliminado.',
            'success'
        )
    </script>
@endif

@if (session('contratar') == 'ok')
    <script>
        iziToast.success({
            title: 'BIEN',
            message: "El personal se ha registrado exitosamente",
            position: 'topRight',
        });
    </script>
@endif
@if (session('actualizado') == 'ok')

<script>
    iziToast.success({
        title: 'Success!',
        message: "Los datos basicos se han actualizado exitosamente",
        position: 'topRight',
    });
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
                    targets: 4
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
