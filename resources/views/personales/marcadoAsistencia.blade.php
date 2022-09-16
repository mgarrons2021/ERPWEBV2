@extends('layouts.app',['activePage' => 'home', 'titlePage' => 'Home'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Marcado Asistencia Donesco</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info">
                    <div class="card-body ">
                        <h4 class="text-left">Registro de Llegada y Salida</h4>
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <form action="{{ route('personales.marcar_asistencia') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="form group ">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Codigo<span class="required">*</span></label>
                                <input type="number" class="form-control  @error('codigo') is-invalid @enderror" name="codigo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Marcar Asistencia</button>
                            <a class="btn btn-danger" href="{{route('productos.index')}}">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

@endsection