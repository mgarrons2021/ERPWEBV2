@extends('layouts.app',['activePage' => 'registro_postulante', 'titlePage' => 'Reclutamiento de Personal'])

@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Registro Reclutamiento</h3>
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
                                                    <form action="{{ route('postulantes.contratar') }}" id="msform" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <!-- progressbar -->
                                                        <!-- fieldsets -->
                                                        <fieldset>
                                                            <div class="form-card">
                                                                <h2 class="fs-title pb-3">Datos Personales</h2>
                                                                < class="form-row">
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
                                                                        <label for="observacion">OBSERVACION</label>
                                                                        <input type="text" class="form-control @error('zona') is-invalid @enderror" id="observacion" name="observacion" placeholder="Zona..." value="{{ old('observacion') }}">
                                                                        @error('observacion')
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
<script type="text/javascript" src="{{ URL::asset('assets/js/postulantes/create.js') }}"> </script>
@endsection
@section('page_css')
<link href="{{ asset('assets/css/postulantes/create.css') }}" rel="stylesheet" type="text/css" />
@endsection