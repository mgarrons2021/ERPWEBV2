@extends('layouts.app', ['activePage' => 'reciclajes', 'titlePage' => 'reciclajes'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Eliminaciones</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                @role('Super Admin|Encargado')
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('eliminaciones.filtrarEliminacion')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                <label for="datepicker">Seleccione las Fechas</label>
                                    <div class=" input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        <input class="form-control btn btn-primary float-left" type="submit" value="Filtrar Eliminaciones" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                </div>
                @endrole

                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('eliminaciones.create')}}">Nueva Eliminacion</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">ID</th>
                                    <th style="color: #fff;text-align:center">Funcionario</th>
                                    <th style="color: #fff;text-align:center">Fecha de Eliminacion</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Total de Eliminacion</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($eliminaciones as $eliminacion)
                                    <tr>
                                        <td style="text-align:center;">
                                            <a href="{{route('eliminaciones.show', $eliminacion->id)}}" value="{{$eliminacion->id}}">{{$eliminacion->id}} </a>
                                        </td>
                                        <td style="text-align:center;">{{$eliminacion->user->name}} {{$eliminacion->user->apellido}}</td>
                                        <td style="text-align:center;">{{$eliminacion->fecha}}</td>
                                        <td style="text-align:center;">{{$eliminacion->sucursal->nombre}}</td>
                                        <td style="text-align:center;">{{$eliminacion->total}} Bs</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('eliminaciones.edit', $eliminacion->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $eliminacion->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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

<script>
    let ruta_eliminareliminacion = "{{ route('eliminaciones.destroy','') }}";
    let ruta_indexeliminacion = "{{ route('eliminaciones.index') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/eliminaciones/index.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

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
            targets: 5
        }]
    });
</script>

@endsection