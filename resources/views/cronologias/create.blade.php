@extends('layouts.app', ['activePage' => 'cronologias', 'titlePage' => 'Cronologias'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Cronologia</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('cronologias.store') }}" method="POST" class="form-horizontal">
                                @csrf
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario">Personal Encargado <span
                                                    class="required">*</span></label>
                                            <select name="usuario" id="" class="form-control">
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario">Funcionario Observado <span
                                                    class="required">*</span></label>
                                                    <select name="usuario_cr" id="" class="form-control">
                                                @foreach ($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_cronologia">Fecha de Cronologia<span class="required">*</span></label>
                                            <input type="date" class="form-control  @error('fecha_cronologia') is-invalid @enderror" name="fecha_cronologia" >
                                            @error('fecha_cronologia')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descripcion">Descripcion<span class="required">*</span></label>
                                            <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="form-control  @error('descripcion') is-invalid @enderror" placeholder="Descripcion..."></textarea>
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
                                    <a class="btn btn-danger" href="{{route('cronologias.index')}}">Volver</a>
                                </div>
                                <br>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection