@extends('layouts.app', ['activePage' => 'postulantes', 'titlePage' => 'Postulantes'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Personal : {{ $postulante->name }} {{ $postulante->apellido }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <form action="{{ route('postulantes.actualizarDatosBasicos', $postulante->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{ $postulante->name }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido">Apellido<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="apellido" value="{{ $postulante->apellido }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Observacion<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="observacion" value="{{ $postulante->observacion }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nro_celular_personal">Celular Personal<span class="required">*</span></label>
                                    <input type="number" class="form-control" name="nro_celular_personal" value="{{ $postulante->celular_personal }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="estado" class="form-control selectric">
                                            @if ($postulante->estado === 1)
                                            <option value="1" selected>No Entrevistado</option>
                                            <option value="0">Entrevistado</option>
                                            @endif
                                            @if ($postulante->estado === 0)
                                            <option value="1">No Entrevistado</option>
                                            <option value="0" selected>Entrevistado</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                        <a href="{{ route('postulantes.index', $postulante->id) }}" class="btn btn-danger" tabindex="8">Cancelar</a>
                    </div>
                    <br>
            </form>
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
@section('scripts')
@if (session('actualizado') == 'ok')

<script>
    iziToast.success({
        title: 'Success!',
        message: "Los datos basicos se han actualizado exitosamente",
        position: 'topRight',
    });
</script>
@endif

@section('page_js')
<script>
    const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");
    $seleccionArchivos.addEventListener("change", () => {
        const archivos = $seleccionArchivos.files;
        if (!archivos || !archivos.length) {
            $imagenPrevisualizacion.src = "";
            return;
        }
        const primerArchivo = archivos[0];
        const objectURL = URL.createObjectURL(primerArchivo);
        $imagenPrevisualizacion.src = objectURL;
    });
</script>
@endsection
@endsection