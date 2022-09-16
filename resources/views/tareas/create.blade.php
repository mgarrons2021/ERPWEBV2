@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Actividad</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">

                        <br>
                        <form action="{{ route('tareas.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre Actividad<span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name=" nombre" placeholder="Nombre de la tarea..">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sucursal_id">Defina la Sucursal<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="sucursal_id" class="form-control selectric">
                                                @foreach($sucursales as $sucursal)
                                                <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cargo_id">Defina el Cargo<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="cargo_id" class="form-control selectric">
                                                @foreach($cargos as $cargo)
                                                <option value="{{$cargo->id}}">{{$cargo->nombre_cargo}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hora">Hora de inicio <span class="required">*</span></label>
                                        <input type="time" class="form-control  @error('hora') is-invalid @enderror" name="hora_inicio" placeholder="Hora">
                                        @error('hora_inicio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hora">Hora Fin <span class="required">*</span></label>
                                        <input type="time" class="form-control  @error('hora') is-invalid @enderror" name="hora_fin" placeholder="Hora">
                                        @error('hora_fin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="turno"> Turno <span class="required">*</span></label>

                                        <div class="selectric-hide-select">
                                            <select name="turno" id="turno" class="form-control select">
                                                <option> Seleccione Turno.</option>
                                                <option> Ingreso</option>
                                                <option> Pre Turno</option>
                                                <option> Turno</option>
                                                <option> Post Turno</option>
                                                <option> Despacho </option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dia_semana"> Seleccione el Dia <span class="required">*</span></label>

                                        <div class="selectric-hide-select">
                                            <select name="dia_semana" id="dia_semana" class="form-control select">
                                                <option value="todos"> Todos Los dias.</option>
                                                <option value="lunes"> Lunes</option>
                                                <option value="martes"> Martes</option>
                                                <option value="miercoles"> Miercoles</option>
                                                <option value="jueves"> Jueves</option>
                                                <option value="viernes"> Viernes</option>
                                                <option value="sabado"> Sabado</option>
                                                <option value="domingo"> Domingo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>


                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-danger" href="{{route('tareas.index')}}">Volver</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection