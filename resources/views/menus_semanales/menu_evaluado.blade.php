@extends('layouts.app', ['activePage' => 'MenuEvaluado', 'titlePage' => 'Reportes'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte</h3>
    </div>
    <div class="section-body">
        <div class="row">
            
            <div class="card text-white bg-primary alert">
                <div class="card-body ">
                    <div class=" mensaje">
                        <p class="leyenda text-center" >REPORTE MENU SEMANAL - {{$dia}} <br>                       
                       
                        </p>
                    </div>
                </div>
            </div>           
            @php 
            $promediosabor=0;
            $promediopresenta=0;
            @endphp

            <form id="regForm" action="/action_page.php">
                <table class="table table-hover table-responsive">
                    <thead>
                        <th>Nombre</th>
                        <th>Sabor</th>
                        <th>Presentacion</th>
                        <th>Llegada</th>
                        <th>Observacion</th>                       
                    </thead>
                    <tbody>
                @foreach($menucalificacion->menu_calificacion_detalle as  $detalle)
                        @php 
                            $promediosabor+= $detalle->sabor;
                            $promediopresenta+= $detalle->presentacion;
                        @endphp
                        <tr >                            
                            <td> {{$detalle->plato->nombre}}</td>                          
                            <td>                   
                                @php 
                                    $sabor =($detalle->sabor==1?'danger': ($detalle->sabor==2?'secondary':($detalle->sabor==3?'warning':($detalle->sabor==4?'primary':'success')) ));
                                @endphp
                                <span class="badge badge-{{$sabor}}">{{($detalle->sabor==1?'Pesimo': ($detalle->sabor==2?'Malo':($detalle->sabor==3?'Regular':($detalle->sabor==4?'Bueno':'Excelente')) ))}}</span>
                            </td>
                            <td>              
                                @php 
                                    $pres =($detalle->presentacion==1?'danger': ($detalle->presentacion==2?'secondary':($detalle->presentacion==3?'warning':($detalle->presentacion==4?'primary':'success')) ));
                                @endphp          
                                <span class="badge badge-{{$pres}}"> {{($detalle->presentacion==1?'Pesimo': ($detalle->presentacion==2?'Malo':($detalle->presentacion==3?'Regular':($detalle->presentacion==4?'Bueno':'Excelente')) ))}} </span>                    
                            </td>
                            <td>
                                @if($detalle->estado == 'Llego')
                                <span class="badge badge-pill badge-success">Llego</span>
                                @else
                                <span class="badge badge-pill badge-danger">No LLego</span>
                                @endif
                            </td>
                            <td>                                
                                <p>
                                    {{$detalle->observacion}}
                                </p>
                            </td>   
                        </tr>
                        @endforeach
                        <tr>
                            <td class="text-center">Promedio Final <span class="badge badge-success">(Max:5)</span></td>
                            <td>{{$promediosabor/$cantidad}} %</td>
                            <td>{{$promediopresenta/$cantidad}} %</td>
                            <td colspan="1"></td>
                            <td colspan="2" class="text-right">  {{  (($promediosabor/$cantidad)+($promediopresenta/$cantidad))/2 }} %  </td>
                        </tr>
                    </tbody>
                </table>
                <BR><br>
                <a href="{{route('menus_semanales.reporteMenu')}}" type="button" class="btn btn-success">Volver a calificaciones</a>
            </form>
      
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
</script>
@section('page_js')
<script>
    let radios = document.getElementsByClassName("form-check-input");
    let registrar = document.getElementById("registrar");
    let user_id = document.getElementById("user_id");
    let user_id_evaluado = document.getElementById("usuarioevaluado_id");
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
        let calificados = document.getElementById('calificadoSiNo').value;
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

        if(Number(calificados)>0){
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
    var currentTab = 0;
    showTab(currentTab);

    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";

        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = "Siguiente";

        } else {
            document.getElementById("nextBtn").innerHTML = "Siguiente";
        }
        fixStepIndicator(n)
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("tab");
        if (currentTab > x.length) {
            console.log("cerro " + currentTab);
            // ... the form gets submitted:
            return false;
        }
        // This function will figure out which tab to display

        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        console.log(currentTab)
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...

        // Otherwise, display the correct tab:
        showTab(currentTab);
    }

    function validateForm() {
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        for (i = 0; i < y.length; i++) {
            if (y[i].value == "") {
                y[i].className += " invalid";
                valid = false;
            }
        }
        if (valid) {
            document.getElementsByClassName("step")[currentTab].className += " finish";
        }
        return valid; // return the valid status
    }

    function fixStepIndicator(n) {
        // This function removes the "active" class of all steps...
        var i, x = document.getElementsByClassName("step");
        for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
        }
        //... and adds the "active" class on the current step:
        x[n].className += " active";
    }
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