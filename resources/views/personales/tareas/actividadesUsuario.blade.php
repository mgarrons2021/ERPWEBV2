@extends('layouts.app',['activePage' => 'home', 'titlePage' => 'Home'])
@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">

@endsection
@section('content')

<section class="section">
  <div class="section-header">
    <h3 class="page__heading">Actividades de: {{$user->name}}</h3>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Seleccione la Fecha a Visualizar</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive" style="overflow-x: hidden">
              <form action="{{ route('personales.filtrarActividades',$user->id) }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-md-8">
                    <div class="input-daterange input-group" id="datepicker">
                      <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                      <input type="date" id="fechaini" class="input-sm form-control" name="fecha_inicial" value="" />
                    </div>
                  </div>
                  <div class="col-md-4">
                      <input class="form-control btn btn-primary" type="submit" value="Ver Actividades" id="filtrar" name="filtrar">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="container-fluid">
              <div class="row justify-content-center">
                <div class="">
                  <div class="">
                    <h2 id="heading" align="center">Seguimiento de actividades</h2>
                    <form id="msform">
                      <!-- progressbar -->
                      <ul id="progressbar">
                        <li class="active" id="account"><strong>Ingreso</strong></li>
                        <li id="personal"><strong>PreTurno</strong></li>
                        <li id="payment"><strong>Despacho</strong></li>
                        <li id="payment"><strong>Turno</strong></li>
                        <li id="confirm"><strong>PosTurno</strong></li>
                      </ul>
                      <br>
                      <!-- fieldsets -->

                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h2 class="fs-title">Fecha: {{$fecha_formateada}}</h2>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="table">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center"> Hora asignada</th>
                                <th class="text-center"> Hora realizada</th>
                                <th class="text-center"> Diferencia </th>
                                <th class="text-center"> Estado </th>

                              </thead>

                              @foreach ($tareas_ingreso as $tarea)

                              <tbody>
                                <tr>
                                  <td class="text-center bg-light"> {{$tarea->nombre}}</td>
                                  @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                  <td class="text-center"> Sin hora definida</td>
                                  @else
                                  <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                  @endif
                                  @php
                                  $sw=false;
                                  @endphp

                                  @foreach ($tarea_user as $usertarea )

                                  @php
                                  $diferencia = new DateTime();
                                  $hora_asignada_inicio= $tarea->hora_inicio ;
                                  $hora_asignada_fin= $tarea->hora_fin;
                                  $hora_realizada = $usertarea->created_at->format('H:i:s');

                                  $fecha1 = new DateTime($hora_asignada_fin);
                                  $fecha2 = new DateTime($hora_realizada);
                                  $diferencia = date_diff($fecha1,$fecha2);

                                  @endphp
                                  @if ($usertarea->tarea->id==$tarea->id)
                                  @php
                                  $sw=true;
                                  @endphp
                                  <td class="text-center">{{$usertarea->created_at->format('H:i:s')}}</td>
                                  <td class="text-center">{{$diferencia->format('%H horas %i minutos')}}</td>
                                  @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) <td class="text-center "><span class="badge badge-success"><i class="fa fa-thumbs-up"></i> Dentro de Horario</span> </td>
                                    @elseif ($hora_realizada < $hora_asignada_inicio) <td class="text-center"><span class="badge badge-warning"><i class="far fa-grin-beam"></i> Antes de Tiempo</span> </td>
                                      @elseif($hora_realizada > $hora_asignada_fin)
                                      <td class="text-center"><span class="badge badge-danger"><i class="fa fa-thumbs-down"></i> Fuera del Horario</span> </td>
                                      @endif

                                      @endif
                                      @endforeach
                                      @if ($sw==false)
                                      <td class="text-center table-danger">Sin datos</td>
                                      <td class="text-center  table-danger">Sin datos</td>
                                      <td class="text-center  table-danger"> <span class="badge badge-danger"> <i class="fas fa-dizzy"></i> Sin Completar</span></td>
                                      @endif
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                          </div>

                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                      </fieldset>

                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h2 class="fs-title">Fecha: {{$fecha_formateada}}</h2>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center"> Hora asignada</th>
                                <th class="text-center"> Hora realizada</th>
                                <th class="text-center"> Diferencia </th>
                                <th class="text-center"> Estado </th>

                              </thead>

                              @foreach ($tareas_preturno as $tarea)

                              <tbody>
                                <tr>
                                  <td class="text-center bg-light"> {{$tarea->nombre}}</td>
                                  @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                  <td class="text-center"> Sin hora definida</td>
                                  @else
                                  <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                  @endif
                                  @php
                                  $sw=false;
                                  @endphp

                                  @foreach ($tarea_user as $usertarea )

                                  @php
                                  $diferencia = new DateTime();
                                  $hora_asignada_inicio= $tarea->hora_inicio ;
                                  $hora_asignada_fin= $tarea->hora_fin;
                                  $hora_realizada = $usertarea->created_at->format('H:i:s');

                                  $fecha1 = new DateTime($hora_asignada_fin);
                                  $fecha2 = new DateTime($hora_realizada);
                                  $diferencia = date_diff($fecha1,$fecha2);

                                  @endphp
                                  @if ($usertarea->tarea->id==$tarea->id)
                                  @php
                                  $sw=true;
                                  @endphp
                                  <td class="text-center">{{$usertarea->created_at->format('H:i:s')}}</td>
                                  <td class="text-center">{{$diferencia->format('%H horas %i minutos')}}</td>
                                  @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) <td class="text-center "><span class="badge badge-success"><i class="fa fa-thumbs-up"></i> Dentro de Horario</span> </td>
                                    @elseif ($hora_realizada < $hora_asignada_inicio) <td class="text-center"><span class="badge badge-warning"><i class="far fa-grin-beam"></i> Antes de Tiempo</span> </td>
                                      @elseif($hora_realizada > $hora_asignada_fin)
                                      <td class="text-center"><span class="badge badge-danger"><i class="fa fa-thumbs-down"></i> Fuera del Horario</span> </td>
                                      @endif

                                      @endif
                                      @endforeach
                                      @if ($sw==false)
                                      <td class="text-center table-danger">Sin datos</td>
                                      <td class="text-center  table-danger">Sin datos</td>
                                      <td class="text-center  table-danger"> <span class="badge badge-danger"> <i class="fas fa-dizzy"></i> Sin Completar</span></td>
                                      @endif
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                          </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h2 class="fs-title">Fecha: {{$fecha_formateada}}</h2>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center"> Hora asignada</th>
                                <th class="text-center"> Hora realizada</th>
                                <th class="text-center"> Diferencia </th>
                                <th class="text-center"> Estado </th>

                              </thead>

                              @foreach ($tareas_despacho as $tarea)

                              <tbody>
                                <tr>
                                  <td class="text-center bg-light"> {{$tarea->nombre}}</td>
                                  @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                  <td class="text-center"> Sin hora definida</td>
                                  @else
                                  <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                  @endif
                                  @php
                                  $sw=false;
                                  @endphp

                                  @foreach ($tarea_user as $usertarea )

                                  @php
                                  $diferencia = new DateTime();
                                  $hora_asignada_inicio= $tarea->hora_inicio ;
                                  $hora_asignada_fin= $tarea->hora_fin;
                                  $hora_realizada = $usertarea->created_at->format('H:i:s');

                                  $fecha1 = new DateTime($hora_asignada_fin);
                                  $fecha2 = new DateTime($hora_realizada);
                                  $diferencia = date_diff($fecha1,$fecha2);

                                  @endphp
                                  @if ($usertarea->tarea->id==$tarea->id)
                                  @php
                                  $sw=true;
                                  @endphp
                                  <td class="text-center">{{$usertarea->created_at->format('H:i:s')}}</td>
                                  <td class="text-center">{{$diferencia->format('%H horas %i minutos')}}</td>
                                  @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) <td class="text-center "><span class="badge badge-success"><i class="fa fa-thumbs-up"></i> Dentro de Horario</span> </td>
                                    @elseif ($hora_realizada < $hora_asignada_inicio) <td class="text-center"><span class="badge badge-warning"><i class="far fa-grin-beam"></i> Antes de Tiempo</span> </td>
                                      @elseif($hora_realizada > $hora_asignada_fin)
                                      <td class="text-center"><span class="badge badge-danger"><i class="fa fa-thumbs-down"></i> Fuera del Horario</span> </td>
                                      @endif

                                      @endif
                                      @endforeach
                                      @if ($sw==false)
                                      <td class="text-center table-danger">Sin datos</td>
                                      <td class="text-center  table-danger">Sin datos</td>
                                      <td class="text-center  table-danger"> <span class="badge badge-danger"> <i class="fas fa-dizzy"></i> Sin Completar</span></td>
                                      @endif
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                          </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>

                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h2 class="fs-title">Fecha: {{$fecha_formateada}}</h2>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="table_turno">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center"> Hora asignada</th>
                                <th class="text-center"> Hora realizada</th>
                                <th class="text-center"> Diferencia </th>
                                <th class="text-center"> Estado </th>

                              </thead>

                              @foreach ($tareas_turno as $tarea)

                              <tbody>
                                <tr>
                                  <td class="text-center bg-light"> {{$tarea->nombre}}</td>
                                  @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                  <td class="text-center"> Sin hora definida</td>
                                  @else
                                  <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                  @endif
                                  @php
                                  $sw=false;
                                  @endphp

                                  @foreach ($tarea_user as $usertarea )

                                  @php
                                  $diferencia = new DateTime();
                                  $hora_asignada_inicio= $tarea->hora_inicio ;
                                  $hora_asignada_fin= $tarea->hora_fin;
                                  $hora_realizada = $usertarea->created_at->format('H:i:s');

                                  $fecha1 = new DateTime($hora_asignada_fin);
                                  $fecha2 = new DateTime($hora_realizada);
                                  $diferencia = date_diff($fecha1,$fecha2);

                                  @endphp
                                  @if ($usertarea->tarea->id==$tarea->id)
                                  @php
                                  $sw=true;
                                  @endphp
                                  <td class="text-center">{{$usertarea->created_at->format('H:i:s')}}</td>
                                  <td class="text-center">{{$diferencia->format('%H horas %i minutos')}}</td>
                                  @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) <td class="text-center "><span class="badge badge-success"><i class="fa fa-thumbs-up"></i> Dentro de Horario</span> </td>
                                    @elseif ($hora_realizada < $hora_asignada_inicio) <td class="text-center"><span class="badge badge-warning"><i class="far fa-grin-beam"></i> Antes de Tiempo</span> </td>
                                      @elseif($hora_realizada > $hora_asignada_fin)
                                      <td class="text-center"><span class="badge badge-danger"><i class="fa fa-thumbs-down"></i> Fuera del Horario</span> </td>
                                      @endif

                                      @endif
                                      @endforeach
                                      @if ($sw==false)
                                      <td class="text-center table-danger">Sin datos</td>
                                      <td class="text-center  table-danger">Sin datos</td>
                                      <td class="text-center  table-danger"> <span class="badge badge-danger"> <i class="fas fa-dizzy"></i> Sin Completar</span></td>
                                      @endif
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                          </div>
                          
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h2 class="fs-title">Fecha: {{$fecha_formateada}}</h2>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center"> Hora asignada</th>
                                <th class="text-center"> Hora realizada</th>
                                <th class="text-center"> Diferencia </th>
                                <th class="text-center"> Estado </th>

                              </thead>

                              @foreach ($tareas_posturno as $tarea)

                              <tbody>
                                <tr>
                                  <td class="text-center bg-light"> {{$tarea->nombre}}</td>
                                  @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                  <td class="text-center"> Sin hora definida</td>
                                  @else
                                  <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                  @endif
                                  @php
                                  $sw=false;
                                  @endphp

                                  @foreach ($tarea_user as $usertarea )

                                  @php
                                  $diferencia = new DateTime();
                                  $hora_asignada_inicio= $tarea->hora_inicio ;
                                  $hora_asignada_fin= $tarea->hora_fin;
                                  $hora_realizada = $usertarea->created_at->format('H:i:s');

                                  $fecha1 = new DateTime($hora_asignada_fin);
                                  $fecha2 = new DateTime($hora_realizada);
                                  $diferencia = date_diff($fecha1,$fecha2);

                                  @endphp
                                  @if ($usertarea->tarea->id==$tarea->id)
                                  @php
                                  $sw=true;
                                  @endphp
                                  <td class="text-center">{{$usertarea->created_at->format('H:i:s')}}</td>
                                  <td class="text-center">{{$diferencia->format('%H horas %i minutos')}}</td>
                                  @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) <td class="text-center "><span class="badge badge-success"><i class="fa fa-thumbs-up"></i> Dentro de Horario</span> </td>
                                    @elseif ($hora_realizada < $hora_asignada_inicio) <td class="text-center"><span class="badge badge-warning"><i class="far fa-grin-beam"></i> Antes de Tiempo</span> </td>
                                      @elseif($hora_realizada > $hora_asignada_fin)
                                      <td class="text-center"><span class="badge badge-danger"><i class="fa fa-thumbs-down"></i> Fuera del Horario</span> </td>
                                      @endif

                                      @endif
                                      @endforeach
                                      @if ($sw==false)
                                      <td class="text-center table-danger">Sin datos</td>
                                      <td class="text-center  table-danger">Sin datos</td>
                                      <td class="text-center  table-danger"> <span class="badge badge-danger"> <i class="fas fa-dizzy"></i> Sin Completar</span></td>
                                      @endif
                                </tr>
                              </tbody>
                              @endforeach
                            </table>
                          </div>                        
                        </div>
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('page_js')
<script>
  $('#table_turno').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningun dato disponible en esta tabla",
          sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
              sFirst: "Primero",
              sLast: "Ãšltimo",
              sNext: "Siguiente",
              sPrevious: "Anterior"
          },
          oAria: {
              sSortAscending: ": Activar para ordenar la columna de manera ascendente",
              sSortDescending: ": Activar para ordenar la columna de manera descendente"
          }
      },
      columnDefs: [{
              orderable: false,
              targets: 5
          },
          
      ]
  });
