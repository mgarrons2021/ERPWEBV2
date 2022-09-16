@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('css')
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Cronologia de {{$user->name}} {{$user->apellido}}</h1>

    </div>
    <div class="section-body" id="experience">
        <div class="container">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="main-timeline">
                            @php
                            $_meses = [ ]; 
                            @endphp

                            @foreach ($data as $item )
                            @php
                            
                            array_push($_meses,$item['nombre_mes']);
                           

                            
                            @endphp
                            
                            <div class="timeline">
                                <div class="timeline-icon"><span class="year">{{ $item['nombre_mes'] }}</span></div>
                                <div class="timeline-content">
                                    <h3 class="title">Cronologia del Mes de {{ $item['nombre_mes'] }} </h3>

                                    @if ($item['sanciones']===0)
                                    <p class="description">
                                        Sin Sanciones
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Sanciones Asignados {{$item['sanciones'];}} <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalSancion"> Ver</a>
                                    </p>

                                    @endif
                                    @if ($item['bonos']===0)
                                    <p class="description">
                                        Sin Bonos
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Bonos Asignados {{ $item['bonos'];}} <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalBono"> Ver</a>
                                    </p>
                                    @endif
                                    @if ($item['descuentos']===0)
                                    <p class="description">
                                        Sin Descuentos
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Descuentos Asignados {{$item['descuentos'];}} <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalDescuento"> Ver</a>
                                    </p>
                                    @endif
                                    @if ($item['vacaciones']===0)
                                    <p class="description">
                                        Sin Vacaciones
                                    </p>
                                    @else
                                    <p class="description">
                                        Nro de Vacaciones Asignados {{$item['vacaciones'];}} <a href="" class="fa fa-eye" data-toggle="modal" data-target="#modalVacacion"> Ver</a>
                                    </p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @php 
                            echo json_encode($_meses);
                            @endphp
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Modal Sanciones -->
<div class="modal fade " id="modalSancion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h6 class="modal-title" id="exampleModalLongTitle"> <i class="fas fa-arrow-alt-circle-down icon" aria-hidden="true"></i> Sanciones asignadas al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Tipo sanción</th>
                            <th scope="col" style="text-align: center;">Descripcion</th>
                            <th scope="col" style="text-align: center;">Otorgado por</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>

                        @foreach ($user->sanciones as $sancion)
                        @php

                        $fecha= $sancion->fecha;
                        $fecha_com =\Carbon\Carbon::parse($fecha)->locale('es');


                        $fecha_fin = $fecha_com;
                        $fecha_fin =ucfirst($fecha_com->monthName);

                        @endphp


                        @if ($fecha_fin == $item['nombre_mes'])


                        <tr>
                            <td class="text-center table-light">
                                <a href="{{ route('sanciones.show', $sancion->id) }}" value="{{ $sancion->id }}" class="dato" target="_blank">
                                    @php $fecha_formateada_inicio = date('d-m-Y', strtotime( $sancion->fecha)); @endphp
                                    {{$fecha_formateada_inicio}} </a>
                            </td>
                            <td class="text-center">{{ $sancion->categoriaSancion->nombre }}
                            </td>
                            <td class="text-center">{{ $sancion->descripcion }}</td>
                            <td class="text-center"> {{$sancion->detalleSancion->user->name }}</td>
                        </tr>
                        @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Descuentos -->
<div class="modal fade " id="modalDescuento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h6 class="modal-title" id="exampleModalLongTitle"> <i class="fas fa-arrow-alt-circle-down icon" aria-hidden="true"></i> Descuentos asignados al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Monto</th>
                            <th scope="col" style="text-align: center;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->descuentos as $descuento)
                        @php
                        $fecha= $descuento->fecha;
                        $fecha_com =\Carbon\Carbon::parse($fecha)->locale('es');

                        $fecha_fin = $fecha_com;
                        $fecha_fin =ucfirst($fecha_com->monthName);
                        @endphp

                        @if ($fecha_fin == $item['nombre_mes'])
                        <tr>
                            <td class="text-center table-light">
                                <a href="{{ route('descuentos.show', $descuento->id) }}" value="{{ $user->id }}" class="dato" target="_blank">
                                    @php $descuento_fecha = date('d-m-Y', strtotime($descuento->fecha)); @endphp
                                    {{$descuento_fecha}} </a>
                            </td>
                            <td class="text-center">{{ $descuento->monto }}</td>
                            <td class="text-center">{{ $descuento->motivo }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Vacaciones -->
<div class="modal fade " id="modalVacacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h6 class="modal-title" id="exampleModalLongTitle"> <i class="fas fa-arrow-alt-circle-down icon" aria-hidden="true"></i> Vacaciones asignadas al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha Inicio</th>
                            <th scope="col" style="text-align: center;">Fecha Fin</th>
                            <th scope="col" style="text-align: center;">Otorgado por </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>

                        @foreach ($user->vacaciones as $index => $vacacion)


                        @php
                        
                        $fecha= $vacacion->fecha_inicio;
                        $fecha_com =\Carbon\Carbon::parse($fecha)->locale('es');


                        $fecha_final = $fecha_com;
                        $fecha_final =ucfirst($fecha_com->monthName);
                        /* echo($item['nombre_mes']);
                        echo($fecha_fin); */


                        @endphp


                        @if ($fecha_final == $item['nombre_mes'])

                        <tr>
                            <td class="text-center table-light">
                                <a href="{{ route('vacaciones.show', $vacacion->id) }}" value="{{ $user->id }}" class="dato" target="_blank">

                                    @php $fecha_formateada_inicio = date('d-m-Y', strtotime($vacacion->fecha_inicio)); @endphp
                                    {{$fecha_formateada_inicio}} </a>
                            </td>
                            @php $fecha_formateada_fin = date('d-m-Y', strtotime($vacacion->fecha_fin)); @endphp
                            <td class="text-center"> {{$fecha_formateada_fin}} </a></td>
                            <td class="text-center">{{ $vacacion->detalleVacacion->user->name}}</td>
                        </tr>
                        @endif


                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bonos -->
<div class="modal fade " id="modalBono" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h6 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-arrow-alt-circle-down icon" aria-hidden="true"></i> Bonos asignados al funcionario: {{ $user->name }} {{ $user->apellido}} </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead class="thead">
                        <tr>
                            <th scope="col" style="text-align: center;">Fecha</th>
                            <th scope="col" style="text-align: center;">Monto</th>
                            <th scope="col" style="text-align: center;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tbody>
                        @foreach ($user->bonos as $bono)
                        @php

                        $fecha= $bono->fecha;
                        $fecha_com =\Carbon\Carbon::parse($fecha)->locale('es');


                        $fecha_fin = $fecha_com;
                        $fecha_fin =ucfirst($fecha_com->monthName);
                        @endphp

                        @if ($fecha_fin == $item['nombre_mes'])
                        <tr>
                            <td class="text-center table-light">
                                @php $fecha_formateada_bono = date('d-m-Y', strtotime( $bono->fecha )); @endphp
                                {{$fecha_formateada_bono}}
                            </td>
                            <td class="text-center">{{ $bono->monto }}</td>
                            <td class="text-center">{{ $bono->motivo }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar </button>
            </div>
        </div>
    </div>
</div>




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

@endsection

@section('page_css')

<link href="{{ asset('assets/css/personales/reportes/cronologias.css') }}" rel="stylesheet" type="text/css" />

@endsection