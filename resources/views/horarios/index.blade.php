@extends('layouts.app', ['activePage' => 'horarios', 'titlePage' => 'horarios'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Horario Fijo del Personal</h3>

    </div>
    
    <div class="section-body">
        <div class="row">
            
       
            <div class="col-lg-12">
                
                <div class="card">
                        
                    <div class="card-body">
                    <a class="btn btn-info  float-left" href="{{ route('horarios.reporteHorario') }}">Reporte de Asistencias</a> 
                    <br>
               
 
                    <div class="table-responsive">
                    
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;">Usuario</th>
                                    <th style="color: #fff;">Sucursal</th>
                                    <th style="color: #fff;">Hora Ingreso Fija</th>
                                    <th style="color: #fff;">Horario Salida Fija</th>
                                    <th style="color: #fff;">Turno</th>
                                  

                                    <th style="color: #fff;"></th>
                                    <!-- <th style="color: #fff;"></th> -->
                                    <!-- <th style="color: #fff;">Acciones</th> -->
                                </thead>
                                <tbody>
                                    @foreach ($horarios as $horario)
                                    <tr>
                                        <td>{{$horario->User->name}}</td>
                                        <td>{{$horario->Sucursal->nombre}}</td>
                                        <td>{{$horario->hora_ingreso}}</td>
                                        <td>{{$horario->hora_salida_fija}}</td>
                                        <td>{{$horario->turno}}</td>

                                        <td>
                                        <div class="dropdown" style="position: absolute;" >
                                            <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item " href="{{ route('horarios.create', $horario->id) }}">Editar</a></li>
                                                <li>
                                                    <form action="{{route('horarios.create',$horario->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                    @csrf
                                                    @method('Delete')
                                                    <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
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
</section>
@endsection
@section('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

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
        columnDefs: [
        { orderable: false, targets: 4 },
        { orderable: false, targets: 5 }
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