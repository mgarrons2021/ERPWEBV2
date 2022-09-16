@extends('layouts.app', ['activePage' => 'usuarios_sucursales', 'titlePage' => 'Usuarios_Sucursales'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Asignar Usuario a Sucursal </h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary">
                        <div class="card-body">
                                <br>
                                <form action="{{ route('usuarios_sucursales.create') }}" method="POST"
                                    class="form-horizontal">
                                    @csrf
                                    <div class="row">

                                   
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="user_id">Seleccione el Usuario<span
                                                        class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="user_id" class="form-control selectric">
                                                        @foreach ($users as $user)
                                                            <option value="{{ $user->id }}">{{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="sucursal_id">Escoja la Sucursal<span
                                                        class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="sucursal_id" class="form-control selectric">
                                                        @foreach ($sucursales as $sucursal)
                                                            <option value="{{ $sucursal->id }}">{{ $sucursal->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                      
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Asignar Usuario</button>
                                            <a class="btn btn-danger"
                                                href="{{ route('usuarios_sucursales.create') }}">Cancelar</a>
                                        </div><br>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