</script>
@endsection
@section('scripts')


<script>
  $(document).ready(function() {


    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function() {

      current_fs = $(this).parent();
      next_fs = $(this).parent().next();

      //Add Class Active
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate({
        opacity: 0
      }, {
        step: function(now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          next_fs.css({
            'opacity': opacity
          });
        },
        duration: 500
      });
      setProgressBar(++current);
    });

    $(".previous").click(function() {

      current_fs = $(this).parent();
      previous_fs = $(this).parent().prev();

      //Remove class active
      $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

      //show the previous fieldset
      previous_fs.show();

      //hide the current fieldset with style
      current_fs.animate({
        opacity: 0
      }, {
        step: function(now) {
          // for making fielset appear animation
          opacity = 1 - now;

          current_fs.css({
            'display': 'none',
            'position': 'relative'
          });
          previous_fs.css({
            'opacity': opacity
          });
        },
        duration: 500
      });
      setProgressBar(--current);
    });

    function setProgressBar(curStep) {
      var percent = parseFloat(100 / steps) * curStep;
      percent = percent.toFixed();
      $(".progress-bar")
        .css("width", percent + "%")
    }

    $(".submit").click(function() {
      return false;
    })

  });
</script>

<script>
  $('#table1').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _MENU_ registros",
          sZeroRecords: "No se encontraron resultados",
          sEmptyTable: "Ningun dato disponible en esta tabla",
          sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
          sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
          sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
          sInfoPostFix: "",
          sSearch: "Buscar:",
          sUrl: "",
          sInfoThousands: ",",
          sLoadingRecords: "Cargando...",
          oPaginate: {
              sFirst: "Primero",
              sLast: "Ãšltimo",
              sNext: "Siguiente",
              sPrevious: "Anterior"
          },
          oAria: {
              sSortAscending: ": Activar para ordenar la columna de manera ascendente",
              sSortDescending: ": Activar para ordenar la columna de manera descendente"
          }
      },
      columnDefs: [{
              orderable: false,
              targets: 5
          },
          
      ]
  });
