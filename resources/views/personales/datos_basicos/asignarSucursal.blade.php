@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Sucursales Activas</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('personales.saveasignarSucursal', $user->id) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h3 class="text-left">Sucursales Asignadas a: {{$user->name}} {{$user->apellido}}</h3>
                                {{-- <label for="sucursals" class="col-sm-3 col-form-label">Asignar Sucursales a: {{$user->name}}</label> --}}
                                <div class="form-group">
                                    <div class="tab-pane active">
                                        <br>
                                        <table class="table table-bordered table-md">
                                            <thead>
                                                {!! Form::model($user, ['route' => ['personales.saveasignarSucursal', $user], 'method' => 'put']) !!}
                                                @foreach ($sucursales as $sucursal)
                                                <tr>
                                                    <th>
                                                        <label class="form-check-label">
                                                            {!! Form::checkbox('sucursals[]', $sucursal->id, null, ['class' => 'form-check-input ']) !!}
                                                            {{ $sucursal->nombre }}
                                                        </label>
                                                    </th>
                                                </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('personales.index') }}" class="btn btn-warning" style="color:white">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection