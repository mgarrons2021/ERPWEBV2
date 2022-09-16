@extends('layouts.app', ['activePage' => 'cajas_chicas', 'titlePage' => 'CajaChica'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registros de Caja Chica</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">

                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('contabilidad.filtrarIndexCajaChica')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                <label for="datepicker">Seleccione las Fechas</label>
                                    <div class=" input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        <input class="form-control btn btn-primary float-left" type="submit" value="Filtrar Caja chica" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </div>
                           
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('cajas_chicas.create')}}">Nuevo Registro de Caja Chica</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">Nro </th>
                                    <th style="color: #fff;text-align:center">Funcionario Encargado</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Fecha de Registro</th>
                                    <th style="color: #fff;text-align:center">Total Caja Chica</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($cajas_chicas as $caja_chica)
                                    <tr>
                                        <td style="text-align:center;">
                                            <a href="{{route('cajas_chicas.show', $caja_chica->id)}}" value="{{$caja_chica->id}}">{{$caja_chica->id}} </a>
                                        </td>
                                        <td style="text-align:center;">{{$caja_chica->user->name}} {{$caja_chica->user->apellido}}</td>
                                        <td style="text-align:center;">{{$caja_chica->sucursal->nombre}}</td>
                                        <td style="text-align:center;">{{$caja_chica->fecha}}</td>
                                        <td style="text-align:center;">{{$caja_chica->total_egreso}} Bs</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('cajas_chicas.edit', $caja_chica->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $caja_chica->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
    
</script>
<script>
    let ruta_indexCajaChica = "{{ route('cajas_chicas.index') }}";
    let ruta_eliminarCajaChica = "{{ route('cajas_chicas.destroy','') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/cajas_chicas/index.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@endsection