@extends('layouts.app', ['activePage' => 'reporte_seguimiento', 'titlePage' => 'Reportes'])

@section('content')

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection

<section class="section">
    <div class="section-header">
        <h1 class="text-center">Reporte de Seguimiento de Actividades : {{$user->name}} {{$user->apellido}} </h1>
    </div>      
    <div class="card-body">      
      <div class="col-lg-12">
        <div class="col-lg-6">
                <a type="button" class="btn btn-success" id="atras"  href="{{ route('personales.mostrarUsuarios') }}">Atras</a>
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
                      @php                           
                          $datetime1 = new DateTime($desde);
                          $datetime2 = new DateTime($hasta);
                          $cantidadDias = intval(($datetime1->diff($datetime2))->days)+1;     
                          $sumatotalhoras=0;
                          $sumatotalminutos=0;
                          $aux=0;
                          $auxcontarfilas=0;
                          $intermediofilas=false;
                          $dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'); 
                          
                          $nrodiashecho=0;
                      @endphp
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h3 class="fs-title text-dark">Desde: {{$desde}} Hasta: {{$hasta}}</h3>
                            </div>
                          </div>
                          <div></div>   
                            <div class="table-responsive">               
                            @php   
                              $fechaInicio=strtotime($desde);
                              $fechaFin=strtotime($hasta);                                  
                            @endphp
                            <table class="table" id="table1">                                 
                                <thead class="table-primary">
                                  <th class="text-center"> Tarea </th>
                                  <th class="text-center">Tiempo Estimado</th>                               
                                  @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    @php  $diasemana=  $dias[(date('N', strtotime( date("d-m-Y", $i) ))) - 1];  @endphp
                                    <th class="text-center"> {{$diasemana}} <br>{{date("d-m-Y", $i)}}  </th>
                                  @endfor                               
                                  <th class="text-center" >Tiempo Promedio</th>
                                  <th class="text-center" >Cant. Dias Realizados</th>   
                                </thead>                                
                                <tbody class="table-bordered">
                                @foreach ($tareas_ingreso as $tarea)                                
                                  <tr>                                 
                                  <td class="text-center bg-light"> {{$tarea->nombre}}  </td>         
                                  @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                  <td class="text-center"> Sin hora definida</td>
                                  @else                                          
                                  <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                  @endif
                                 
                                  @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    <td class="text-center" >  
                                    @foreach ($tarea_user as $usertarea )
                                      @php
                                      $diferencia = new DateTime();
                                      $hora_asignada_inicio = $tarea->hora_inicio ;
                                      $hora_asignada_fin = $tarea->hora_fin;
                                      $hora_realizada = $usertarea->created_at->format('H:i:s');
                      
                                      $fecha1 = new DateTime($hora_asignada_fin);
                                      $fecha2 = new DateTime($hora_realizada);
                                      $diferencia = date_diff($fecha1,$fecha2);

                                      $dia = $dias[(date('N', strtotime($usertarea->created_at))) - 1];
                                      @endphp
                                        
                                        @if ($usertarea->tarea->id==$tarea->id)  
                                        
                                          @if( date("d-m-Y", $i) ==  $usertarea->created_at->format('d-m-Y') )                                                                 
                                            
                                            @php  
                                              $nrodiashecho+=1;
                                              $intermediofilas = true;                                               
                                              $sumatotalhoras+= intval( $usertarea->created_at->format('H') );
                                              $sumatotalminutos+=intval( $usertarea->created_at->format('i') );
                                            @endphp                                        

                                            @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) 
                                                <span class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                            @elseif ($hora_realizada < $hora_asignada_inicio)                                             
                                                <span class="badge badge-warning"><i class="far fa-grin-beam"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                            @elseif($hora_realizada > $hora_asignada_fin) 
                                                <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>  {{$usertarea->created_at->format('H:i:s')}}</span>
                                            @endif                                            
                                            
                                            @break
                                          @endif
                                        @endif        
                                    @endforeach  
                                    @if($intermediofilas == false)
                                    <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>Sin asignar</span>
                                    @else 
                                      @php  $intermediofilas =false;  @endphp
                                    @endif
                                    </td>
                                  @endfor
                                  <td> {{intdiv($sumatotalhoras,$cantidadDias)}} : {{intdiv($sumatotalminutos,$cantidadDias)}} </td>
                                  <td class="text-center">
                                      {{$nrodiashecho}} de {{$cantidadDias}} 
                                  </td>
                                </tr>               
                                @php 
                                $nrodiashecho=0;
                                $sumatotalhoras=0;
                                $sumatotalminutos=0;
                                @endphp                 
                                @endforeach
                              </tbody>                              
                            </table>
                          </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                      </fieldset>
                      @php 
                      $nrodiashecho=0;
                      $sumatotalhoras=0;
                      $sumatotalminutos=0;
                      @endphp
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h3 class="fs-title text-dark">Desde: {{$desde}} Hasta: {{$hasta}}</h3>
                            </div>
                          </div>
                          <div>
                          </div>
                          <div class="table-responsive">
                            <table class="table" id="table2">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center">Tiempo Estimado</th>                         
                                @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                  @php  $diasemana=  $dias[(date('N', strtotime( date("d-m-Y", $i) ))) - 1];  @endphp
                                  <th class="text-center"> {{$diasemana}} <br>{{date("d-m-Y", $i)}}  </th>
                                @endfor                          
                                <th class="text-center">Tiempo Promedio</th>   
                                <th class="text-center">Cant. Dias Realizados</th>
                              </thead>                             
                              <tbody>
                                @foreach ($tareas_preturno as $tarea)
                                  <tr>                                 
                                    <td class="text-center bg-light"> {{$tarea->nombre}}  </td>              
                                    
                                    @php 
                                        $intermediofilas=false;
                                    @endphp

                                    @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                    <td class="text-center"> Sin hora definida</td>
                                    @else                                          
                                    <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                    @endif
                                
                                    @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    <td class="text-center" >  
                                      @foreach ($tarea_user as $usertarea )                                   
                                      
                                        @php
                                        $diferencia = new DateTime();
                                        $hora_asignada_inicio= $tarea->hora_inicio ;
                                        $hora_asignada_fin= $tarea->hora_fin;
                                        $hora_realizada = $usertarea->created_at->format('H:i:s');
                        
                                        $fecha1 = new DateTime($hora_asignada_fin);
                                        $fecha2 = new DateTime($hora_realizada);
                                        $diferencia = date_diff($fecha1,$fecha2);

                                        $dia = $dias[(date('N', strtotime($usertarea->created_at))) - 1];
                                        @endphp
                                          
                                          @if ($usertarea->tarea->id==$tarea->id)  
                                          
                                            @if( date("d-m-Y", $i) ==  $usertarea->created_at->format('d-m-Y') )                                                                 
                                              
                                              @php  
                                              $nrodiashecho+=1;
                                              $intermediofilas = true;
                                              $sumatotalhoras+= intval( $usertarea->created_at->format('H') );
                                              $sumatotalminutos+=intval( $usertarea->created_at->format('i') ); 
                                               @endphp                                        

                                              @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) 
                                                  <span class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif ($hora_realizada < $hora_asignada_inicio)                                             
                                                  <span class="badge badge-warning"><i class="far fa-grin-beam"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif($hora_realizada > $hora_asignada_fin)
                                                  <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>  {{$usertarea->created_at->format('H:i:s')}}</span>
                                              @endif                                            
                                              
                                              @break
                                            @endif
                                              
                                          @endif        

                                      @endforeach  
                                      @if($intermediofilas == false)
                                      <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>Sin asignar</span>
                                      @else 
                                        @php  $intermediofilas =false;  @endphp
                                      @endif
                                      </td>   
                                    @endfor        
                                    <td class="text-center"> {{intdiv($sumatotalhoras,$cantidadDias)}} : {{intdiv($sumatotalminutos,$cantidadDias)}}</td>                       
                                    <td class="text-center">
                                        {{$nrodiashecho}} de {{$cantidadDias}}
                                    </td>
                                </tr>
                                @php 
                                  $nrodiashecho=0;
                                  $sumatotalhoras=0;
                                  $sumatotalminutos=0;
                                 @endphp
                                @endforeach
                              </tbody>                              
                            </table>
                          </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>
                      @php 
                      $nrodiashecho=0;
                      $sumatotalhoras=0;
                      $sumatotalminutos=0;
                      @endphp
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h3 class="fs-title text-dark">Desde: {{$desde}} Hasta: {{$hasta}}</h3>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="table3">
                              <thead class="table-primary">
                                <th class="text-center"> Tarea </th>
                                <th class="text-center">Tiempo Estimado</th>                           

                                @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                  @php  $diasemana=  $dias[(date('N', strtotime( date("d-m-Y", $i) ))) - 1];  @endphp
                                  <th class="text-center"> {{$diasemana}} <br>{{date("d-m-Y", $i)}}  </th>
                                @endfor                          
                                <th class="text-center">Tiempo Promedio</th>
                                <th class="text-center">Cant. Dias Realizados</th>   
                              </thead>                               
                              
                              <tbody>
                                @foreach ($tareas_despacho as $tarea)
                                <tr>                                 
                                    <td class="text-center bg-light"> {{$tarea->nombre}}  </td>              
                                    
                                    @php 
                                        $intermediofilas=false;
                                    @endphp

                                    @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                    <td class="text-center"> Sin hora definida</td>
                                    @else                                          
                                    <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                    @endif
                                
                                    @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    <td class="text-center" >  
                                      @foreach ($tarea_user as $usertarea )                                   
                                      
                                        @php
                                        $diferencia = new DateTime();
                                        $hora_asignada_inicio= $tarea->hora_inicio ;
                                        $hora_asignada_fin= $tarea->hora_fin;
                                        $hora_realizada = $usertarea->created_at->format('H:i:s');
                        
                                        $fecha1 = new DateTime($hora_asignada_fin);
                                        $fecha2 = new DateTime($hora_realizada);
                                        $diferencia = date_diff($fecha1,$fecha2);

                                        $dia = $dias[(date('N', strtotime($usertarea->created_at))) - 1];
                                        @endphp
                                          
                                          @if ($usertarea->tarea->id==$tarea->id)  
                                          
                                            @if( date("d-m-Y", $i) ==  $usertarea->created_at->format('d-m-Y') )                                                                 
                                              
                                              @php  
                                              $nrodiashecho+=1;
                                              $intermediofilas = true;
                                              $sumatotalhoras+= intval( $usertarea->created_at->format('H') );
                                              $sumatotalminutos+=intval( $usertarea->created_at->format('i') ); 
                                               @endphp                                        

                                              @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) 
                                                  <span class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif ($hora_realizada < $hora_asignada_inicio)                                             
                                                  <span class="badge badge-warning"><i class="far fa-grin-beam"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif($hora_realizada > $hora_asignada_fin)
                                                  <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>  {{$usertarea->created_at->format('H:i:s')}}</span>
                                              @endif                                            
                                              
                                              @break
                                            @endif
                                              
                                          @endif        

                                      @endforeach  
                                      @if($intermediofilas == false)
                                      <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>Sin asignar</span>
                                      @else 
                                        @php  $intermediofilas =false;  @endphp
                                      @endif
                                      </td>   
                                    @endfor           
                                    <td class="text-center">{{intdiv($sumatotalhoras,$cantidadDias)}} : {{intdiv($sumatotalminutos,$cantidadDias)}}</td>                    
                                    <td class="text-center">
                                       {{$nrodiashecho}} de {{$cantidadDias}}
                                    </td>
                                </tr>
                                @php 
                                  $nrodiashecho=0;
                                  $sumatotalhoras=0;
                                  $sumatotalminutos=0;
                                @endphp
                                @endforeach
                              </tbody>                              
                            </table>
                          </div>
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>
                      @php 
                       $nrodiashecho=0;
                       $sumatotalhoras=0;
                       $sumatotalminutos=0;
                      @endphp
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h3 class="fs-title text-dark">Desde: {{$desde}} Hasta: {{$hasta}}</h3>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="table4">
                                <thead class="table-primary">
                                    <th class="text-center"> Tarea </th>
                                    <th class="text-center">Tiempo Estimado</th>                           

                                    @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                      @php  $diasemana=  $dias[(date('N', strtotime( date("d-m-Y", $i) ))) - 1];  @endphp
                                      <th class="text-center"> {{$diasemana}} <br>{{date("d-m-Y", $i)}}  </th>
                                    @endfor                          
                                    <th class="text-center">Tiempo Promedio</th>   
                                    <th class="text-center" >Cant. Dias Realizados</th>
                                 </thead>                           

                              <tbody>
                                @foreach ($tareas_turno as $tarea)
                                <tr>                                 
                                    <td class="text-center bg-light"> {{$tarea->nombre}}  </td>              
                                    
                                    @php 
                                        $intermediofilas=false;
                                    @endphp

                                    @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                    <td class="text-center"> Sin hora definida</td>
                                    @else                                          
                                    <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                    @endif
                                
                                    @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    <td class="text-center" >  
                                      @foreach ($tarea_user as $usertarea )                                   
                                      
                                        @php
                                        $diferencia = new DateTime();
                                        $hora_asignada_inicio= $tarea->hora_inicio ;
                                        $hora_asignada_fin= $tarea->hora_fin;
                                        $hora_realizada = $usertarea->created_at->format('H:i:s');
                        
                                        $fecha1 = new DateTime($hora_asignada_fin);
                                        $fecha2 = new DateTime($hora_realizada);
                                        $diferencia = date_diff($fecha1,$fecha2);

                                        $dia = $dias[(date('N', strtotime($usertarea->created_at))) - 1];
                                        @endphp
                                          
                                          @if ($usertarea->tarea->id==$tarea->id)  
                                          
                                            @if( date("d-m-Y", $i) ==  $usertarea->created_at->format('d-m-Y') )                                                                 
                                              
                                              @php  
                                              $nrodiashecho+=1;
                                              $intermediofilas = true;
                                              $sumatotalhoras+= intval( $usertarea->created_at->format('H') );
                                              $sumatotalminutos+=intval( $usertarea->created_at->format('i') ); 
                                              @endphp                                          

                                              @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) 
                                                  <span class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif ($hora_realizada < $hora_asignada_inicio)                                             
                                                  <span class="badge badge-warning"><i class="far fa-grin-beam"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif($hora_realizada > $hora_asignada_fin)
                                                  <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>  {{$usertarea->created_at->format('H:i:s')}}</span>
                                              @endif                                            
                                              
                                              @break
                                            @endif
                                              
                                          @endif        

                                      @endforeach  
                                      @if($intermediofilas == false)
                                      <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>Sin asignar</span>
                                      @else 
                                        @php  $intermediofilas = false;  @endphp
                                      @endif
                                      </td>   
                                    @endfor                               
                                    <td class="text-center"> {{intdiv($sumatotalhoras,$cantidadDias)}} : {{intdiv($sumatotalminutos,$cantidadDias)}} </td>
                                    <td class="text-center">
                                        {{$nrodiashecho}} de {{$cantidadDias}}
                                    </td>
                                </tr>
                                @php 
                                  $nrodiashecho=0;
                                  $sumatotalhoras=0;
                                  $sumatotalminutos=0;
                                @endphp
                                @endforeach
                              </tbody>
                              
                            </table>
                          </div>
                          
                        </div>
                        <input type="button" name="next" class="next action-button" value="Siguiente" />
                        <input type="button" name="previous" class="previous action-button-previous" value="Anterior" />
                      </fieldset>

                      @php 
                      $nrodiashecho=0;
                        $sumatotalhoras=0;
                        $sumatotalminutos=0;
                      @endphp
                      <fieldset>
                        <div class="form-card">
                          <div class="row">
                            <div class="col-7">
                              @php $fecha_formateada = date('d-m-Y', strtotime($fecha)); @endphp
                              <h3 class="fs-title text-dark">Desde: {{$desde}} Hasta: {{$hasta}}</h3>
                            </div>
                          </div>
                          <div></div>
                          <div class="table-responsive">
                            <table class="table" id="table5">
                                <thead class="table-primary">
                                  <th class="text-center"> Tarea </th>
                                  <th class="text-center">Tiempo Estimado</th>                           

                                  @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    @php  $diasemana=  $dias[(date('N', strtotime( date("d-m-Y", $i) ))) - 1];  @endphp
                                    <th class="text-center"> {{$diasemana}} <br>{{date("d-m-Y", $i)}}  </th>
                                  @endfor       
                                  <th class="text-center">Tiempo Promedio</th>         
                                  <th class="text-center">Cant. Dias Realizados</th>           
                                 </thead>                             

                              <tbody>
                                @foreach ($tareas_posturno as $tarea)
                                <tr>                                 
                                    <td class="text-center bg-light"> {{$tarea->nombre}}  </td>              
                                    
                                    @php 
                                        $intermediofilas=false;
                                    @endphp

                                    @if ($tarea->hora_inicio == "" || $tarea->hora_inicio == null ||$tarea->hora_fin == "" || $tarea->hora_fin == null )
                                    <td class="text-center"> Sin hora definida</td>
                                    @else                                          
                                    <td class="text-center"> {{$tarea->hora_inicio}} a: {{$tarea->hora_fin}} </td>
                                    @endif
                                
                                    @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)
                                    <td class="text-center" >  
                                      @foreach ($tarea_user as $usertarea )                                   
                                      
                                        @php
                                        $diferencia = new DateTime();
                                        $hora_asignada_inicio= $tarea->hora_inicio ;
                                        $hora_asignada_fin= $tarea->hora_fin;
                                        $hora_realizada = $usertarea->created_at->format('H:i:s');
                        
                                        $fecha1 = new DateTime($hora_asignada_fin);
                                        $fecha2 = new DateTime($hora_realizada);
                                        $diferencia = date_diff($fecha1,$fecha2);

                                        $dia = $dias[(date('N', strtotime($usertarea->created_at))) - 1];
                                        @endphp
                                          
                                          @if ($usertarea->tarea->id==$tarea->id)  
                                          
                                            @if( date("d-m-Y", $i) ==  $usertarea->created_at->format('d-m-Y') )                                                                 
                                              
                                              @php  
                                              $nrodiashecho+=1;
                                              $intermediofilas = true;
                                              $sumatotalhoras+= intval( $usertarea->created_at->format('H') );
                                              $sumatotalminutos+=intval( $usertarea->created_at->format('i') ); 
                                              @endphp                                         

                                              @if ($hora_realizada >= $hora_asignada_inicio && $hora_realizada <= $hora_asignada_fin) 
                                                  <span class="badge badge-success"><i class="fa fa-thumbs-up"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif ($hora_realizada < $hora_asignada_inicio)                                             
                                                  <span class="badge badge-warning"><i class="far fa-grin-beam"></i> {{$usertarea->created_at->format('H:i:s')}}</span> 
                                              @elseif($hora_realizada > $hora_asignada_fin)
                                                  <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>  {{$usertarea->created_at->format('H:i:s')}}</span>
                                              @endif                                            
                                              
                                              @break                   
                                            @endif                                              
                                          @endif 

                                      @endforeach  
                                      @if($intermediofilas == false)
                                      <span class="badge badge-danger"><i class="fa fa-thumbs-down"></i>Sin asignar</span>
                                      @else 
                                        @php  $intermediofilas =false;  @endphp
                                      @endif
                                      </td>   
                                    @endfor            
                                    <td class="text-center"> {{ intdiv($sumatotalhoras,$cantidadDias) }} : {{ intdiv($sumatotalminutos,$cantidadDias) }} </td>                
                                    <td class="text-center">
                                         {{$nrodiashecho}} de {{$cantidadDias}} 
                                    </td>
                                </tr>
                                @php 
                                  $nrodiashecho=0;
                                  $sumatotalhoras=0;
                                  $sumatotalminutos=0;
                                @endphp
                                @endforeach
                              </tbody>                             
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
        @php 
            $ingreso=0;
            $preturno=0;
            $despacho = 0;
            $turno =0;
            $posturno=0;
            foreach($totalevaluados as $valor){
                if($valor->turno =='Ingreso'){
                    $ingreso=$valor->total;
                }else if($valor->turno =='Post Turno'){
                    $posturno=$valor->total;
                }else if($valor->turno =='Pre Turno'){
                    $preturno=$valor->total;
                }else if($valor->turno =='Turno'){
                    $turno=$valor->total;
                }else{
                    $despacho =$valor->total;
                }
            }
            $ingreso = ($ingreso==0)?0:  number_format( (  $ingreso / ( count($tareas_ingreso) * $cantidadDias ))*100 ,2);
            $preturno = ($preturno==0)?0: number_format( ( $preturno /(count($tareas_preturno ) * $cantidadDias) )*100 ,2);
            $despacho = ($despacho==0)?0: number_format( ( $despacho/ (count($tareas_despacho ) * $cantidadDias) )*100 ,2);
            $turno = ($turno==0)?0: number_format( ( $turno/(count($tareas_turno ) * $cantidadDias) )*100 ,2);
            $posturno = ($posturno==0)?0: number_format( ( $posturno/(count($tareas_posturno ) * $cantidadDias) )*100 ,2);
        @endphp
        
        <input type="hidden" value="{{$ingreso}}" id="ingreso">
        <input type="hidden" value="{{$preturno}}" id="preturno">
        <input type="hidden" value="{{$despacho}}" id="despacho">
        <input type="hidden" value="{{$turno}}" id="turno">
        <input type="hidden" value="{{$posturno}}" id="posturno">

        <div class="card">
          <div class="card-body">    

              <figure class="highcharts-figure">
              <div id="container"></div>
              <p class="highcharts-description">
                  Estos promedios finales  estan basados en la cantidad de dias filtradas por 
                  la cantidad de tareas de cada turno  dado que al final se divide entre la cantidad de tareas 
                  tiqueadas , finalmente multiplicadas por 100 para estimar un rango en porcentajes.
              </p>
              <button id="plain">Plano</button>
              <button id="inverted">Invertido</button>
              <button id="polar">Circular</button>
            </figure>

          </div>
        </div>
      </div>
