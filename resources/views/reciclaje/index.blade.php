@extends('layouts.app', ['activePage' => 'eliminaciones', 'titlePage' => 'Eliminaciones'])
@section('content')
@section('css')
@endsection
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Gestión de Reciclaje</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                @role('Super Admin|Encargado')
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('reciclajes.filtrarreciclaje')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                <label for="datepicker">Seleccione las Fechas</label>
                                    <div class=" input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        <input class="form-control btn btn-primary float-left" type="submit" value="Filtrar Reciclajes" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endrole  

                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-primary" href="{{route('reciclajes.create')}}">Nuevo Reciclaje</a><br><br>
                        <div class="">
                            <table class="table table-striped dt-responsive nowrap" id="table" style="width: 100%;">
                                <thead class="bg-primary">
                                    <th style="color: #fff;text-align:center">Fecha</th>
                                    <th style="color: #fff;text-align:center">Funcionario</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Total Reciclaje</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($reciclajes as $reciclaje)
                                    <tr>
                                        @php $fecha_formateada = date('d-m-Y', strtotime($reciclaje->fecha)); @endphp
                                        <td style="text-align:center;">
                                            <a href="{{route('reciclajes.show', $reciclaje->id)}}" value="{{$reciclaje->id}}"> {{$fecha_formateada}} </a>
                                        </td>
                                        <td style="text-align:center;">{{$reciclaje->user->name}}</td>
                                        <td style="text-align:center;">{{$reciclaje->sucursal->nombre}}</td>
                                        @if($reciclaje->total == 0)
                                        <td style="text-align:center;"> <div class="badge bg-danger"> Sin reciclaje</div>  </td>
                                        @else
                                        <td style="text-align:center;"> Bs {{  number_format( $reciclaje->total,2 )}}</td>
                                        @endif
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('reciclajes.edit', $reciclaje->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $reciclaje->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
    let ruta_eliminarreciclaje = "{{ route('reciclajes.destroy','') }}";
    let ruta_indexreciclaje = "{{ route('reciclajes.index') }}";
</script>
<script type="text/javascript" src="{{ URL::asset('assets/js/reciclajes/index.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
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