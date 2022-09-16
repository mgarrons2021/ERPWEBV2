      <div class="card">
         <div class="card-header">
             <p style="float: right;">
                 RESULTADOS, @php $fecha_formateada = strtoupper(\Carbon\Carbon::parse($fecha)->isoFormat('dddd, D MMMM Y')); @endphp
                 {{$fecha_formateada}}
             </p>
         </div>
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-bordered">
                     <thead>
                         <th class="text-center">Comunicación (Amabilidad)</th>
                         <th class="text-center">Coordinación (Orden y limpieza)</th>
                         <th class="text-center">Cooperación</th>
                         <th class="text-center">Conocimiento (Cumplimiento)</th>
                         <th class="text-center">Compromiso</th>
                         <th class="text-center">Carisma al cliente</th>
                     </thead>
                     <tbody>
                         @php $contador = 0; $suma = 0; @endphp
                         @foreach($evaluaciones_user as $evaluacion_user)
                         @if($evaluacion_user->evaluacion->categoria == 'comunicacion' )
                         @php
                         $contador ++;
                         $suma += $evaluacion_user->puntaje;
                         @endphp
                         @endif
                         @endforeach
                         @php $equilibrio = 5 * $contador;
                         if($equilibrio != 0){
                         $dato = (($suma * 100)/$equilibrio);
                         }else{
                         $dato = 0;
                         }
                         @endphp
                         @if($dato >= 80)
                         <td class="text-center table-success"> {{ number_format($dato, 2)}}%</td>
                         @elseif($dato > 30 && $dato < 80) <td class="text-center table-light"> {{ number_format($dato, 2)}}%</td>
                             @else
                             <td class="text-center table-danger"> {{ number_format($dato, 2)}}%</td>
                             @endif


                             @php $contador = 0; $suma = 0; @endphp
                             @foreach($evaluaciones_user as $evaluacion_user)
                             @if($evaluacion_user->evaluacion->categoria == 'coordinacion' )
                             @php
                             $contador ++;
                             $suma += $evaluacion_user->puntaje;
                             @endphp
                             @endif
                             @endforeach
                             @php $equilibrio = 5 * $contador;
                             if($equilibrio != 0){
                             $dato = (($suma * 100)/$equilibrio);
                             }else{
                             $dato = 0;
                             }
                             @endphp
                             @if($dato >= 80)
                             <td class="text-center table-success"> {{ number_format($dato, 2)}}%</td>
                             @elseif($dato > 30 && $dato < 80) <td class="text-center  table-light"> {{ number_format($dato, 2)}}%</td>
                                 @else
                                 <td class="text-center table-danger"> {{ number_format($dato, 2)}}%</td>
                                 @endif



                                 @php $contador = 0; $suma = 0; @endphp
                                 @foreach($evaluaciones_user as $evaluacion_user)
                                 @if($evaluacion_user->evaluacion->categoria == 'cooperacion' )
                                 @php
                                 $contador ++;
                                 $suma += $evaluacion_user->puntaje;
                                 @endphp
                                 @endif
                                 @endforeach
                                 @php $equilibrio = 5 * $contador;
                                 if($equilibrio != 0){
                                 $dato = (($suma * 100)/$equilibrio);
                                 }else{
                                 $dato = 0;
                                 }
                                 @endphp

                                 @if($dato >= 80)
                                 <td class="text-center table-success"> {{ number_format($dato, 2)}}%</td>
                                 @elseif($dato > 30 && $dato < 80) <td class="text-center table-light"> {{ number_format($dato, 2)}}%</td>
                                     @else
                                     <td class="text-center table-danger"> {{ number_format($dato, 2)}}%</td>
                                     @endif

                                     @php $contador = 0; $suma = 0; @endphp
                                     @foreach($evaluaciones_user as $evaluacion_user)
                                     @if($evaluacion_user->evaluacion->categoria == 'conocimiento' )
                                     @php
                                     $contador ++;
                                     $suma += $evaluacion_user->puntaje;
                                     @endphp
                                     @endif
                                     @endforeach
                                     @php $equilibrio = 5 * $contador;
                                     if($equilibrio != 0){
                                     $dato = (($suma * 100)/$equilibrio);
                                     }else{
                                     $dato = 0;
                                     }
                                     @endphp

                                     @if($dato >= 80)
                                     <td class="text-center table-success"> {{ number_format($dato, 2)}}%</td>
                                     @elseif($dato > 30 && $dato < 80) <td class="text-center table-light"> {{ number_format($dato, 2)}}%</td>
                                         @else
                                         <td class="text-center table-danger"> {{ number_format($dato, 2)}}%</td>
                                         @endif

                                         @php $contador = 0; $suma = 0; @endphp
                                         @foreach($evaluaciones_user as $evaluacion_user)
                                         @if($evaluacion_user->evaluacion->categoria == 'compromiso' )
                                         @php
                                         $contador ++;
                                         $suma += $evaluacion_user->puntaje;
                                         @endphp
                                         @endif
                                         @endforeach
                                         @php $equilibrio = 5 * $contador;
                                         if($equilibrio != 0){
                                         $dato = (($suma * 100)/$equilibrio);
                                         }else{
                                         $dato = 0;
                                         }
                                         @endphp

                                         @if($dato >= 80)
                                         <td class="text-center table-success"> {{ number_format($dato, 2)}}%</td>
                                         @elseif($dato > 30 && $dato < 80) <td class="text-center table-light "> {{ number_format($dato, 2)}}%</td>
                                             @else
                                             <td class="text-center table-danger"> {{ number_format($dato, 2)}}%</td>
                                             @endif

                                             @php $contador = 0; $suma = 0; @endphp
                                             @foreach($evaluaciones_user as $evaluacion_user)
                                             @if($evaluacion_user->evaluacion->categoria == 'carisma al cliente' )
                                             @php
                                             $contador ++;
                                             $suma += $evaluacion_user->puntaje;
                                             @endphp
                                             @endif
                                             @endforeach
                                             @php $equilibrio = 5 * $contador;
                                             if($equilibrio != 0){
                                             $dato = (($suma * 100)/$equilibrio);
                                             }else{
                                             $dato = 0;
                                             }
                                             @endphp
                                             @if($dato >= 80)
                                             <td class="text-center table-success"> {{ number_format($dato, 2)}}%</td>
                                             @elseif($dato > 30 && $dato < 80) <td class="text-center table-light"> {{ number_format($dato, 2)}}%</td>
                                                 @else
                                                 <td class="text-center table-danger"> {{ number_format($dato, 2)}}%</td>
                                                 @endif
                     </tbody>
                 </table>
             </div>
         </div>
     </div>