</section>


@endsection

@section('page_js')
 <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script> 
<script>

  

</script> 

<script>
  let ingreso =Number( document.getElementById('ingreso').value);
  let despacho =Number( document.getElementById('despacho').value);
  let turno =Number( document.getElementById('turno').value);
  let posturno =Number( document.getElementById('posturno').value);
  let preturno = Number(document.getElementById('preturno').value);

  $(document).ready(function() {


    $('#table1').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _ACTIVIDADES_ registros",
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
  $('#table2').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _ACTIVIDADES_ registros",
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
  $('#table3').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _ACTIVIDADES_ registros",
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
  $('#table4').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _ACTIVIDADES_ registros",
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
  $('#table5').DataTable({
      language: {
          sProcessing: "Procesando...",
          sLengthMenu: "Mostrar _ACTIVIDADES_ registros",
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

  


  const chart = Highcharts.chart('container', {
    title: {
        text: 'Promedio por turno'
    },
    subtitle: {
        text: 'maximo 100%'
    },
    xAxis: {
        categories: ['Ingreso', 'Despacho', 'Turno', 'Posturno', 'Preturno']
    },
    yAxis:[
      {
        max:100,
        min:0
      }
    ],
    series: [{
        type: 'column',
        colorByPoint: true,
        data: [ ingreso,despacho,turno,posturno,preturno],
        showInLegend: false
    }]
  });

  
document.getElementById('plain').addEventListener('click', () => {
    chart.update({
        chart: {
            inverted: false,
            polar: false
        },
        subtitle: {
            text: 'maximo 100%'
        }
    });
});

document.getElementById('inverted').addEventListener('click', () => {
    chart.update({
        chart: {
            inverted: true,
            polar: false
        },
        subtitle: {
            text: 'maximo 100%'
        }
    });
  });

  document.getElementById('polar').addEventListener('click', () => {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'maximo 100%'
        }
    });
  });

  })

  
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
 /*  $('#table1').DataTable({
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
  }); */
</script>
@endsection

@section('page_css')

<style>
  #container {
    height: 400px;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 320px;
    max-width: 800px;
    margin: 1em auto;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid #ebebeb;
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: #555;
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tr:nth-child(even) {
    background: #f8f8f8;
}

.highcharts-data-table tr:hover {
    background: #f1f7ff;
}

</style> 

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


















