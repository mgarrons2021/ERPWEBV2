@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nuevo criterio </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('evaluaciones.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="turno"> Categoria <span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="categoria" id="categoria" class="form-control select">
                                                <option value="comunicacion"> Comunicación (Amabilidad)</option>
                                                <option value="coordinacion"> Coordinación (Orden y limpieza)</option>
                                                <option value="cooperacion"> Cooperacion</option>
                                                <option value="conocimiento"> Conocimiento (Cumpliento)</option>
                                                <option value="compromiso"> Compromiso </option>
                                                <option value="carisma al cliente"> Carisma al cliente </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre del Criterio <span class="required">*</span></label>
                                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name=" nombre" placeholder="Nombre del criterio de evaluación.">
                                        @error('nombre')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="cargo_id">Cargo a evaluar <span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                                <select name="cargo_id" class="form-control selectric">
                                                    @foreach($cargos as $cargo)
                                                    <option value="{{$cargo->id}}">{{$cargo->nombre_cargo}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a class="btn btn-danger" href="{{route('evaluaciones.index')}}">Volver</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
@if(session('evaluaciones')=='registrado')
<script>
    let ruta = "{{ route('evaluaciones.index') }}";
    iziToast.success({
        title: 'SUCCESS',
        message: "Registro agregado exitosamente",
        position: 'topRight',
        timeout: 1000,
        onClosed: function() {
            window.location.href = ruta;
        }

    });
</script>
@endif
@endsection
@section('page_css')
<style>
.required{
    color:red;
}
</style>
@endsection