@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registrar Bono funcionario: {{ $usuario->name }} {{ $usuario->apellido }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">

                        <a data-toggle="collapse" href="#collapseBonos" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-lg"></i>
                        </a>
                        <h4> &nbsp Bonos registrados anteriormente</h4>
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
                                                <th scope="col" class="text-center">Monto</th>
                                                <th scope="col" class="text-center">Motivo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($usuario->bonos[count($usuario->bonos)-1]))
                                            @foreach ($usuario->bonos as $bono)
                                            @php
                                            $contador++;
                                            @endphp
                                            @php $fecha_formateada = date('d-m-Y', strtotime($bono->fecha)); @endphp
                                            <tr>
                                                <td class="text-center  bg-light">{{ $contador }}</td>
                                                <td class="text-center">{{$fecha_formateada}}</td>
                                                <td class="text-center">{{ $bono->monto}} Bs.</td>
                                                <td class="text-center">{{ $bono->motivo}} </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="4"> Sin registros anteriores</td>
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
                        <h4>Nuevo Bono</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('bonos.store') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha Asignada<span class="required">*</span></label>
                                        <input type="date" class="form-control  @error('fecha') is-invalid @enderror" name="fecha">
                                        @error('fecha')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_id">Usuario<span class="required">*</span></label>
                                        <input type="text" class="form-control " name="user_id" value="{{ $usuario->name }}" disabled>
                                        <input type="hidden" class="form-control " name="user_id" value="{{ $usuario->id }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="monto">Monto<span class="required">*</span></label>
                                        <div class="selectric-hide-select">
                                            <select name="monto" class="form-control select">

                                                <option>300</option>
                                                <option>500</option>
                                                <option>1000</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="motivo">Motivo Bono<span class="required">*</span></label>
                                        <textarea class="form-control" id="motivo" name="motivo"></textarea>
                                    </div>
                                </div>
                              

                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-danger" href="{{ route('personales.showDetalleContrato', $usuario->id) }}">Volver</a>
                            </div>
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
@if(session('bono')=='registrado')
<script>
    let ruta_personales = "{{ route('personales.showDetalleContrato', $usuario->id) }}";
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