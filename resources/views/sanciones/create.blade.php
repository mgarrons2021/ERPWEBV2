@extends('layouts.app', ['activePage' => 'sanciones', 'titlePage' => 'Sanciones'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Agregar una Sancion</h3>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div align="center">
                    <img id="imagenPrevisualizacion" src="{{url('img/no-image.jpeg')}}" width="150" height="130" />
                </div>
                <form method="POST" action="{{route('sanciones.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <h6><label for="exampleFormControlInput1" class="form-label">Imagen</label></h6>
                        <input type="file" id="seleccionArchivos" class="form-control @error('descripcion') is-invalid @enderror" name="imagen">
                        @error('imagen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <h6><label for="exampleFormControlInput1" class="form-label">Fecha</label></h6>
                        <input type="date" class="form-control @error('descripcion') is-invalid @enderror" id="exampleFormControlInput1" name="fecha">
                        @error('fecha')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <h6 class="card-title">Funcionario Encargado</h6>
                        <select class="form-select" aria-label="Default select example" name="funcionario_encargado" id="funcionario_encargado">
                            @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <h6 class="card-title">Funcionario Sancionado</h6>
                        <select class="form-select" aria-label="Default select example" name="funcionario_sancionado" id="funcionario_sancionado">
                            @foreach($usuarios as $usuario)
                            <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <h6 class="card-title">Sucursal</h6>
                        <select class="form-select" aria-label="Default select example" name="sucursal_id">
                            @foreach($sucursales as $sucursal)
                            <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <h6 class="card-title">Tipo de sancion</h6>
                        <select class="form-select" aria-label="Default select example" name="categoria_sancion_id">
                            @foreach($sanciones as $sancion)
                            <option value="{{$sancion->id}}">{{$sancion->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <h6><label for="exampleFormControlInput1" class="form-label">Descripcion</label></h6>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="exampleFormControlInput1" placeholder="Inserte una descripción de la sancion" name="descripcion"></textarea>
                        @error('descripcion')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div> <br>
                    <input type="submit" class="btn btn-primary" value="Registrar">
                    <a href="{{route('personales.index')}}" class="btn btn-warning btn-xs">Volver</a>
                    <a href="{{route('sanciones.index')}}" class="btn btn-warning btn-xs">Ir a Sanciones</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
@if(session('sancion')=='registrado')
<script>
    let ruta = "{{ route('sanciones.index') }}";
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
    $(document).ready(function() {
        $('#funcionario_encargado').select2();
        $('#funcionario_sancionado').select2();
    });

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
<script>
    let agregar_habilidad = document.getElementById('agregar_habilidad');
    let contenido_habilidad = document.getElementById('detalle_sancion');

    agregar_habilidad.addEventListener('click', e => {
        e.preventDefault();
        let clonado_habilidad = document.querySelector('.clonar_habilidad');
        let clon_habilidad = clonado_habilidad.cloneNode(true);

        contenido_habilidad.appendChild(clon_habilidad).classList.remove('clonar_habilidad');

        let remover_ocutar = contenido_habilidad.lastChild.childNodes[1].querySelectorAll('span');
        remover_ocutar[0].classList.remove('ocultar_habilidad');
    });
</script>
@endsection