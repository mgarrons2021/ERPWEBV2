@extends('layouts.app', ['activePage' => 'traspasos', 'titlePage' => 'Traspaso'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Traspasos</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">

              
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: hidden">
                        <form action="{{route('traspasos.filtrartraspaso')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                <label for="datepicker">Seleccione las Fechas</label>
                                    <div class=" input-group" id="datepicker">
                                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                                        <span class="input-group-addon">A</span>
                                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                                        <input class="form-control btn btn-primary float-left" type="submit" value="Filtrar Traspaso" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
           

                <div class="card">
                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('traspasos.create')}}">Nuevo Traspaso</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">ID</th>
                                    <th style="color: #fff;text-align:center">Fecha de Traspaso</th>
                                    <th style="color: #fff;text-align:center">Funcionario</th>
                                    <th style="color: #fff;text-align:center">De Sucursal</th>
                                    <th style="color: #fff;text-align:center">A Sucursal</th>
                                    <th style="color: #fff;text-align:center">Total de Eliminacion</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($traspasos as $traspaso)
                                    <tr>
                                        <td style="text-align:center;">
                                            <a href="{{route('traspasos.show', $traspaso->id)}}" value="{{$traspaso->id}}">{{$traspaso->id}} </a>
                                        </td>
                                        <td style="text-align:center;">{{$traspaso->fecha}}</td>
                                        <td style="text-align:center;">{{$traspaso->user->name}} {{$traspaso->user->apellido}}</td>
                                        <td style="text-align:center;">{{$traspaso->sucursal_principal->nombre}}</td>
                                        <td style="text-align:center;">{{$traspaso->sucursal_secundaria->nombre}}</td>
                                        <td style="text-align:center;">{{$traspaso->total}} Bs</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('traspasos.edit', $traspaso->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $traspaso->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
    let ruta_eliminartraspaso = "{{ route('traspasos.destroy','') }}";
    let ruta_indextraspaso = "{{ route('traspasos.index') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/traspasos/index.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

@endsection