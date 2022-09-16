@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar un registro </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('evaluaciones.actualizar' , $evaluaciones->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="turno"> Categoria <span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="categoria" id="categoria" class="form-control select">
                                                <option value="comunicacion" {{($evaluaciones->categoria ==='comunicacion') ? 'selected' : ''}} > Comunicación (Amabilidad)</option>
                                                <option value="coordinacion" {{($evaluaciones->categoria ==='coordinacion') ? 'selected' : ''}} > Coordinación (Orden y limpieza)</option>
                                                <option value="cooperacion"  {{($evaluaciones->categoria ==='cooperacion') ? 'selected' : ''}}> Cooperacion</option>
                                                <option value="conocimiento" {{($evaluaciones->categoria ==='conocimiento') ? 'selected' : ''}}> Conocimiento (Cumpliento)</option>
                                                <option value="compromiso" {{($evaluaciones->categoria ==='compromiso') ? 'selected' : ''}}> Compromiso </option>
                                                <option value="carisma al cliente" {{($evaluaciones->cargo_id ==='carisma al cliente') ? 'selected' : ''}}> Carisma al cliente </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nombre">Nombre del Criterio <span class="required">*</span></label>
                                        <input type="text" class="form-control"   name=" nombre"  value="{{$evaluaciones->nombre}}">
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
                                                @if($evaluaciones->cargo_id ==$cargo->id)
                                                <option value="{{$cargo->id}}" selected>{{$cargo->nombre_cargo}}</option>
                                                @else
                                                <option value="{{$cargo->id}}">{{$cargo->nombre_cargo}}</option>
                                                @endif
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
@if(session('editar')=='success')
<script>
    let ruta = "{{ route('evaluaciones.index') }}";
     iziToast.show({
        color: 'dark',
        icon: 'fa fa-check',
        title: 'SUCCESS',
        message: "Registro actualizado exitosamente",
        position: 'topRight',
        timeout: 1000,
        progressBarColor: 'rgb(0, 255, 184)',
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