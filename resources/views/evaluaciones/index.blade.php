@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Evaluaciones</h3>
        <meta name="csrf-token" content="{{ csrf_token() }}">
       
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
               
                      
                    <div class="card-body">
                        @role('Super Admin|RRHH')
                          <a class="btn btn-warning  float-right" href="{{ route('personales.reporteEvaluaciones') }}">Resultados</a>
                    
                        <a class="btn btn-primary " href="{{route('evaluaciones.create')}}">Nuevo criterio de evaluación</a><br><br>
                        @endrole 
                     
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">                   
                                    <th style="color: #fff;" class="text-center">Nombre</th>
                                    <th style="color: #fff;" class="text-center">Cargo asignado</th>
                                    <th style="color: #fff;" class="text-center">Categoria</th>
                                    <th style="color: #fff;"></th>
                                    <!-- <th style="color: #fff;">Acciones</th> -->
                                </thead>
                                <tbody>
                                    @foreach ($evaluaciones as $evaluacion)
                                    <tr>
        
                                        <td class="text-center">{{$evaluacion->nombre}}</td>
                                        <td class="text-center">{{$evaluacion->cargo->nombre_cargo}}</td>
                                        <td class="text-center"> {{($evaluacion->categoria)}} </td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item"
                                                        href="{{ route('evaluaciones.edit', $evaluacion->id) }}">Editar
                                                        </a>
                                                </li>

                                                <li><a href="#" class="dropdown-item"
                                                                data-id="{{ $evaluacion->id }}"
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@section('page_js')
<script>
    $(document).ready(function(){
 
 if(window.innerWidth < 768){
     $('.btn').addClass('btn-sm');
 }
 
 // Medida por defecto (Sin ningún nombre de clase)
 else if(window.innerWidth < 900){
     $('.btn').removeClass('btn-sm');
 }

 // Si el ancho del navegador es menor a 1200 px le asigno la clase 'btn-lg' 
 else if(window.innerWidth < 1200){
     $('.btn').addClass('btn-lg');
 }

});
</script>
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
            }]
    });
</script>
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
                            url: '{{ route('evaluaciones.destroy', '') }}/' + id,
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
                                        window.location = "evaluaciones";
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
@endsection
@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection