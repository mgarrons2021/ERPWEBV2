@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Contrato de {{ $usuario->name }} {{ $usuario->apellido }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#collapseBonos" role=b"button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-lg"></i>
                        </a>
                        <h4> &nbsp Historial de Contratos anteriores</h4>
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
                                                <th scope="col" class="text-center">Fecha Inicio de Contrato</th>
                                                <th scope="col" class="text-center">Fecha Fin de Contrato</th>
                                                <th scope="col" class="text-center">Disponibilidad</th>
                                                <th scope="col" class="text-center">Tipo de Contrato</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(isset($usuario->detalleContratos[count($usuario->detalleContratos)-1]))
                                            @foreach ($usuario->detalleContratos as $contrato)
                                            @php
                                            $contador++;
                                            @endphp
                                            <tr>
                                                <td class="text-center bg-light">{{ $contador }}</td>
                                                <td class="text-center">{{ $contrato->fecha_inicio_contrato}}</td>
                                                <td class="text-center">{{ $contrato->fecha_fin_contrato}}</td>
                                                <td class="text-center">{{ $contrato->disponibilidad}}</td>
                                                <td class="text-center">{{ $contrato->contrato->tipo_contrato}} </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="5"> Sin registros anteriores</td>
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
                        <h4>Nuevo Contrato</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('personales.actualizarContratoUser') }}" method="POST" class="form-horizontal">
                            @csrf
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_id">Usuario<span class="required">*</span></label>
                                        <input type="text" class="form-control " name="usuario_nombre" value="{{ $usuario->name }}" disabled>
                                        <input type="hidden" class="form-control " name="usuario_id" value="{{ $usuario->id }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_inicio_contrato">Fecha Inicio Contrato<span class="required">*</span></label>
                                        <input type="date" class="form-control  @error('fecha_inicio_contrato') is-invalid @enderror" name="fecha_inicio_contrato" id="fecha_inicio_contrato">
                                        @error('fecha_inicio_contrato')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_fin_contrato">Fecha Fin Contrato<span class="required">*</span></label>
                                        <input type="date" class="form-control  @error('fecha_fin_contrato') is-invalid @enderror" name="fecha_fin_contrato" id="fecha_fin_contrato" readonly>
                                        @error('fecha_fin_contrato')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contrato_id">Seleccione el Tipo de Contrato<span class="required">*</span></label>

                                        <div class="selectric-hide-select">
                                            <select name="contrato_id" id="tipo_contrato" class="form-control select">
                                                <option> Seleccione.</option>
                                                @foreach ($contratos as $contrato)
                                                <option value="{{ $contrato->id }}">
                                                    {{ $contrato->tipo_contrato }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="disponibilidad">Disponibilidad<span class="required">*</span></label>
                                        <select name="disponibilidad" id="disponibilidad" class="form-control">
                                            <option value="am">Am</option>
                                            <option value="pm">Pm</option>
                                            <option value="ambos">Ambos</option>
                                        </select>
                                        @error('disponibilidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
    //
    const formatearFecha = fecha => {
        const mes = fecha.getMonth() + 1; // Ya que los meses los cuenta desde el 0
        const dia = fecha.getDate();
        return `${fecha.getFullYear()}-${(mes < 10 ? '0' : '').concat(mes)}-${(dia < 10 ? '0' : '').concat(dia)}`;
    };

    let tipo_contrato = document.getElementById('tipo_contrato');
    let fecha_fin_contrato = document.getElementById('fecha_fin_contrato');
    let fecha_inicio_contrato = document.getElementById('fecha_inicio_contrato');
    tipo_contrato.addEventListener('change', e => {

        let fecha_inicio_parseada = new Date(fecha_inicio_contrato.value);
        if (tipo_contrato.value == 1) {
            let nueva_fecha_fin = new Date(fecha_inicio_parseada.setMonth(fecha_inicio_parseada.getMonth() +
                3));
            fecha_final_formateada = formatearFecha(nueva_fecha_fin);
            fecha_fin_contrato.value = fecha_final_formateada;
        }

        if (tipo_contrato.value == 2) {
            let nueva_fecha_fin = new Date(fecha_inicio_parseada.setFullYear(fecha_inicio_parseada
                .getFullYear() +
                1));
            fecha_final_formateada = formatearFecha(nueva_fecha_fin);
            fecha_fin_contrato.value = fecha_final_formateada;
        }

        if (tipo_contrato.value == 3) {
            let nueva_fecha_fin = new Date(fecha_inicio_parseada.setFullYear(fecha_inicio_parseada
                .getFullYear() +
                5));
            fecha_final_formateada = formatearFecha(nueva_fecha_fin);
            fecha_fin_contrato.value = fecha_final_formateada;
        }
        if (tipo_contrato.value == 4) {
            let nueva_fecha_fin = new Date(fecha_inicio_parseada.setMonth(fecha_inicio_parseada
                .getMonth() +
                3));
            fecha_final_formateada = formatearFecha(nueva_fecha_fin);
            fecha_fin_contrato.value = fecha_final_formateada;
        }

    });
</script>
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