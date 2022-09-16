@extends('layouts.app', ['activePage' => 'reportesMenu', 'titlePage' => 'Reportes'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card text-white alert">
                <form action="{{route('menus_semanales.reporteMenu')}}" method="GET">
                    <div class="row ">
                        <div class="col-lg-12">
                            <h5 class="text-light">Seleccione el dia :</h5>
                            @csrf
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <select class="form-control" id="dia" name="dia">
                                        <option selected>Selecciona una opcion ...</option>
                                        <option value="LUNES">LUNES</option>
                                        <option value="MARTES">MARTES</option>
                                        <option value="MIERCOLES">MIERCOLES</option>
                                        <option value="JUEVES">JUEVES</option>
                                        <option value="VIERNES">VIERNES</option>
                                        <option value="SABADO">SABADO</option>
                                        <option value="DOMINGO">DOMINGO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <button type="sumbit" class="btn btn-info float-left" id="filtrar">Filtrar</button>
                                <a  class="btn btn-success float-none" id="" href='{{route("menus_semanales.menuGeneral")}}'>Ver todos</a>

                                <a class="btn btn-info float-right {{ ($cantidad>0?'':'disabled') }}" href="{{ route('menus_semanales.verEvaluados',($menucalificacion->id==null?0:$menucalificacion->id ) )}}"  id="ver" >Ver evaluacion</a>
                            </div>                                      
                        </div>
                    </div>
                </form>
            </div>
            <div class="card text-white bg-primary alert">
                <div class="card-body ">
                    <div class=" mensaje">
                        <p class="leyenda text-center" >REPORTE MENU SEMANAL - {{$fecha_actual}}  - SUCURSAL :  {{ $user->sucursals[0]->nombre}} <br>
                        <p class="text-center">1: Pesimo   2: Malo   3:Regular   4:Bueno   5:Excelente</p>
                        <input  type="hidden"   value="{{(is_null($menu_semanal[0])?0:$menu_semanal[0]->id)}}" id="menusemanal"  />
                        <input  type="hidden" value="{{$cantidad}}"  id="calificadoSiNo"/>
                        </p>
                    </div>
                </div>
            </div>
            @php 
                $items =  (is_null($menu_semanal[0])==false ? number_format( (count($menu_semanal[0]->detalle_menus_semanales)/2) ) : 0 );
                $clase='';
            @endphp
            <form id="regForm" action="/action_page.php">
            <table class="table table-hover table-responsive ">
                <thead>
                    <th>Nombre</th>
                    <th>Sabor</th>
                    <th>Presentacion</th>
                    <th>Llegada</th>
                    <th>Observacion</th>
                    <th></th>
                </thead>
                <tbody>
                    @if( $cantidad>0 )
                    <tr>
                        <td  colspan="6" class="bg-success text-center text-dark">
                            MENU EVALUADO
                        </td>
                    </tr>
                    @endif
                @foreach($detalle_menu as $index => $detalle)
                    @if(is_null($menu_semanal[0]) == false)
                        @if( $menu_semanal[0]->id == $detalle->menu_semanal_id && $fecha_actual == $detalle->menu_semanal->dia )                        
                            <tr>                                      
                                <td scope="row">{{$detalle->plato->nombre}}</td>
                                <td>
                                    <div class="form-group">                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sabor-{{$detalle->id}}" value="1">
                                            <label class="form-check-label" for="inlineRadio1">1 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sabor-{{$detalle->id}}" value="2">
                                            <label class="form-check-label" for="inlineRadio3"> 2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sabor-{{$detalle->id}}" value="3">
                                            <label class="form-check-label" for="inlineRadio3">3 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sabor-{{$detalle->id}}" value="4">
                                            <label class="form-check-label" for="inlineRadio3">4 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sabor-{{$detalle->id}}" value="5">
                                            <label class="form-check-label" for="inlineRadio3">5 </label>
                                        </div>                                                            
                                    </div>
                                </td>
                                <td>
                                    <div class="form-group">                                    
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="presentacion-{{$detalle->id}}" value="1">
                                            <label class="form-check-label" for="inlineRadio1">1 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="presentacion-{{$detalle->id}}" value="2">
                                            <label class="form-check-label" for="inlineRadio3">2 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="presentacion-{{$detalle->id}}" value="3">
                                            <label class="form-check-label" for="inlineRadio3">3 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="presentacion-{{$detalle->id}}" value="4">
                                            <label class="form-check-label" for="inlineRadio3">4 </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="presentacion-{{$detalle->id}}" value="5">
                                            <label class="form-check-label" for="inlineRadio3">5 </label>
                                        </div> 
                                    </div>
                                </td>
                                <td>
                                   <select class="form-control llegada custom-select" id="llegada-{{$detalle->id}}">
                                        <option  value="" selected >Selecciona una opcion...</option>
                                        <option value="Llego">Llego</option>
                                        <option value="No llego">No llego</option>
                                    </select>
                                </td>
                                <td>
                                    <textarea class=" observacion" id="observacion-{{$detalle->id}}"  rows="5" cols="15"></textarea>
                                </td>
                                <td>
                                    <input  type="hidden" value="{{$detalle->plato->id}}" class="platos"/> 
                                    <p class="text-left text-danger d-none" id="error-{{$detalle->id}}"> <i class="fas fa-exclamation-triangle"  style='font-size:36px;color:red'></i></p>
                                </td>                                                                                   
                            </tr>
                        @endif
                    @else
                        @break
                    @endif
                @endforeach
                </tbody>
            </table>
            </form>
            <div align="center"> <br>
                <div>                     
                    <button type="button" class="btn btn-success" id="registrar"> Registrar </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    let ruta_index= "{{route('menus_semanales.reporteMenu')}}";
</script>
@section('page_js')
<script>
    
    let radios = document.getElementsByClassName("form-check-input");
    let registrar = document.getElementById("registrar");
    let user_id = document.getElementById("user_id");
    let user_id_evaluado = document.getElementById("usuarioevaluado_id");
    let calificados = document.getElementById('calificadoSiNo');
    /*  let valorEvaluacion = document.getElementsByClassName("evaluacion"); */
    //console.log(valorEvaluacion.value);
    const csrfToken = document.head.querySelector(
        "[name~=csrf-token][content]"
    ).content;    

    registrar.addEventListener("click", (e) => {
        let idmenusemanal =document.getElementById('menusemanal').value;
        let id=0;
        let paso = document.getElementsByClassName('step').length;
        let objetos=document.getElementsByClassName('llegada');
        let observaciones=document.getElementsByClassName('observacion');
        let platos =  document.getElementsByClassName('platos');
       
        let llegada=objetos.length;    
        let sabores='';
        let presentaciones = '';

        let sabor='';
        let presentacion='';
        let tipollegada='';
        let observacion ='';  

        let evaluados=[];
        let vacios =false;
        let idplato=0;

        if(Number(calificados.value)>0){
            iziToast.info({
                title: "INFORMACION",
                message: "Este menu ya se encuentra evaluado",
                position: "topCenter",
                timeout: 1500,
            });
            return;
        }  
        
        for (let index = 0; index < llegada; index++) {

            id= objetos[index].id.substr( (objetos[index].id.search('-')+1)  );
            tipollegada=objetos[index].value;
            observacion = observaciones[index].value;
            idplato = platos[index].value;

            sabores=document.getElementsByName('sabor-'+id);            
            for (var i = 0; i <  sabores.length; i++) {
                if (sabores[i].checked) {
                    sabor = sabores[i].value;
                    break;
                }
            }

            presentaciones=document.getElementsByName('presentacion-'+id);
            for (var i = 0; i <  presentaciones.length; i++) {
                if (presentaciones[i].checked) {
                    presentacion = presentaciones[i].value;
                    break;
                }
            }

            evaluados.push({
                id:idplato,
                tipollegada:tipollegada,
                observacion:observacion,
                sabor:sabor,
                presentacion:presentacion
            });

            if( sabor == '' || presentacion == '' || tipollegada == '' || observacion == '' ){
                $("#error-"+id+"").removeClass("d-none");
                vacios=true;              
            }else{
                $("#error-"+id+"").addClass("d-none");
            }                                         
            tipollegada = '';
            observacion = '';
            sabor = '';
            idplato=0;
            presentacion='';
        }

        if(!vacios && evaluados.length>0){
            fetch("{{ route('menus_semanales.agregarCalificacion') }}", {
                    method: "POST",
                    body: JSON.stringify({
                    idMenusemanal:idmenusemanal,                    
                    lista:evaluados
                    }),
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": csrfToken,
                    },
            })                                                       
            .then((response) => { 
                return response.json();                                                                      
            }).then((e)=>{                                                                      
                if(e.success){
                    iziToast.success({
                        title: "PERFECTO",
                        message:
                            "El producto se califico correctamente . . . ",
                        position: "topCenter",
                        timeout: 1200,
                        onClosed:function(){
                            window.location.href=ruta_index;
                        }
                        
                    });

                }else{
                    iziToast.warnning({
                        title: "ERROR",
                        message:
                            "Problemas al añadir la calificacion . . . ",
                        position: "topCenter",
                        timeout: 1200,
                        
                    });

                }
            }).catch((err)=>{
                console.log(err);
            })

       }else if(evaluados.length==0){
            iziToast.warning({
                title: "WARNING",
                message: "Sin menu a evaluar",
                position: "topCenter",
                timeout: 1500,
            });
       }
       else{
            iziToast.warning({
                title: "WARNING",
                message: "Debe rellenar absolutamente todos los campos para guardar de forma inmediata",
                position: "topCenter",
                timeout: 2000,
            });
       }
    });


</script>
<script>
   

  
</script>

@endsection
@endsection

@section('page_css')
<style>
    .p-titulo {
        font-size: 20px;
    }

    .leyenda {
        font-size: 15px;
        /* font-weight: bold; */
        /*  color: #6777EF; */

    }

    .alert {
        margin: 5px auto;
        padding: 40px;
        width: 80%;
        min-width: 300px;
        opacity: 0.8;
    }

    .mensaje {

        align-content: center;
    }

    .required {
        color: red;
    }

    .nombre_evaluacion {
        font-size: 15px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        background-color: #f1f1f1;
    }

    #regForm {
        background-color: #ffffff;
        margin: 5px auto;
        padding: 40px;
        width: 80%;
        min-width: 300px;
    }

    h1 {
        text-align: center;
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    input.invalid {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
        align-content: center;
    }

    .button-save {
        background-color: #04AA6D;
    }

    button:hover {
        opacity: 0.8;
    }

    .step.active {
        opacity: 1;
        background-color: #6777EF;
    }
</style>
@endsection