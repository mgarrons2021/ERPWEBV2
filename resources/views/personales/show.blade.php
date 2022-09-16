@extends('layouts.app', ['activePage' => 'contrato_personales', 'titlePage' => 'Contrato de Personales'])
@section('css')
@endsection
@section('content')
@include('personales.modal')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Datos del empleado: {{ $user->name }}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-user ">
                    <div class="card-body">
                        <div class="row">
                            <div class="author col-md-4 datos-basicos">
                                <div align="center">
                                    <h4 style="font-size: 20px;color: #6777ef ; ">Datos Basicos</h4>
                                    @if ($user->foto === null || $user->foto === '')
                                    <img src="{{ url('img/no-user.png') }}" alt="image" class="rounded-circle avatar2" />
                                    <br>
                                    @endif
                                    @if ($user->foto != null)
                                    <img src="{{ url($user->foto) }}" alt="image" class="rounded-circle avatar2 ">
                                    <br>
                                    @endif
                                    <div class="row user">
                                        <h5 class="title mt-3">{{ $user->name }} {{ $user->apellido}}
                                            <a href="{{route('personales.editDatosBasicos', $user->id )}}"><i class="fas fa-edit edit"></i></a>
                                        </h5>

                                    </div>
                                </div>
                                {{-- </a> --}}
                                <p class="description">
                                    {{-- Correo Electronico : {{ $user->email }} <br> --}}
                                    Carnet de Identidad : {{ $user->ci }} <br>
                                    Direccion : {{ $user->domicilio }} <br>
                                    Zona : {{ $user->zona }} <br>
                                    Celular Personal : {{ $user->celular_personal }} <br>
                                    Fecha de Nacimiento :
                                    @php $fecha_formateada_nacimiento = date('d-m-Y', strtotime($user->fecha_nacimiento)); @endphp
                                    {{$fecha_formateada_nacimiento}} <br>
                                    Celular de Referencial : {{ $user->celular_referencia }} <br><br>
                                    

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                        Agregar Garante</button>
                                    <a href="{{route('personales.index')}}" class="btn btn-warning">Volver</a>

                                </p>
                            </div>
                            <div class="col-md-8 datos-empresa">
                                <table class="table table-bordered">
                                    <tbody>
                                        <h4 style="font-size:21px;color: #6777ef ;" align= "center">Datos en la Empresa</h4>
                                        <tr>
                                            <th>Codigo</th>
                                            <td>{{ $user->codigo }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sucursal</th>

                                            @if (isset($user->sucursals[0]))
                                            <td>
                                                @foreach ( $user->sucursals as $sucursal)
                                                {{$sucursal->nombre}}
                                                @endforeach
                                            </td>
                                            @else
                                            <td class="alerta"> Sin sucursal </td>
                                            @endif

                                        <tr>
                                        <tr>
                                            @if(isset($user->detalleContratos[0]))
                                            <th>Disponibilidad</th>
                                            <td>Turno: {{ $user->detalleContratos[0]->disponibilidad }}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Cargo</th>

                                            @if (isset($user->cargosucursals[0]))
                                            <td>
                                                @foreach ( $user->cargosucursals as $cargosucursal)
                                                {{$cargosucursal->nombre_cargo}}
                                                @endforeach
                                            </td>
                                            @else
                                            <td class="alerta"> Sin cargo </td>
                                            @endif

                                        <tr>
                                            <th>Estado</th>
                                            @if ($user->estado == 1)
                                            <td>
                                                <div class="badge badge-success">Activo</div>
                                            </td>
                                            @endif
                                            @if ($user->estado == 0)
                                            <td>
                                                <div class="badge badge-danger">Inactivo</div>
                                            </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Garante :</th>
                                            @if (isset($user->garante))
                                            <td> <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalGarante">&nbsp {{ $user->garante->nombre }} {{ $user->garante->apellido }}</a> </td>
                                            @else
                                            <td class="alerta"> Sin garante </td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <th>Experiencia Laboral:</th>
                                            @php $entro=false; @endphp
                                            @if(isset($user->experiencias_laborales[0]))
                                            <td>
                                                @foreach ($user->experiencias_laborales as $laboral_experience)
                                                @if($laboral_experience->cargo === 'Cocinero' || $laboral_experience->cargo === 'Cheff' || $laboral_experience->cargo === 'Parrillero' )
                                                - {{$laboral_experience->cargo}}

                                                @php $entro=true; @endphp
                                                @endif
                                                @endforeach
                                                @if($entro===false)
                                                Sin Experiencia Laboral Relacionada
                                                @endif
                                            </td>

                                            @else
                                            <td class="">Sin Experiencia Laboral Relacionada</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <th>Estudios</th>
                                            @if (isset($user->educaciones[0]))
                                            <td>
                                                @foreach ($user->educaciones as $educacion)
                                                - {{$educacion->nombre_carrera}}
                                                @endforeach
                                            </td>
                                            @else
                                            <td class="">Sin Educacion </td>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="justify-content: center;">
                        <h4 style="font-size:21px;color: #6777ef; "> Cronologia de {{$user->name}}</h4>
                        <a href="{{ route('personales.cronologiaPersonales',$user->id) }}">Ver Cronologia por Fechas 
                            {{$user->name}}</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Contrato Vigente</th>
                                    @if(isset($user->detalleContratos[count($user->detalleContratos)-1]))
                                    @php
                                    $ultimo_contrato = $user->detalleContratos[count($user->detalleContratos)-1];
                                    $fecha_formateada_inicio = date('d-m-Y', strtotime($ultimo_contrato->fecha_inicio_contrato));
                                    $fecha_formateada_fin = date('d-m-Y', strtotime($ultimo_contrato->fecha_fin_contrato));
                                    @endphp
                                    <td>
                                        Tipo contrato : {{$ultimo_contrato->contrato->tipo_contrato}} , &nbsp Fecha Contrato: {{$fecha_formateada_inicio}} a {{$fecha_formateada_fin}} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_contratos"> Ver Más</a>
                                    </td>
                                    @else
                                    <td class="alerta" style="color:#FC544B;">
                                        Sin Contrato &nbsp &nbsp
                                    </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales.editContratoUser', $user->id)}}" class="btn btn-primary"><i class="fa fa-solid fa-folder-plus fa-lg"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bonos</th>
                                    @if(isset($user->bonos[count($user->bonos)-1]))
                                    @php
                                    $ultimo_bono = $user->bonos[count($user->bonos)-1];
                                    @endphp
                                    <td> Bono: {{ $ultimo_bono->monto }} Bs. &nbsp
                                        Motivo: {{ $ultimo_bono->motivo}} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_bonos"> Ver Más</a>
                                    </td>
                                    @else
                                    <td> No cuenta con bonos </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales.editBonoUser', $user->id)}}" class="btn btn-primary"></i> <i class="fa fa-solid fa-bold fa-lg"></i> </a>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Sanciones</th>
                                    @if(isset($user->sanciones[count($user->sanciones)-1]))
                                    @php
                                    $ultima_sancion = $user->sanciones[count($user->sanciones)-1];
                                    $fecha_formateada = date('d-m-Y', strtotime($ultima_sancion->fecha));
                                    @endphp
                                    <td> Fecha: {{$fecha_formateada}} ,&nbsp Tipo de sancion: {{ $ultima_sancion->categoriaSancion->nombre }}, &nbsp Otorgada por: {{ $ultima_sancion->detalleSancion->user->name }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_sanciones"> Ver Más</a>
                                    </td>
                                    @else
                                    <td> No cuenta con sanciones </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{route('personales.editSanctionsUser',$user->id)}}" class="btn btn-primary"> <i class="fa fa-solid fa-user-minus "></i> </a>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Descuentos</th>
                                    @if(isset($user->descuentos[count($user->descuentos)-1]))
                                    @php
                                    $ultimo_descuento = $user->descuentos[count($user->descuentos)-1];
                                    @endphp

                                    @php $descuento_fecha = date('d-m-Y', strtotime($ultimo_descuento->fecha)); @endphp
                                    <td> Fecha: {{$descuento_fecha}} ,&nbsp Monto: {{ $ultimo_descuento->monto }}Bs. , &nbsp Motivo: {{ $ultimo_descuento->motivo }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_descuentos"> Ver Más</a>
                                        <!-- <a href="">Ver Mas</a> -->
                                    </td>

                                    @else
                                    <td> No cuenta con descuentos </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{route('personales.editDescountUser',$user->id)}}" class="btn btn-primary"> <i class="fa fa-solid fa-minus fa-lg"></i></a>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Vacaciones</th>
                                    @if(isset($user->vacaciones[count($user->vacaciones)-1]))
                                    @php
                                    $ultima_vacacion = $user->vacaciones[count($user->vacaciones)-1];
                                    $fecha_vacacion_inicio = date('d-m-Y', strtotime($ultima_vacacion->fecha_inicio));
                                    $fecha_vacacion_fin = date('d-m-Y', strtotime($ultima_vacacion->fecha_fin));
                                    @endphp
                                    <td>
                                        Fecha inicio: {{$fecha_vacacion_inicio }},&nbsp Fecha fin: {{ $fecha_vacacion_fin}},&nbsp Otorgado por: {{ $ultima_vacacion->detalleVacacion->user->name }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_vacaciones"> Ver Más </a>
                                    </td>
                                    @else
                                    <td> No se le otorgaron vacaciones </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales_vacaciones.agregarVacacion',$user->id)}}" class="btn btn-primary"><i class="fa fa-plane-departure "></i> </a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="justify-content: center;">
                        <h4 style="font-size:21px;color: #6777ef; "> Resultados Evaluaciones de: {{$user->name}}</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Comunicacion (Amabilidad)</th>
                                    @if(isset($user->detalleContratos[count($user->detalleContratos)-1]))
                                    @php
                                    $ultimo_contrato = $user->detalleContratos[count($user->detalleContratos)-1];
                                    $fecha_formateada_inicio = date('d-m-Y', strtotime($ultimo_contrato->fecha_inicio_contrato));
                                    $fecha_formateada_fin = date('d-m-Y', strtotime($ultimo_contrato->fecha_fin_contrato));
                                    @endphp
                                    <td>
                                        Tipo contrato : {{$ultimo_contrato->contrato->tipo_contrato}} , &nbsp Fecha Contrato: {{$fecha_formateada_inicio}} a {{$fecha_formateada_fin}} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_contratos"> Ver Más</a>
                                    </td>
                                    @else
                                    <td class="alerta" style="color:#FC544B;">
                                        Sin Contrato &nbsp &nbsp
                                    </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales.editContratoUser', $user->id)}}" class="btn btn-primary"><i class="fa fa-solid fa-folder-plus fa-lg"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Coordinacion (Orden y Limpieza)</th>
                                    @if(isset($user->bonos[count($user->bonos)-1]))
                                    @php
                                    $ultimo_bono = $user->bonos[count($user->bonos)-1];
                                    @endphp
                                    <td> Bono: {{ $ultimo_bono->monto }} Bs. &nbsp
                                        Motivo: {{ $ultimo_bono->motivo}} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_bonos"> Ver Más</a>
                                    </td>
                                    @else
                                    <td> No cuenta con bonos </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales.editBonoUser', $user->id)}}" class="btn btn-primary"></i> <i class="fa fa-solid fa-bold fa-lg"></i> </a>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Cooperacion </th>
                                    @if(isset($user->sanciones[count($user->sanciones)-1]))
                                    @php
                                    $ultima_sancion = $user->sanciones[count($user->sanciones)-1];
                                    $fecha_formateada = date('d-m-Y', strtotime($ultima_sancion->fecha));
                                    @endphp
                                    <td> Fecha: {{$fecha_formateada}} ,&nbsp Tipo de sancion: {{ $ultima_sancion->categoriaSancion->nombre }}, &nbsp Otorgada por: {{ $ultima_sancion->detalleSancion->user->name }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_sanciones"> Ver Más</a>
                                    </td>
                                    @else
                                    <td> No cuenta con sanciones </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{route('personales.editSanctionsUser',$user->id)}}" class="btn btn-primary"> <i class="fa fa-solid fa-user-minus "></i> </a>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Conocimiento (Cumplimiento)</th>
                                    @if(isset($user->descuentos[count($user->descuentos)-1]))
                                    @php
                                    $ultimo_descuento = $user->descuentos[count($user->descuentos)-1];
                                    @endphp

                                    @php $descuento_fecha = date('d-m-Y', strtotime($ultimo_descuento->fecha)); @endphp
                                    <td> Fecha: {{$descuento_fecha}} ,&nbsp Monto: {{ $ultimo_descuento->monto }}Bs. , &nbsp Motivo: {{ $ultimo_descuento->motivo }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_descuentos"> Ver Más</a>
                                        <!-- <a href="">Ver Mas</a> -->
                                    </td>

                                    @else
                                    <td> No cuenta con descuentos </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{route('personales.editDescountUser',$user->id)}}" class="btn btn-primary"> <i class="fa fa-solid fa-minus fa-lg"></i></a>

                                    </td>
                                </tr>
                                <tr>
                                    <th>Compromiso</th>
                                    @if(isset($user->vacaciones[count($user->vacaciones)-1]))
                                    @php
                                    $ultima_vacacion = $user->vacaciones[count($user->vacaciones)-1];
                                    $fecha_vacacion_inicio = date('d-m-Y', strtotime($ultima_vacacion->fecha_inicio));
                                    $fecha_vacacion_fin = date('d-m-Y', strtotime($ultima_vacacion->fecha_fin));
                                    @endphp
                                    <td>
                                        Fecha inicio: {{$fecha_vacacion_inicio }},&nbsp Fecha fin: {{ $fecha_vacacion_fin}},&nbsp Otorgado por: {{ $ultima_vacacion->detalleVacacion->user->name }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_vacaciones"> Ver Más </a>
                                    </td>
                                    @else
                                    <td> No se le otorgaron vacaciones </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales_vacaciones.agregarVacacion',$user->id)}}" class="btn btn-primary"><i class="fa fa-plane-departure "></i> </a>

                                    </td>
                                </tr>

                                <tr>
                                    <th>Carisma con el Cliente</th>
                                    @if(isset($user->vacaciones[count($user->vacaciones)-1]))
                                    @php
                                    $ultima_vacacion = $user->vacaciones[count($user->vacaciones)-1];
                                    $fecha_vacacion_inicio = date('d-m-Y', strtotime($ultima_vacacion->fecha_inicio));
                                    $fecha_vacacion_fin = date('d-m-Y', strtotime($ultima_vacacion->fecha_fin));
                                    @endphp
                                    <td>
                                        Fecha inicio: {{$fecha_vacacion_inicio }},&nbsp Fecha fin: {{ $fecha_vacacion_fin}},&nbsp Otorgado por: {{ $ultima_vacacion->detalleVacacion->user->name }} &nbsp <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modal_vacaciones"> Ver Más </a>
                                    </td>
                                    @else
                                    <td> No se le otorgaron vacaciones </td>
                                    @endif
                                    <td style="text-align: center;">
                                        <a href="{{ route('personales_vacaciones.agregarVacacion',$user->id)}}" class="btn btn-primary"><i class="fa fa-plane-departure "></i> </a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
</section>


{{-- Modal para ver Detalle del garante Asignado --}}

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
<script>
    $(function() {
        $('.zoom').zoomy();
    }(jQuery))
</script>
@section('page_js')

<script>
    $('#cerrar_modal').on('click', () => {
        $('#modalGarante').hidden();
    });
</script>

@endsection


@endsection


@section('page_css')
<style>
    .user {
        padding-left: 5px;
    }

    .alerta {
        color: #FC544B;
        font-weight: bold;
    }

    .avatar2 {
        /* cambia estos dos valores para definir el tamaño de tu círculo */
        height: 125px;
        width: 125px;
        /* los siguientes valores son independientes del tamaño del círculo */
        /*   background-repeat: no-repeat; */
        /* background-position: 50%;
        border-radius: 50%;
        background-size: 100% auto; */


    }


    .edit::before {
        font-size: 20px;
        transition: transform .2s;
        color: black;

    }

    .edit:hover {

        transform: scale(1.1);
    }

    .datos-basicos {
        background-color: whitesmoke;
        padding-top: 10px;
        border: 10px;
    }

    .datos-empresa {
        background-color: #fff;
        padding-top: 10px;

    }
</style>

@endsection