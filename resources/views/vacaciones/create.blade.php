@extends('layouts.app', ['activePage' => 'vacaciones', 'titlePage' => 'Vacaciones'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Nueva Vacacion</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card card-primary">
                                <br>
                                <div align="center">
                                    <img id="imagenPrevisualizacion" src="{{ url('img/no-image.jpeg') }}" width="150"
                                        height="130" />
                                </div>
                                <br>
                                <form action="{{ route('vacaciones.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="foto">Foto del documento de respaldo<span
                                                        class="required">*</span></label>
                                                <input type="file" id="seleccionArchivos" class="form-control" name="foto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuario_solicitante">Nombre del Funcionario Solicitante<span
                                                        class="required">*</span></label>
                                                <select name="usuario_solicitante" id="" class="form-control">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha Inicio de Vacacion<span
                                                        class="required">*</span></label>
                                                <input type="date"
                                                    class="form-control"
                                                    name="fecha_inicio">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_fin">Fecha Final de Vacacion<span
                                                        class="required">*</span></label>
                                                <input type="date"
                                                    class="form-control"
                                                    name="fecha_fin">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuario_encargado">Nombre del Encargado<span
                                                        class="required">*</span></label>
                                                <select name="usuario_encargado" id="" class="form-control">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado">Estado<span
                                                        class="required">*</span></label>
                                                <select  id="" name="estado" class="form-control" required>                                                    
                                                    <option value="1">ACEPTADO</option>
                                                    <option value="0">SOLICITADO</option>                                                    
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-danger" href="{{ route('vacaciones.index') }}">Volver</a>
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
