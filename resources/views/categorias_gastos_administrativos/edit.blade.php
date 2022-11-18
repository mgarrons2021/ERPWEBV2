@extends('layouts.app', ['activePage' => 'categorias_caja_chica', 'titlePage' => 'Categorias_Caja_Chica'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Categoria de Gastos</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('categorias_gastos_administrativos.update',$categorias_gastos_administrativos->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="nombre" value="{{$categorias_gastos_administrativos->nombre}}">
                                            @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                    <a href="{{route('categorias_gastos_administrativos.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                                </div>
                                <br>
                            </form>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
</section>
@endsection