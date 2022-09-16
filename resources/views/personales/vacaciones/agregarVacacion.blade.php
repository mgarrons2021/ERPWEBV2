@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Nueva Vacacion</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#collapseBonos" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-lg"></i>
                        </a>
                        <h4> &nbsp  Vacaciones registradas anteriormente</h4>
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
                                                <th scope="col" class="text-center">Funcionario Encargado</th>
                                                <th scope="col" class="text-center">Fecha de Inicio</th>
                                                <th scope="col" class="text-center">Fecha de Finalizacion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if(isset($user->vacaciones[count($user->vacaciones)-1]))
                                            @foreach ($user->vacaciones as $vacacion)
                                            @php
                                            $contador++;
                                            @endphp
                                            <tr>
                                                <td class="text-center bg-light">{{ $contador }}</td>
                                                <td class="text-center">{{ $vacacion->detalleVacacion->user->name}}</td>
                                                <td class="text-center">{{ $vacacion->fecha_inicio}}</td>
                                                <td class="text-center">{{ $vacacion->fecha_fin}} </td>
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
                    <div class="card-body">
                        <form action="{{ route('personales_vacaciones.guardarVacacion',$user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_solicitante">Nombre del Funcionario Solicitante<span class="required">*</span></label>
                                        <input type="text" class="form-control" value="{{ $user->name }} {{$user->apellido}}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="usuario_encargado">Nombre del Encargado<span class="required">*</span></label>
                                        <select name="usuario_encargado" id="" class="form-control">
                                            @foreach ($users as $user2)
                                            <option value="{{ $user2->id }}">{{ $user2->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="foto">Foto del documento de respaldo<span class="required">*</span></label>
                                        <input type="file" id="seleccionArchivos" class="form-control" name="foto">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_inicio">Fecha Inicio de Vacacion<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="fecha_inicio">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_fin">Fecha Final de Vacacion<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="fecha_fin">

                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a class="btn btn-danger" href="{{ route('personales.showDetalleContrato', $user->id) }}">Volver</a>
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