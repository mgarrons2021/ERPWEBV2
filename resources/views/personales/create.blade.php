@extends('layouts.app',['activePage' => 'contrato_personales', 'titlePage' => 'Contrato de Personales'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Contrato de Personal</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <!-- MultiStep Form -->
                            <div id="grad1">
                                <div class="row justify-content-center mt-0">
                                    <div class="col-lg-11 text-center p-0 mt-3 mb-2">
                                        <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                            <div class="row">
                                                <div class="col-md-12 mx-0">
                                                    <form action="{{ route('personales.contratar') }}" id="msform" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <!-- progressbar -->
                                                        <ul id="progressbar">
                                                            <li class="active" id="account">
                                                                <strong>Datos Personales</strong>
                                                            </li>
                                                            <li id="personal"><strong>Experiencia Laboral</strong>
                                                            </li>
                                                            <li id="payment"><strong>Educacion</strong>
                                                            </li>
                                                            <li id="payment"><strong>Competencia y Habilidades</strong>
                                                            </li>
                                                            <li id="confirm"><strong>Datos en Donesco</strong>
                                                            </li>
                                                        </ul> <!-- fieldsets -->
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h2 class="fs-title pb-3">Datos Personales</h2>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="nombre">NOMBRES</label>
                                                                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" id="nombre" name="nombre" placeholder="Nombres..." value="{{ old('nombre') }}">
                                                                        @error('nombre')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="apellidos">APELLIDOS</label>
                                                                        <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" placeholder="Apellidos..." value="{{ old('apellido') }}">
                                                                        @error('apellido')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="fecha_nacimiento">FECHA
                                                                            NACIMIENTO</label>
                                                                        <input type="date" class="form-control  @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de Nacimiento..." value="{{ old('fecha_nacimiento') }}">
                                                                        @error('fecha_nacimiento')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="carnet_identidad">CARNET DE
                                                                            IDENTIDAD</label>
                                                                        <input type="text" class="form-control @error('carnet_identidad') is-invalid @enderror" id="carnet_identidad" name="carnet_identidad" placeholder="Carnet de Identidad..." value="{{ old('carnet_identidad') }}">
                                                                        @error('carnet_identidad')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>

                                                                    <div class="form-group col-md-6 ">
                                                                        <label for="domicilio">DOMICILIO</label>
                                                                        <input type="text" class="form-control @error('domicilio') is-invalid @enderror" id="domicilio" name="domicilio" placeholder="Domicilio..." value="{{ old('carnet_identidad') }}">
                                                                        @error('domicilio')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="zona">ZONA</label>
                                                                        <input type="text" class="form-control @error('zona') is-invalid @enderror" id="zona" name="zona" placeholder="Zona..." value="{{ old('zona') }}">
                                                                        @error('zona')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="nro_celular_personal">NRO DE CELULAR
                                                                            PERSONAL</label>
                                                                        <input type="number" class="form-control @error('nro_celular_personal') is-invalid @enderror" id="nro_celular_personal" name="nro_celular_personal" placeholder="Nro de Celular Personal..." value="{{ old('nro_celular_personal') }}">
                                                                        @error('nro_celular_personal')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="nro_celular_referencia">NRO CELULAR
                                                                            DE REFERENCIA</label>
                                                                        <input type="number" class="form-control" id="nro_celular_referencia" name="nro_celular_referencia" placeholder="Nro de Celular de Refencia..." value="{{ old('nro_celular_referencia') }}">
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="email">CORREO
                                                                            ELECTRONICO</label>
                                                                        <input type="text" class="form-control " id="email" name="email" placeholder="Correo Electronico..." value="{{ $correo }}">

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="foto">FOTO</label>
                                                                        <input type="file" class="form-control" id="foto" name="foto">
                                                                    </div>
                                                                </div>
                                                            </div> <button type="button" name="next" class="btn btn-primary next">Siguiente</button>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h2 class="fs-title pb-3"> Datos De Experiencia Laboral
                                                                </h2>
                                                                <div class="form-row clonar_experiencia">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="nombre_empresa">NOMBRE DE LA
                                                                            EMPRESA</label>
                                                                        <input type="text" class="form-control @error('nombre_empresas[]') is-invalid @enderror" id="nombre_empresas" name="nombre_empresas[]" placeholder="Nombre de la empresa..." value="{{ old('nombre_empresas[]') }}">
                                                                        @error('nombre_empresas[]')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="cargo">CARGO EN LA
                                                                            EMPRESA</label>
                                                                        <input type="text" class="form-control @error('cargos[]') is-invalid @enderror" name="cargos[]" id="cargos" placeholder="Cargo..." value="{{ old('cargos[]') }}">
                                                                        @error('cargos[]')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="descripcion">DESCRIPCION DEL
                                                                            TRABAJO</label>
                                                                        <textarea cols="30" rows="10" type="text" class="form-control @error('descripciones[]') is-invalid @enderror" name="descripciones[]" id="descripciones" placeholder="descripcion del trabajo..." value="{{ old('descripciones[]') }}"></textarea>
                                                                        @error('descripciones[]')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                        <br>
                                                                        <span class="badge badge-pill badge-danger puntero_experiencia ocultar_experiencia">Eliminar</span>
                                                                    </div>

                                                                </div>
                                                                <div id="contenedor_experiencia">

                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-md-12 text-center">
                                                                        <button class="btn btn-info" type="button" id="agregar_experiencia">Agregar Experiencia
                                                                            +</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" name="previous" class="btn btn-primary previous">Anterior</button>
                                                            <button type="button" name="next" class="btn btn-primary next">Siguiente</button>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h2 class="fs-title pb-3">Educacion</h2>
                                                                <div class="form-row clonar_educacion">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="institucion">NOMBRE DE LA INSTITUCION</label>
                                                                        <input type="text" class="form-control @error('instituciones.' . '0') is-invalid @enderror" id="institucion" name="instituciones[]" placeholder="Institucion..." value="{{ old('instituciones.' . '0') }}">
                                                                        @error('instituciones.' . '0')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="carrera">NOMBRE DE LA CARRERA, CURSO O SEMINARIO</label>
                                                                        <input type="text" class="form-control @error('carreras.' . '0') is-invalid @enderror" id="carrera" name="carreras[]" placeholder="Nombre..." value="{{ old('carreras.' . '0') }}">
                                                                        @error('carreras.' . '0')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror

                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="fecha_inicio_educacion">FECHA
                                                                            INICIO</label>
                                                                        <input type="date" class="form-control  @error('fecha_inicio_educacion'.'0') is-invalid @enderror" id="fecha_inicio_educacion" name="fecha_inicio_educacion[]" placeholder="Fecha Inicio..." value="{{ old('fecha_inicio_educacion'.'0') }}">
                                                                        @error('fecha_inicio_educacion'.'0')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                        <br>
                                                                        <span class="badge badge-pill badge-danger puntero_educacion ocultar_educacion">Eliminar</span>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="fecha_fin_educacion">FECHA
                                                                            FIN</label>
                                                                        <input type="date" class="form-control  @error('fecha_fin_educacion'.'0') is-invalid @enderror" id="fecha_fin_educacion" name="fecha_fin_educacion[]" placeholder="Fecha Fin..." value="{{ old('fecha_fin_educacion'.'0') }}">
                                                                        @error('fecha_fin_educacion'.'0')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror

                                                                    </div>
                                                                </div>
                                                                <div id="contenedor_educacion">

                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-md-12 text-center">
                                                                        <button class="btn btn-info" type="button" id="agregar_educacion">Agregar educacion
                                                                            +</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" name="previous" class="btn btn-primary previous">Anterior</button>
                                                            <button type="button" name="next" class="btn btn-primary next">Siguiente</button>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h2 class="fs-title pb-3">Habilidades Tecnicas</h2>
                                                                <div class="form-row clonar_habilidad">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="habilidad">HABILIDAD</label>
                                                                        <input type="text" class="form-control @error('habilidades.' . '0') is-invalid @enderror" id="habilidad" name="habilidades[]" placeholder="Habilidad..." value="{{ old('habilidades.' . '0') }}">
                                                                        @error('habilidades.' . '0')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                        <br>
                                                                        <span class="badge badge-pill badge-danger puntero_habilidad ocultar_habilidad">Eliminar</span>
                                                                    </div>
                                                                </div>
                                                                <div id="contenedor_habilidad">

                                                                </div>
                                                                <div class="form-row">
                                                                    <div class="col-md-12 text-center">
                                                                        <button class="btn btn-info" type="button" id="agregar_habilidad">Agregar Habilidad
                                                                            +</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" name="previous" class="btn btn-primary previous">Anterior</button>
                                                            <button type="button" name="next" class="btn btn-primary next">Siguiente</button>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h2 class="fs-title pb-3">Datos en la Empresa
                                                                </h2>
                                                                <div class="form-row">
                                                                    <div class="form-group col-md-6">
                                                                        <label for="fecha_inicio">FECHA INICIAL DEL
                                                                            CONTRATO</label>
                                                                        <input type="date" class="form-control @error('fecha_inicio_contrato') is-invalid @enderror" id="fecha_inicio_contrato" name="fecha_inicio_contrato" value="{{ old('fecha_inicio_contrato') }}">
                                                                        @error('fecha_inicio_contrato')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="fecha_fin_contrato">FECHA FINAL DEL
                                                                            CONTRATO</label>
                                                                        <input type="date" class="form-control @error('fecha_fin_contrato') is-invalid @enderror" id="fecha_fin_contrato" name="fecha_fin_contrato" value="{{ old('fecha_fin_contrato') }}" readonly>
                                                                        @error('fecha_fin_contrato')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="tipo_contrato">TIPO DE
                                                                            CONTRATO</label>
                                                                        <select name="contrato_id" id="tipo_contrato" class="form-control">
                                                                            <option value="sinvalue">Seleccione el Tipo de Contrato</option>
                                                                            @foreach ($contratos as $contrato)
                                                                            <option value="{{ $contrato->id }}">
                                                                                {{ $contrato->tipo_contrato }}
                                                                            </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="disponibilidad">DISPONIBILIDAD</label>
                                                                        <select name="disponibilidad" id="" class="form-control">
                                                                            <option value="am">Am</option>
                                                                            <option value="pm">Pm</option>
                                                                            <option value="ambos">Ambos</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group col-md-6">
                                                                        <label for="sucursal">CODIGO DE USUARIO</label>
                                                                        <div class="input-group mb-6">
                                                                            <input type="text" class="form-control" placeholder="" id="codigo" name="codigo" value="{{ $user_cod }}" readonly>
                                                                            <button class="btn btn-primary " id="actualizar_codigo" type="button">Actualizar
                                                                                Codigo</button>
                                                                        </div>
                                                                        @error('codigo')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <button type="button" name="previous" class="btn btn-primary previous">Anterior</button>
                                                            <button type="submit" name="make_payment " class="btn btn-primary " id="submit">Guardar</button>
                                                        </fieldset>
                                                    </form>
                                                </div>
                                            </div><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/personales/create.js') }}"> </script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/personales/create.css') }}" rel="stylesheet" type="text/css" />
@endsection