</script>


@endsection



@section('page_css')
<style>
  * {
    margin: 0;
    padding: 0;
  }

  html {
    height: 100%;
  }

  p {
    color: grey;
  }

  .libro {
    background-color: red;
  }

  #heading {
    text-transform: uppercase;
    color: #6777EF;
    font-weight: normal;
  }

  #msform {
    text-align: center;
    position: relative;
    margin-top: 20px;
  }

  #msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;

    /*stacking fieldsets above each other*/
    position: relative;
  }

  .form-card {
    text-align: left;
  }

  /*Hide all except first fieldset*/
  #msform fieldset:not(:first-of-type) {
    display: none;
  }

  #msform input,
  #msform textarea {
    padding: 8px 15px 8px 15px;
    border: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    font-family: montserrat;
    color: #2C3E50;
    background-color: #ECEFF1;
    font-size: 16px;
    letter-spacing: 1px;
  }

  #msform input:focus,
  #msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: 1px solid #6777EF;
    outline-width: 0;
  }

  /*Next Buttons*/
  #msform .action-button {
    width: 100px;
    background: #3D4EAF;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 0px 10px 5px;
    float: right;
  }

  #msform .action-button:hover,
  #msform .action-button:focus {
    background-color: #311B92;
  }

  /*Previous Buttons*/
  #msform .action-button-previous {
    width: 100px;
    background: #616161;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px 10px 0px;
    float: right;
  }

  #msform .action-button-previous:hover,
  #msform .action-button-previous:focus {
    background-color: #000000;
  }

  /*The background card*/
  .card {
    z-index: 0;
    border: none;
    position: relative;
  }

  /*FieldSet headings*/
  .fs-title {
    font-size: 25px;
    margin-bottom: 15px;
    font-weight: normal;
    text-align: left;
  }

  .purple-text {
    color: #6777EF;
    font-weight: normal;
  }

  /*Step Count*/
  .steps {
    font-size: 25px;
    color: gray;
    margin-bottom: 10px;
    font-weight: normal;
    text-align: right;
  }

  /*Field names*/
  .fieldlabels {
    color: gray;
    text-align: left;
  }

  /*Icon progressbar*/
  #progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: lightgrey;
  }

  #progressbar .active {
    color: #6777EF;
  }

  #progressbar li {
    list-style-type: none;
    font-size: 15px;
    width: 20%;
    float: left;
    position: relative;
    font-weight: 400;
  }

  /*Icons in the ProgressBar*/
  #progressbar #account:before {
    font-family: FontAwesome;
    content: "\f01a";
  }

  #progressbar #personal:before {
    font-family: FontAwesome;
    content: "\f01a";

  }

  #progressbar #payment:before {
    font-family: FontAwesome;
    content: "\f01a";
  }

  #progressbar #turno:before {
    font-family: FontAwesome;
    content: "\f01a";
  }

  #progressbar #confirm:before {
    font-family: FontAwesome;
    content: "\f01a";
  }

  /*Icon ProgressBar before any progress*/
  #progressbar li:before {
    width: 50px;
    height: 50px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    color: #ffffff;
    background: lightgray;
    border-radius: 50%;
    margin: 0 auto 10px auto;
    padding: 2px;
  }

  /*ProgressBar connectors*/
  #progressbar li:after {
    content: '';
    width: 100%;
    height: 2px;
    background: lightgray;
    position: absolute;
    left: 0;
    top: 25px;
    z-index: -1;
  }

  /*Color number of the step and the connector before it*/
  #progressbar li.active:before,
  #progressbar li.active:after {
    background: #4AAA4D
      /* ewew */
  }

  /*Animated Progress Bar*/
  .progress {
    height: 20px;
  }

  .progress-bar {
    background-color: #673AB7;
  }

  /*Fit image in bootstrap div*/
  .fit-image {
    width: 100%;
    object-fit: cover;
  }
</style>
@endsection