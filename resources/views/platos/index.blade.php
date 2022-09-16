@extends('layouts.app', ['activePage' => 'platos', 'titlePage' => 'Platos'])

@section('content')

@section('css')
@endsection
<meta name="csrf-token" content="{{ csrf_token() }}">
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Platos Ofertados</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header titulo">
                      Gestión de platos  &nbsp 
                        <a class="btn btn-primary" href="{{ route('platos.create') }}">Agregar</a><br><br>
                    </div>
                    <div class="card-body"> 
                        <div>
                            <table  id="table"  class="table  table-bordered dt-responsive nowrap" style="width: 100%;">
                                <thead class="table-primary">
                                    <th class="text-center">Nombre Plato</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Costo del plato</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach ($platos as $plato)
                                    <tr>
                                        <td class="text-center ">
                                            <a href="{{ route('platos.show', $plato->id) }}" value="{{ $plato->nombre }}">{{ $plato->nombre}} </a>
                                        </td>

                                        @if ($plato->estado == 1)
                                        <td class="text-center"> <span class="badge badge-success"> Ofertado </span></td>
                                        @else
                                        <td class="text-center"> <span class="badge badge-warning"> De baja </span></td>
                                        @endif
                                         
                                        @if(isset( $plato->costo_plato))
                                        <td  class="text-center table-primary "> Bs. {{ $plato->costo_plato}} </td>
                                        @else 
                                        <td class="text-center"> Este plato no contiene receta</td>
                                        @endif 
                                        <td class="text-center table-light">
                                            <div class="dropdown" style="position: relative;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" >
                                                    <i class="fas fa-ellipsis-v"> </i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('platos.edit', $plato->id) }}">Editar Plato</a>
                                                        <form action="{{route('platos.destroy',$plato->id)}}" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                                            @csrf
                                                            @method('Delete')
                                                            <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar Plato</a>
                                                        </form>
                                                        <a  class="dropdown-item href" href="{{ route('platos.asignarReceta',$plato->id) }}">Asignar Receta</a>
                                                        <a  class="dropdown-item href" href="{{ route('recetas.edit',$plato->id) }}">Editar Receta</a>
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


@if(session('receta')=='true')
<script>
    iziToast.warning({
    title: 'Alerta!',
    message: 'Este plato no tiene receta porfavor asigne una.',
    timeout: 2000,
});
</script>
@elseif(session('receta')=='tiene')
<script>
    iziToast.warning({
    title: 'Alerta!',
    message: 'Este plato ya contiene una receta.',
    timeout: 2000,
});
</script>
@endif
@section('page_js')
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
        columnDefs: [{
            orderable: false,
            targets: 4
        }]
  
    });
});
</script>

@endsection


@endsection
@section('page_css')
<style>
.titulo{
    font-weight: bold;
}
.ahref{
    background-color: whitesmoke;
}
</style>
@endsection