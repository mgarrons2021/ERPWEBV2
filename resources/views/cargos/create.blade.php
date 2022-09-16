@extends('layouts.app', ['activePage' => 'cargos', 'titlePage' => 'Cargos'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Cargo</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                            <br>
                            <form action="{{ route('cargos.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre_cargo">Nombre Cargo<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('nombre_cargo') is-invalid @enderror" name="nombre_cargo">
                                            @error('nombre_cargo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion<span class="required">*</span></label>
                                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="descripcion"></textarea>
                                            @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                    <a class="btn btn-danger" href="{{route('cargos.index')}}">Volver</a>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</section>
@endsection