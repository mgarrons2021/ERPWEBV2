@extends('layouts.app', ['activePage' => 'categorias_plato', 'titlePage' => 'Categorias Plato'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Categorias Platos</h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('categorias_platos.create')}}">Nueva Categoria</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table">
                                <thead style="background-color: #6777ef;">
                                    <th class="text-center" style="color: #fff;">Nombre</th>
                                    <th class="text-center" style="color: #fff;">Estado</th>
                                    <th style="color: #fff;"></th>
                                </thead>
                                <tbody>
                                    @foreach ($categorias_platos as $categoria_plato)
                                    <tr>
                                       
                                        <td class="text-center">{{$categoria_plato->nombre}} </td>
                                        <td class="text-center" >
                                            @if($categoria_plato->estado==1)
                                            <div class="badge badge-pill badge-success">Activo</div>
                                            @endif
                                            @if($categoria_plato->estado==0)
                                            <div class="badge badge-pill badge-danger">Inactivo</div>
                                            @endif
                                        </td>
                                        
                                       

                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('categorias_platos.edit', $categoria_plato->id) }}">Editar</a></li>
                                                    <li>
                                                        <form action="{{route('categorias_platos.destroy',$categoria_plato->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
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
            targets: 2
        }, ]
    });
</script>

@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;

}
@endsection