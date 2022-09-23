@extends('layouts.app', ['activePage' => 'inventarios', 'titlePage' => 'Inventario'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Inventarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">


                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('inventarios.filtrarInventario')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="datepicker">Seleccione las Fechas</label>
                                    <div class=" input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar Inventario" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('inventarios.create')}}">Nuevo Inventario</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">ID</th>
                                    <th style="color: #fff;text-align:center">Fecha de Inventario</th>
                                    <th style="color: #fff;text-align:center">Hora de Inventario</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Total</th>
                                    <th style="color: #fff;text-align:center">Turno</th>
                                    <th style="color: #fff;text-align:center">Tipo de Inventario</th>
                                    <th style="color: #fff;text-align:center">Funcionario</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($inventarios as $inventario)
                                    <tr>
                                        <td style="text-align:center;">
                                            <a href="{{route('inventarios.show', $inventario->id)}}" value="{{$inventario->id}}">{{$inventario->id}} </a>
                                        </td>
                                        <td style="text-align:center;">{{$inventario->fecha}}</td>
                                        <td style="text-align:center;">{{$inventario->created_at->format('H:i:s')}}</td>
                                        <td style="text-align:center;">{{$inventario->sucursal->nombre}}</td>
                                        <td style="text-align:center;">{{$inventario->total}} Bs</td>
                                        <td style="text-align:center;">
                                            @if( isset($inventario->turno->turno))
                                            {{$inventario->turno->turno}}
                                            @else
                                            S/T
                                            @endif
                                        </td>
                                        <td style="text-align:center;">
                                            @if($inventario->tipo_inventario=="D")
                                            Diario
                                            @else
                                            Semanal
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{$inventario->user->name}}</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('inventarios.showInventarioSistema', $inventario->id) }}">Ver Inventario Sistema</a></li>
                                                    <li><a class="dropdown-item " href="{{ route('inventarios.edit', $inventario->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $inventario->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
    let ruta_eliminarInventario = "{{ route('inventarios.destroy','') }}";
    let ruta_indexInventario = "{{ route('inventarios.index') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/inventarios/index.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



@endsection