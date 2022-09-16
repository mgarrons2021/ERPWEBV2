@extends('layouts.app', ['activePage' => 'actividades', 'titlePage' => 'Actividades del Personal'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Resultados evaluación del Personal</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-warning" href="{{route('evaluaciones.index')}}"><i class="fa fa-arrow-left"> Volver </i></a>
                        <br><br>
                        <div class="table-responsive ">
                            <table id="table" class="table table-striped">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;" class="text-center">CI</th>
                                    <th style="color: #fff;" class="text-center">Nombre y Apellido</th>
                                    <th style="color: #fff;" class="text-center">Cargo</th>
                                    <th style="color: #fff;" class="text-center">Sucursal</th>
                                    <th style="color: #fff;" class="text-center">Estado del Personal</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($usuarios as $usuario)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{ route('personales.evaluacionesUsuario', $usuario->id) }}" value="{{ $usuario->ci }}">{{ $usuario->ci }} </a>
                                        </td>

                                        <td class="text-center">{{ $usuario->name }} {{ $usuario->apellido }}</td>

                                        @if(isset($usuario->tareas[0]))

                                        <td class="text-center">{{ $usuario->tareas[0]->cargo->nombre_cargo }} </td>
                                        @else
                                        <td class="text-center">Sin cargo</td>
                                        @endif
                                        @if(isset($usuario->sucursals[0]))
                                        <td class="text-center"> {{ $usuario->sucursals[0]->nombre}} </td>
                                        @else
                                        <td class="text-center"> Sin sucursal asignada </td>
                                        @endif
                                        @if ($usuario->estado == 1)
                                        <td class="text-center">
                                            <div class="badge badge-success">Activo</div>
                                        </td>
                                        @endif
                                        @if ($usuario->estado == 0)
                                        <td class="text-center">
                                            <div class="badge badge-danger">Inactivo</div>
                                        </td>
                                        @endif
                                        <td class="text-center">
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
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
        message: "El personal se ha contratado exitosamente",
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

        responsive: true,
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
<script>
    $(document).ready(function() {

        if (window.innerWidth < 768) {
            $('.btn').addClass('btn-sm');
        }

        // Medida por defecto (Sin ningún nombre de clase)
        else if (window.innerWidth < 900) {
            $('.btn').removeClass('btn-sm');
        }

        // Si el ancho del navegador es menor a 1200 px le asigno la clase 'btn-lg' 
        else if (window.innerWidth < 1200) {
            $('.btn').addClass('btn-lg');
        }

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