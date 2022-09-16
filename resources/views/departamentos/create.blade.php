@extends('layouts.app', ['activePage' => 'departamentos', 'titlePage' => 'departamentos'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo Departamento</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!-- @if ($errors->any())
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>Revise sus datos</strong>
                            @foreach ($errors->all() as $error)
                            <span class="badge badge-success">{{$error}}</span>
                            @endforeach
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif -->
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('departamentos.store') }}" method="POST" class="form-horizontal">
                                @csrf

                                <div class="row ">
                                   

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre">
                                            @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('descripcion') is-invalid @enderror" name="descripcion">
                                            @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-danger" href="{{route('departamentos.index')}}">Volver</a>
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