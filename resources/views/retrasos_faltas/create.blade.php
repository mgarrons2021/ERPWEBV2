@extends('layouts.app', ['activePage' => 'sanciones', 'titlePage' => 'Sanciones'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Nuevo registro </h3> &nbsp
        <!--  <h4> ({{\Illuminate\Support\Facades\Auth::user()->sucursals[0]->nombre}})
        </h4> -->
    </div>
    <div class="section-body">
        <div class="card ">
            <div class="card-body">
                <form method="POST" action="{{route('retrasosFaltas.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <h6><label for="exampleFormControlInput1" class="form-label">Fecha*</label></h6>
                        <input type="date" class="form-control @error('descripcion') is-invalid @enderror" id="exampleFormControlInput1" name="fecha">
                        @error('fecha')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <h6 class="card-title">Funcionario* </h6>
                        <select class="form-select" aria-label="Default select example" name="funcionario_registrado" id="funcionario_registrado">
                            @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <h6 class="card-title"> Encargado</h6>
                        <input type="text" class="form-control" value="{{\Illuminate\Support\Facades\Auth::user()->name}}" name="funcionario_sancionado_nombre" disabled>
                        <input type="hidden" name="funcionario_encargado" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">
                        <input type="hidden" value="1" name="estado">

                    </div>


                    @role('Super Admin')
                    <div class="mb-3">
                        <h6 class="card-title"> Sucursal</h6>
                        <select class="form-select" aria-label="Default select example" name="sucursal_id">
                            @foreach($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                            @endforeach
                        </select>

                    </div>
                    @endrole

                    @role('Encargado')
                    <input type="hidden" class="form-control" id="sucursal_id" name="sucursal_id" value="{{$sucursales->id}}">
                    @endrole
                    <div class="mb-3">
                        <h6 class="card-title"> Tipo registro* </h6>
                        <select class="form-select" aria-label="Default select example" name="tipo_registro" id="tipo_registro">
                            <option value="n/a"> Seleccione</option>
                            <option value="0"> Retraso</option>
                            <option value="1"> Falta</option>
                        </select>
                    </div>
                    <div class="mb-3" id="hora">
                        <h6 class="card-title"> Hora de ingreso </h6>
                        <input type="time" class="form-control" readonly-autocomplete="off" value="" name="hora" id="hora_time">

                    </div>

                    <div class="mb-3">
                        <label><input type="checkbox" name="justificativo" id="justificativo" /> Cuenta con un justificativo?</label>

                    </div>
                    <div align="center" id="previsualizacion">
                        <img id="imagenPrevisualizacion" src="{{url('img/no-image.jpeg')}}" width="150" height="130" />
                    </div>
                    <div class="mb-3" id="imagen">
                        <h6><label for="exampleFormControlInput1" class="form-label">Respaldo*</label></h6>
                        <input type="file" id="seleccionArchivos" class="form-control @error('descripcion') is-invalid @enderror" name="imagen">
                        @error('imagen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <h6><label for="exampleFormControlInput1" class="form-label">Descripcion*</label></h6>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="exampleFormControlInput2" placeholder="Inserte una descripción" name="descripcion"></textarea>
                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> <br>
                    <input type="submit" class="btn btn-primary" value="Registrar">
                    <a href="{{route('retrasosFaltas.index')}}" class="btn btn-warning btn-xs">Volver</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
@if(session('retraso-sancion')=='registrado')
<script>
    let ruta = "{{ route('retrasosFaltas.index') }}";
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
@section('page_js')
<script>
    $('body').on('focus', ".datepicker", function() {
        $(this).datepicker();
    });
</script>
<script>
    $("#hora").hide();
    $("#previsualizacion").hide();
    $("#imagen").hide();
    $("#justificativo").change(function() {
        if ($("#justificativo").prop("checked") == true) {
            $('#justificativo').val(1);
            $("#previsualizacion").show();
            $("#imagen").show();
        } else {
            $("#previsualizacion").hide();
            $('#justificativo').val(0);
            $("#imagen").hide();
        }
    });
</script>
<script>
    let tipo_registro = document.getElementById("tipo_registro");
    tipo_registro.addEventListener("change", (e) => {
        if (tipo_registro.value == 0) {
            $("#hora").show();

        } else {
            $("#hora").hide();
        }
    });
</script>
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
@section('css')
<style>
    input[type=button] {
        color: white;
        font-family: Lato;
        padding-left: auto;
        padding-right: auto;
        text-align: center;
        font-size: 18px;
        border-style: solid;
        border-width: thin;
        border-color: rgb(193, 218, 214);
        border-radius: 3px;
    }
</style>

@endsection