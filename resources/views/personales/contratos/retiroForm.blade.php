@extends('layouts.app', ['activePage' => 'vacaciones', 'titlePage' => 'Vacaciones'])

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Retiro del Personal {{$user->name}}</h3>
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
                                <form action="{{ route('personales.retiroFormSave') }}" method="POST" class="form-horizontal"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="foto">Foto del documento de respaldo<span
                                                        class="required">*</span></label>
                                                <input type="file" id="seleccionArchivos" class="form-control"
                                                    name="foto">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuario_a_retirar">Nombre del Funcionario a Retirar<span
                                                        class="required">*</span></label>
                                                <input name="usuario_a_retirar" type="text" class="form-control" value="{{$user->name}}" readonly>
                                                <input name="usuario_a_retirar_id" type="hidden" value="{{$user->id}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_inicio">Fecha Final de trabajo<span
                                                        class="required">*</span></label>
                                                <input type="date" class="form-control" name="fecha_inicio">

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="motivo">Motivo<span class="required">*</span></label>
                                                <select name="motivo" id="motivo" class="form-control">
                                                    <option value="Retiro Voluntario">Retiro Voluntario</option>
                                                    <option value="Despido">Despido</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="usuario_encargado">Descripcion del retiro<span
                                                        class="required">*</span></label>
                                                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="10"
                                                    placeholder="Descripcion del retiro..."></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-danger" href="{{ route('personales.showDetalleContrato',$user->id) }}">Volver</a>
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
