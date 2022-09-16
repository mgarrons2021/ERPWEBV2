@extends('layouts.app', ['activePage' => 'mantenimientos', 'titlePage' => 'mantenimiento'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Ya pue Bono Miguelin </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-body">
                        <a class="btn btn-outline-info" href="{{route('mantenimiento.create')}}">Nuevo Registro de Mantenimiento</a><br><br>
                        <div class="table-responsive">
                            <table class="table table-bordered " id="table">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;text-align:center">Nro </th>
                                    <th style="color: #fff;text-align:center">Funcionario Encargado</th>
                                    <th style="color: #fff;text-align:center">Sucursal</th>
                                    <th style="color: #fff;text-align:center">Fecha de Registro</th>
                                    <th style="color: #fff;text-align:center">Total Gasto</th>
                                    <th style="color: #fff;text-align:center"></th>
                                </thead>
                                <tbody>
                                    @foreach ($mantenimiento as $mantenimientos)
                                    <tr>
                                        <td style="text-align:center;">
                                            <a href="{{route('mantenimiento.show', $mantenimientos->id)}}" value="{{$mantenimientos->id}}">{{$mantenimientos->id}} </a>
                                        </td>
                                        <td style="text-align:center;">{{$mantenimientos->user->name}} {{$mantenimientos->user->apellido}}</td>
                                        <td style="text-align:center;">{{$mantenimientos->sucursal->nombre}}</td>
                                        <td style="text-align:center;">{{$mantenimientos->fecha}}</td>
                                        <td style="text-align:center;">{{$mantenimientos->total_egreso}} Bs</td>
                                        <td>
                                            <div class="dropdown" style="position: absolute;">
                                                <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item " href="{{ route('mantenimiento.edit', $mantenimientos->id) }}">Editar</a></li>
                                                    <li><a href="#" class="dropdown-item" data-id="{{ $mantenimientos->id }}" onclick="deleteItem(this)">Eliminar</a></li>
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
    let ruta_indexMantenimiento = "{{ route('mantenimiento.index') }}";
    let ruta_eliminarMantenimiento = "{{ route('mantenimiento.destroy','') }}";
</script>

<script type="text/javascript" src="{{ URL::asset('assets/js/mantenimiento/index.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
@endsection