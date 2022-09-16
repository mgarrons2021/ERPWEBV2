@extends('layouts.app', ['activePage' => 'contratos', 'titlePage' => 'Contratos'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Contrato</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('contratos.update',$contrato->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipo_contrato">Tipo de Contrato<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('tipo_contrato') is-invalid @enderror" name="tipo_contrato" value="{{$contrato->tipo_contrato}}">
                                            @error('tipo_contrato')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sueldo">Sueldo<span class="required">*</span></label>
                                            <input type="number" class="form-control  @error('sueldo') is-invalid @enderror" name="sueldo" value="{{$contrato->sueldo}}">
                                            @error('sueldo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duracion_contrato">Duracion del Contrato<span class="required">*</span></label>
                                            <input type="text" class="form-control  @error('sueldo') is-invalid @enderror" name="duracion_contrato" value="{{$contrato->duracion_contrato}}">
                                            @error('duracion_contrato')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                    <a href="{{route('categorias.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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
    </div>
    </div>
    </div>

</section>
@endsection