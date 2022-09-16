@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actualizar Contrato Nro {{$detalleContrato->id}} de {{ $detalleContrato->user->name }} {{ $detalleContrato->user->apellido }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar Contrato</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('personales_contratos.update',$detalleContrato->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_name">Usuario<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="usuario_name" value="{{ $detalleContrato->user->name }} {{ $detalleContrato->user->apellido }}" readonly>
                                        <input type="hidden" class="form-control" name="usuario_id" value="{{ $detalleContrato->user->id }}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo_contrato">Tipo de Contrato</label>
                                        <select name="tipo_contrato" id="tipo_contrato" class="form-select">
                                            @foreach($contratos as $contrato)
                                            <option value="{{$contrato->id}}">{{$contrato->tipo_contrato}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_inicio_contrato">Fecha Inicio Contrato<span class="required">*</span></label>
                                        <input type="date" class="form-control  @error('fecha_inicio_contrato') is-invalid @enderror" name="fecha_inicio_contrato" id="fecha_inicio_contrato" value="{{ $detalleContrato->fecha_inicio_contrato}}" >
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
                                        <input type="date" class="form-control  @error('fecha_fin_contrato') is-invalid @enderror" name="fecha_fin_contrato" id="fecha_fin_contrato" value="{{ $detalleContrato->fecha_fin_contrato}}" readonly>
                                        @error('fecha_fin_contrato')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                <a class="btn btn-danger" href="{{ route('personales.showDetalleContrato', $detalleContrato->user->id) }}">Volver</a>
                            </div>
                        </form>
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