@extends('layouts.app', ['activePage' => 'formulario', 'titlePage' => 'Formulario'])

@section('content')
@section('css')
@endsection

<section class="section">

    <div class="section-header">
        <h3 class="page__heading">Reporte de Ventas </h3>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: hidden">
                            <form action="{{route('autorizacion.reporteVentas')}}" method="GET">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">    
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicio" value="" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
    
                                        <div class="input-daterange input-group" id="datepicker">
                                            <span class="input-group-addon "><strong>A:</strong> </span>
                                            <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_fin" value="" />
                                        </div>
                                    </div>
    
                                </div>
                                <div class="card-footer">
                                    <div class="col-md-4" style="margin: 0 auto;">
                                        <input class="form-control btn btn-primary" type="submit" value="Filtrar" id="filtrar" name="filtrar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">                
                    
                        <div class="table-responsive">

                            @php
                                $fechaInicio=strtotime($fecha_inicio);
                                $fechaFin=strtotime($fecha_fin);      
                                $ventaAmFila = array();
                                $ventasColumnas = array();
                                $sumaP = array();
                                $sumaSucursalFila=array();
                            @endphp

                            <table class="table" id="table">
                                <thead style="background-color: #6777ef;">                                    
                                        <th style="color: #fff;">Sucursal</th>
                                        <th style="color: #fff;">Turno</th>
                                        @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)                                            
                                            <th style="color: #fff;">{{date("d-m-Y", $i)}}</th> 
                                            @php  array_push($sumaP,0);  @endphp
                                        @endfor                                                                 
                                        <th style="color: #fff;">Total</th>                                    
                                </thead>                        
                                <tbody>                                  

                                    @php             
                                        $esfila=true;
                                        $filafaltante=false;
                                        $aux=0;
                                    @endphp
                                    
                                    @foreach( $sucursales as $sucursal )   
                                        <tr>   
                                            <td rowspan="4">{{$sucursal->nombre}}</td>                                       
                                        </tr> 
                                        @php 
                                            array_push($sumaSucursalFila,[0,0]);
                                            array_push($ventasColumnas,[0]);
                                        @endphp
                                        @for ($j=0; $j < 2; $j++)          
                                            @php  $aux = 0; @endphp   
                                            @for($i=$fechaInicio; $i<=$fechaFin; $i+=86400)

                                                @php                                          
                                                    $fecha = date( 'Y-m-d' , $i );   
                                                @endphp                                                

                                                @if( sizeof($venta)>0 )

                                                    @foreach( $venta as $miventa )
                                                        
                                                        @if($esfila)         
                                                        <tr>                                                                                                  
                                                            <td> {{ $j==0?'AM':'PM' }} </td>
                                                            @php  $esfila=false;  @endphp                          
                                                        @endif      
                                                        
                                                        @if( $sucursal->id == $miventa->sucursal_id ) 
                                                            @if( $fecha == $miventa->fecha_venta )                                                                  
                                                                @if( $miventa->turno==0 && $j==0 )                                                                                            
                                                                    <td>{{ number_format($miventa->total,2)}}</td>                                     
                                                                    @php 
                                                                        $sumaP[$aux] = ( $miventa->total + $sumaP[$aux] );
                                                                        $sumaSucursalFila[sizeof($sumaSucursalFila)-1][0] = ($miventa->total+$sumaSucursalFila[sizeof($sumaSucursalFila)-1][0]);
                                                                        array_shift($venta);
                                                                    @endphp              
                                                                @elseif( $miventa->turno==1 && $j==1)                                              
                                                                    <td>{{ number_format($miventa->total,2)}}</td>                                                          
                                                                    @php 
                                                                        $sumaP[$aux] = ( $miventa->total + $sumaP[$aux] );
                                                                        $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1] = ( $miventa->total+$sumaSucursalFila[sizeof($sumaSucursalFila)-1][1]);
                                                                        array_shift($venta);
                                                                    @endphp 
                                                                @else
                                                                                                                                                                                    
                                                                @endif
                                                            @else
                                                                <td>0</td>                                                            
                                                            @endif

                                                            @if( $i == $fechaFin && $j==1 )
                                                                    <td >{{ number_format( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1],2 ) }}</td> 
                                                                </tr>   
                                                                <tr class="table-warning">     
                                                                    <td>Total</td>
                                                                    @php $ventasColumnas[sizeof($ventasColumnas)-1][0]=$sumaP; @endphp
                                                                    @for( $ij=0;$ij< sizeof($sumaP) ;$ij++)
                                                                        <td>{{  number_format( $sumaP[$ij],2 )}}</td>
                                                                        @php                                                                         
                                                                        $sumaP[$ij] =0;
                                                                        @endphp                                                                        
                                                                    @endfor
                                                                    <td>{{  number_format( ( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1]+$sumaSucursalFila[sizeof($sumaSucursalFila)-1][0]) ,2)}}</td> 
                                                                
                                                                </tr>          
                                                                @php  $esfila=true;  @endphp
                                                                @break
                                                            @elseif($i == $fechaFin)   
                                                                    <td >{{ number_format( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][0],2 )}}</td>   
                                                                </tr>
                                                                @php  $esfila=true;  @endphp
                                                                @break
                                                            @else
                                                                @break
                                                            @endif

                                                        @else

                                                            @if( $i == $fechaFin && $j==1 )
                                                                <td>0</td>
                                                                <td > {{ number_format( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1] , 2)}} </td>  
                                                                </tr>   
                                                                <tr class="table-warning">     
                                                                    <td>Total</td>
                                                                    @php $ventasColumnas[sizeof($ventasColumnas)-1][0]=$sumaP; @endphp
                                                                    @for( $ij=0;$ij < sizeof($sumaP);$ij++)
                                                                        <td> {{  number_format( $sumaP[$ij],2 )}}</td>
                                                                        @php                                                                         
                                                                        $sumaP[$ij] =0;
                                                                        @endphp                                                                                     
                                                                    @endfor  
                                                                    <td>{{  number_format( ( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1]+$sumaSucursalFila[sizeof($sumaSucursalFila)-1][0]) ,2)}}</td>
                                                                </tr>          
                                                                @php  $esfila=true;  @endphp
                                                                @break
                                                            @elseif($i == $fechaFin) 
                                                                    <td>0</td>  
                                                                    <td > {{ number_format( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][0],2 )}} </td>      
                                                                </tr>
                                                                @php  $esfila=true;  @endphp
                                                                @break
                                                            @else
                                                                <td>0</td> 
                                                                @php $filafaltante=true; @endphp
                                                                @break
                                                            @endif
                                                            
                                                        @endif

                                                    @endforeach
                                                @else          

                                                    @if($j==0 && $i==$fechaInicio) 
                                                        <tr>                                                                                                  
                                                            <td> AM </td>
                                                            <td>0</td>
                                                    @elseif( $j==1  )       
                                                        @if($i==$fechaInicio)
                                                            @php  //la linea de abajo creo da un bug, por ahora testearlo 
                                                            @endphp
                                                            <td > {{ number_format( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][0] ,2) }} </td>  
                                                        </tr>
                                                        <tr>                                                                                                                      
                                                            <td> PM </td>   
                                                            <td>0</td>
                                                        @else
                                                            <td>0</td> 
                                                        @endif    

                                                        @if($i == $fechaFin && $j==1 )
                                                            
                                                            <td >{{ number_format( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1] ,2 ) }}</td>      
                                                        </tr>     
                                                        <tr class="table-warning">       
                                                            <td>Total</td>  
                                                            @php $ventasColumnas[sizeof($ventasColumnas)-1][0]=$sumaP; @endphp
                                                            @for( $ij=0;$ij< sizeof($sumaP);$ij++)
                                                                <td> {{ number_format( $sumaP[ $ij ],2 ) }} </td>  
                                                                @php                                                                          
                                                                    $sumaP[$ij] = 0;
                                                                @endphp                                                                                              
                                                            @endfor                         
                                                            <td>{{  number_format( ( $sumaSucursalFila[sizeof($sumaSucursalFila)-1][1]+$sumaSucursalFila[sizeof($sumaSucursalFila)-1][0]) ,2)}}</td>        
                                                        </tr>                                                                                                          
                                                        @endif
                                                    @else
                                                        <td>0</td>
                                                    @endif

                                                @endif                                                         
                                                @php  $aux+=1; @endphp
                                            @endfor

                                        @endfor
                                                                                
                                    @endforeach 

                                    <tr class="table-success">                                        
                                        <td colspan="2">Totales</td>
                                        @php  
                                        $totales=array();   
                                        for($iii=0;$iii< sizeof($ventasColumnas) ;$iii++){
                                            if($iii == 0 ){
                                                for($ie=0;$ie < sizeof( $ventasColumnas[$iii][0] );$ie++){
                                                    array_push($totales,$ventasColumnas[$iii][0][$ie]);
                                                }
                                            }else{
                                                for($ie=0;$ie < sizeof( $ventasColumnas[$iii][0] );$ie++){
                                                    $totales[$ie]=($ventasColumnas[$iii][0][$ie]+$totales[$ie]);
                                                }
                                            }
                                        }
                                        $fintotal= 0 ;
                                        @endphp
                                        @for($ijk= 0 ; $ijk < sizeof($totales);$ijk++)
                                            <td> {{ number_format($totales[$ijk],2) }}</td>
                                            @php  $fintotal+=$totales[$ijk]; @endphp
                                        @endfor
                                        <td>{{ number_format($fintotal,2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

@endsection

@section('page_js')

<script>
  $(document).ready(function() {
    $('#table').DataTable({
      language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _VENTAS_ registros",
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
      
      
    });
  })
</script>

@endsection

@section('css')
.titulo{
font-size: 50px;
background-color: red;
}

@endsection
@section('page_css')
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap4.min.css" />
@endsection