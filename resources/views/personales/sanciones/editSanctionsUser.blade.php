@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registrar Sancion al funcionario: {{ $user->name }} {{ $user->apellido }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">

                        <a data-toggle="collapse" href="#collapseBonos" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-lg"></i>
                        </a>
                        <h4> &nbsp Historial de Sanciones registrados </h4>
                    </div>
                    <div class="collapse" id="collapseBonos">
                        @php
                        $contador = 0;
                        @endphp

                        <div class="card-body">
                            <div class="row">
                                <br><br>
                                <div class="table-responsive">
                                    <table class="table table-borderless  table-md">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Fecha de asignación</th>
                                                <th scope="col" class="text-center">Funcionario Sancionado</th>
                                                <th scope="col" class="text-center">Funcionario Encargado</th>
                                                <th scope="col" class="text-center"> Sucursal</th>
                                                <th scope="col" class="text-center"> Tipo de Sancion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($user->sanciones[count($user->sanciones)-1]))
                                            @foreach ($user->sanciones as $sancion)
                                            @php
                                            $contador++;
                                            @endphp
                                            @php $fecha_formateada = date('d-m-Y', strtotime($sancion->fecha)); @endphp
                                            <tr>
                                                <td class="text-center bg-light">{{ $contador }}</td>
                                                <td class="text-center">{{$fecha_formateada}}</td>
                                                <td class="text-center">{{ $sancion->user->name}} {{$sancion->user->apellido}} </td>
                                                <td class="text-center">{{ $sancion->detalleSancion->user->name}} {{$sancion->detalleSancion->user->apellido}} </td>
                                                <td class="text-center">{{ $sancion->sucursal->nombre}} </td>
                                                <td class="text-center">{{ $sancion->categoriaSancion->nombre}} </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="6"> Sin registros anteriores</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Nueva Sancion</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('sanciones.store') }}" method="POST" class="form-horizontal " enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <div align="center">
                                        <img id="imagenPrevisualizacion" src="{{url('img/no-image.jpeg')}}" width="150" height="130" />
                                    </div>
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
                                            <h6 class="card-title">Funcionario Sancionado</h6>
                                            <input type="text" class="form-control" value="{{ $user->name }} {{ $user->apellido }}" name="funcionario_sancionado_nombre" readonly>
                                            <input type="hidden" name="funcionario_sancionado" value="{{ $user->id }}">
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="card-title">Funcionario Encargado</h6>
                                            <select class="form-control" aria-label="Default select example" name="funcionario_encargado" id="funcionario_encargado">
                                                @foreach($users as $usuario)
                                                <option value="{{$usuario->id}}">{{$usuario->name}} {{$usuario->apellido}}</option>
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
                                                @foreach($sanciones as $sancio)
                                                <option value="{{$sancio->id}}">{{$sancio->nombre}}</option>
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
                                        <a class="btn btn-danger" href="{{ route('personales.showDetalleContrato', $usuario->id) }}">Volver</a>

                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>
<script>

</script>
@endsection
@section('scripts')
@if(session('sancion')=='registrado')
<script>
    let ruta_personales = "{{ route('personales.showDetalleContrato', $user->id) }}";
    iziToast.success({
        title: 'SUCCESS',
        message: "Registro agregado exitosamente",
        position: 'topRight',
        timeout: 1000,
        onClosed: function() {
            window.location.href = ruta_personales;
        }

    });
</script>
@endif
@section('page_js')
<script>
    $(document).ready(function() {
        $('#funcionario_encargado').select2();
       // $('#funcionario_sancionado').select2();
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
@section('page_css')
<style>
    [data-toggle="collapse"] .fa:before {
        content: "\f13a";
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f139";
    }
</style>
@endsection