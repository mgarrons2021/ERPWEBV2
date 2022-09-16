@extends('layouts.app', ['activePage' => 'tareas', 'titlePage' => 'Tareas'])

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

@endsection
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Actividades de: {{$user->name}} {{$user->apellido}} </h3>
    </div>
    <div class="section-body">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-center p-0 mt-3 mb-2">
                                <div class=" px-0 pt-4 pb-0 mt-3 mb-3">
                                    <h2 id="heading"> Mis tareas diarias </h2><br>
                                    <form action="{{ route('personales.saveTareas',$user->id)}}" method="POST" class="form-horizontal">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" class="form-control" id="pivot" name="pivot[]" value="{{$pivote}}">
                                        <!-- progressbar -->
                                        <ul id="progressbar">
                                            <li class="active" id="account"><strong>Ingreso</strong></li>
                                            <li id="personal"><strong>Preturno</strong></li>
                                            @role('Almacen')
                                            <li id="almacen"><strong>Despacho</strong></li>
                                            @endrole('Almacen')
                                            <li id="payment"><strong>Turno</strong></li>
                                            <li id="confirm"><strong>PosTurno</strong></li>
                                        </ul>

                                        <br>
                                        <!-- fieldsets -->
                                        <fieldset>
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Ingreso:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $porcen=0;
                                                        $_registros = [];
                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                            if ($pivot->tarea->turno === "Ingreso" ) {
                                                                array_push($_registros,$pivot->tarea->turno);
                                                                }
                                                            }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                            if($tarea->turno==="Ingreso"){
                                                                $_cantidad_ingreso++;
                                                            }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);

                                                        if($_cantidad_ingreso===0){
                                                             $porcen=0;
                                                        }else{
                                                            $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp

                                                        @if($porcen < 20) <p class="porcentaje" style="color:red;"> Cumplimiento: {{$porcen}} % </p>
                                                            @elseif($porcen < 70) <p class="porcentaje"> Cumplimiento: {{$porcen}} % </p>
                                                                @elseif($porcen = 100)
                                                                <p class="porcentaje" style="color:green;"> Cumplimiento: {{$porcen}} % </p>
                                                                @endif <br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @if(isset($tareas[count($tareas)-1]))
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Ingreso")
                                                            <tbody>
                                                                {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>
                                                                <td class="text-center"> {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>
                                                            </tbody>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <tr>
                                                                <td class="text-center" colspan="5"> Sin actividades registradas</td>
                                                            </tr>
                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>


                                            </div>
                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="submit" name="next" class="previous action-button-submit" value="Guardar" />
                                        </fieldset>
                                        <fieldset style=" display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Pre Turno:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];
                                                        $porcen=0;

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Pre Turno" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }
                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Pre Turno"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @if(sizeof($tareas)>0)
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Pre Turno")
                                                            <tbody>
                                                                {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>
                                                                <td class="text-center"> {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>
                                                            </tbody>
                                                            @endif
                                                            @endforeach
                                                            @else
                                                            <tbody>
                                                                <td class="text-center" colspan="5"> Sin actividades registradas</td>
                                                            </tbody>

                                                            @endif
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <input type="submit" name="next" class="action-button-submit" value="Guardar" />
                                        </fieldset>
                                        @role('Almacen')
                                        <fieldset style=" display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Despacho:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];
                                                        $porcen=0;

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Despacho" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Despacho"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Despacho")
                                                            <tbody>
                                                                {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>
                                                                <td class="text-center"> {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>
                                                            </tbody>
                                                            @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <input type="submit" name="next" class="action-button-submit" value="Guardar" />
                                        </fieldset>
                                        @endrole
                                        <fieldset style="display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de Turno:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];
                                                        $porcen=0;

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Turno" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Turno"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Turno")

                                                            <tbody>
                                                                {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>
                                                                <td class="text-center"> {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>
                                                            </tbody>
                                                            @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="button" name="next" class="next action-button" value="Siguiente" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <input type="submit" name="next" class="next action-button-submit" value="Guardar" />
                                        </fieldset>
                                        <fieldset style="display: none;">
                                            <div class="form-card">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="fs-title">Tareas de PosTurno:</h2>
                                                    </div>
                                                    <div class="col-5">
                                                        @php
                                                        $_registros = [ ];

                                                        if(isset($pivote[0]->tarea)){
                                                        foreach ($pivote as $pivot ){
                                                        if ($pivot->tarea->turno === "Post Turno" ) {
                                                        array_push($_registros,$pivot->tarea->turno);
                                                        }
                                                        }
                                                        }

                                                        $_cantidad_ingreso=0;
                                                        foreach($tareas as $tarea){
                                                        if($tarea->turno==="Post Turno"){
                                                        $_cantidad_ingreso++;
                                                        }
                                                        }
                                                        $cantidad_cumplimiento = sizeof($_registros);
                                                        if($_cantidad_ingreso===0){
                                                        $porcen=0;
                                                        }else{
                                                        $porcen= number_format($cantidad_cumplimiento*100/$_cantidad_ingreso,0);
                                                        }
                                                        @endphp
                                                        @if($porcen < 20) <h6 class="steps" style="color:red;"> Cumplimiento: {{$porcen}} % </h6>
                                                            @elseif($porcen < 70) <h6 class="steps"> Cumplimiento: {{$porcen}} % </h6>
                                                                @elseif($porcen = 100)
                                                                <h6 class="steps" style="color:green;"> Cumplimiento: {{$porcen}} % </h6>
                                                                @endif <br>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="table-responsive-md ">
                                                        <table class="table table-striped ">
                                                            <thead>
                                                                <th class="text-center"> Actividad</th>
                                                                <th class="text-center"> Estado</th>
                                                            </thead>
                                                            @foreach ($tareas as $tarea)
                                                            @php $hora_formateada = date('H:i', strtotime($tarea->hora_inicio)); @endphp
                                                            @php $hora_formateada_fin = date('H:i', strtotime($tarea->hora_fin)); @endphp
                                                            @if($tarea->turno==="Post Turno")
                                                            <tbody>
                                                                {!! Form::model($user ,['route' => ['personales.saveTareas',$user], 'method' => 'post']) !!}
                                                                <td class="text-center"> {{ $tarea->nombre }}</td>
                                                                <td class="text-center"> {!! Form::checkbox('tareas[]', $tarea->id, null, ['class' => 'form-check-control ']) !!}</td>
                                                            </tbody>
                                                            @endif
                                                            @endforeach
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>
                                            <input type="submit" name="next" class="next action-button-submit" value="Guardar" />
                                            <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                                            <br><br>
                                </div>
                                </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/personales/tareas/tarea.js') }}"> </script>


@endsection
@section('page_css')
<link href="{{ asset('assets/css/personales/tareas/tarea.css') }}" rel="stylesheet" type="text/css" />
@endsection