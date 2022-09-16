@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Personal : {{ $usuario->name }} {{ $usuario->apellido }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @if ($usuario->foto != null)
                        <div align="center">
                            <img id="imagenPrevisualizacion" src="{{ url($usuario->foto) }}" width="150" height="130" />
                        </div>
                        <br>
                        <br>
                        @endif
                        @if ($usuario->foto == null || $usuario->foto === '')
                        <div align="center">
                            <img id="imagenPrevisualizacion" src="{{ url('img/no-user.png') }}" width="150" height="130" />
                        </div>
                        <br><br>
                        @endif
                        <form action="{{ route('personales.actualizarDatosBasicos', $usuario->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1">Foto</label>
                                        <input type="file" id="seleccionArchivos" class="form-control " name="foto" @if ($usuario->foto != null) value="{{ url($usuario->foto) }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ci">Carnet de Identidad <span class="required">*</span></label>
                                        <input type="text" class="form-control" name="ci" value="{{ $usuario->ci }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="nombre" value="{{ $usuario->name }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Apellido<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="apellido" value="{{ $usuario->apellido }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="direccion">Direccion<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="domicilio" value="{{ $usuario->domicilio }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="zona">Zona<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="zona" value="{{ $usuario->zona }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="celular_personal">Celular Personal<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="celular_personal" value="{{ $usuario->celular_personal }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="celular_referencia">Celular de Referencia<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="celular_referencia" value="{{ $usuario->celular_referencia }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="email" value="{{ $usuario->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="estado">Estado<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="estado" class="form-control selectric">
                                                @if ($usuario->estado === 1)
                                                <option value="1" selected>Activo</option>
                                                <option value="0">Inactivo</option>
                                                @endif
                                                @if ($usuario->estado === 0)
                                                <option value="1">Activo</option>
                                                <option value="0" selected>Inactivo</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                @role('Super Admin')
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="roles" class="col-sm-3 col-form-label">Roles</label>
                                        <div class="form-group">
                                            <div class="tab-pane active">
                                                <br>
                                                <table class="table table-bordered table-md" >
                                                    <thead>
                                                        {!! Form::model($usuario, ['route' => ['personales.actualizarDatosBasicos', $usuario], 'method' => 'put']) !!}
                                                        @foreach ($roles as $role)
                                                        <tr>
                                                            <th>
                                                                <label class="form-check-label">
                                                                    {!! form::checkbox('roles[]', $role->id, null, ['class' => 'form-check-input']) !!}
                                                                    {{ $role->name }}
                                                                </label>
                                                            </th>
                                                        </tr>
                                                        @endforeach
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endrole
                                   {{--  <div class="col-sm-6">
                                        <label for="cargos" class="col-sm-3 col-form-label">Cargos</label>
                                        <div class="form-group">
                                            <div class="tab-pane active">
                                                <br>
                                                <table class="table table-bordered table-md">
                                                    <thead>
                                                        {!! Form::model($usuario, ['route' => ['personales.actualizarDatosBasicos', $usuario], 'method' => 'put']) !!}
                                                        @foreach ($cargos as $cargo)
                                                        <tr>
                                                            <th>
                                                                <label class="form-check-label">
                                                                    {!! form::checkbox('cargosucursals[]', $cargo->id, null, ['class' => 'form-check-input']) !!}
                                                                    {{ $cargo->nombre_cargo }}
                                                                </label>
                                                            </th>
                                                        </tr>
                                                        @endforeach
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>--}}

                                </div> 
                            </div>
                            <br>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                <a href="{{ route('personales.showDetalleContrato', $usuario->id) }}" class="btn btn-danger" tabindex="8">Cancelar</a>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

</section>
@endsection
@section('page_js')
<script>
    const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");
    $seleccionArchivos.addEventListener("change", () => {
        const archivos = $seleccionArchivos.files;
        if (!archivos || !archivos.length) {
            $imagenPrevisualizacion.src = "";
            return;
        }
        const primerArchivo = archivos[0];
        const objectURL = URL.createObjectURL(primerArchivo);
        $imagenPrevisualizacion.src = objectURL;
    });
</script>
@endsection