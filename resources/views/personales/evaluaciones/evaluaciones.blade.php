@extends('layouts.app', ['activePage' => 'categorias', 'titlePage' => 'Categorias'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Evaluar funcionarios</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card text-white bg-primary alert">
                <div class="card-body ">
                    <div class=" mensaje">
                        <p class="leyenda text-center"> Parametro de medición (Expectativas): <br> 
                            Donde 1 = Muy por debajo, &nbsp
                            2 = Ligeramente por debajo,&nbsp
                            3 = Cumple,&nbsp
                            4 = Por encima,&nbsp
                            5 = Muy por encima.&nbsp
                        </p>
                    </div>
                </div>
            </div>

            <form id="regForm" action="/action_page.php">
                <form action="{{ route('personales.guardarEvaluaciones',$user_login)}}" method="POST" class="form-horizontal">
                    @csrf
                    @method('POST')

                    <div class="tab">
                    <h5 style="float:right"> Pag. 1/7</h5>
                        <h4>Seleccione el usuario a ser evaluado:</h4>
                        <p> El funcionario evaluado debe pertencer a su equipo</p>
                        <br>
                        <p><select name="usuarioevaluado_id" class="form-control" id="usuarioevaluado_id" style="width: 100%">
                                <option value=""> Seleccione</option>
                                @foreach($usuarios as $usuario)
                                <option value="{{$usuario->id}}"> {{$usuario->name}} {{$usuario->apellido}}</option>
                                @endforeach
                            </select></p>
                    </div>
                    <div class="tab">
                        <h5 style="float:right"> Pag. 2/7</h5>
                        <h4>Comunicacion: (Amabilidad)</h4> <br>
                        <input type="hidden" id="user_id" name="user_id" value="{{$user_login}}">
                        @foreach($evaluaciones as $evaluacion)
                        @if($evaluacion->categoria == 'comunicacion')
                        <div class="card text-center cardg">
                            <div class="card-header bg-light">
                              <p class="nombre_evaluacion"> {{$evaluacion->nombre}}</p> &nbsp <p class="required"> * </p>
                            </div>
                            <p></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="1" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio1">1 </label>
                            </div>

                            <div class="form-check form-check-inline" align="center">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="2" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">2 </label>
                            </div>
                            <div class="form-check form-check-inline" align="center">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="3" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline" align="center">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="4" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">4 </label>
                            </div>
                            <div class="form-check form-check-inline" align="center">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="5" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">5 </label>
                            </div> <br><br>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="tab">
                        <h5 style="float:right">Pag. 3/7</h5>
                        <h4>Coordinacion: (Orden y limpieza)</h4> <br>
                        @foreach($evaluaciones as $evaluacion)
                        @if($evaluacion->categoria == 'coordinacion')
                        <div class="card text-center">
                            <div class="card-header bg-light">
                                <p class="nombre_evaluacion"> {{$evaluacion->nombre}}</p> &nbsp <p class="required"> * </p>
                            </div>
                            <p></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="1" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio1">1 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="2" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">2 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="3" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="4" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">4 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="5" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">5 </label>
                            </div> <br><br>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="tab">
                        <h5 style="float:right">Pag. 4/7</h5>
                        <h4>Cooperación:</h4> <br>
                        @foreach($evaluaciones as $evaluacion)
                        @if($evaluacion->categoria == 'cooperacion')
                        <div class="card text-center">
                            <div class="card-header bg-light">
                                <p class="nombre_evaluacion"> {{$evaluacion->nombre}}</p> &nbsp <p class="required"> * </p>
                            </div>
                            <p></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="1" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio1">1 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="2" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">2 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="3" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="4" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">4 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="5" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">5 </label>
                            </div> <br><br>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="tab">
                        <h5 style="float:right">Pag. 5/7</h5>
                        <h4>Conocimiento: (Cumplimiento)</h4> <br>
                        @foreach($evaluaciones as $evaluacion)
                        @if($evaluacion->categoria == 'conocimiento')
                        <div class="card text-center">
                            <div class="card-header bg-light">
                                <p class="nombre_evaluacion"> {{$evaluacion->nombre}}</p> &nbsp <p class="required"> * </p>
                            </div>
                            <p></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="1" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio1">1 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="2" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">2 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="3" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="4" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">4 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="5" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">5 </label>
                            </div> <br><br>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    <div class="tab">
                        <h5 style="float:right">Pag. 6/7</h5>
                        <h4>Compromiso:</h4> <br>
                        @foreach($evaluaciones as $evaluacion)
                        @if($evaluacion->categoria == 'compromiso')
                        <div class="card text-center">
                            <div class="card-header bg-light">
                                <p class="nombre_evaluacion"> {{$evaluacion->nombre}}</p> &nbsp <p class="required"> * </p>
                            </div>
                            <p></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="1" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio1">1 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="2" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">2 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="3" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="4" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">4 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="5" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">5 </label>
                            </div> <br><br>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <div class="tab">
                        <h5 style="float:right">Pag. 7/7</h5>
                        <h4>Carisma al cliente:</h4> <br>
                        @foreach($evaluaciones as $evaluacion)
                        @if($evaluacion->categoria == 'carisma al cliente')
                        <div class="card text-center">
                            <div class="card-header bg-light">
                                <p class="nombre_evaluacion"> {{$evaluacion->nombre}}</p> &nbsp <p class="required"> * </p>
                            </div>
                            <p></p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="1" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio1">1 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="2" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">2 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="3" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">3 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="4" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">4 </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="evaluacion-{{$evaluacion->id}}" id="5" value="{{$evaluacion->id}}">
                                <label class="form-check-label" for="inlineRadio3">5 </label>
                            </div> <br><br>
                        </div>

                        @endif
                        @endforeach
                    </div>

                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:40px;">
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                        <span class="step"></span>
                    </div>
                </form>

            </form>
            <div align="center"> <br>
                <div style="">
                    <button type="button" class="btn btn-danger" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Siguiente2</button>
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
$(document).ready(function() {
    $('#usuarioevaluado_id').select2();
});
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
        let evaluacionesid = [];
        let valor_evaluacion = [];
        let valor = [];
        //alert('click')
        for (let i in radios) {
            if (radios[i].checked == true) {
                evaluacionesid.push(parseInt(radios[i].value));
                valor_evaluacion.push(parseInt(radios[i].id));
            }

        }
        //console.log(evaluacionesid);

        fetch('{{ route('personales.guardarEvaluaciones', '') }}/' + user_id.value, {
                method: "POST",
                body: JSON.stringify({
                    evaluaciones_id: evaluacionesid,
                    user_id: user_id.value,
                    user_id_evaluado: user_id_evaluado.value,
                    valor_evaluacion: valor_evaluacion, 
                }),
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-Token": csrfToken,
                    },
                })
            .then((response) => {
                return response.json();
                console.log(response)
            })
            .then((data) => {
                if (data.success == true) {
                    iziToast.success({
                        title: 'SUCCESS',
                        message: "Registro agregado exitosamente",
                        position: 'topRight',
                        timeout: 1500,
                        onClosed: function() {
                            window.location.reload();
                        }

                    });
                }
                if (data.success == false) {
                    iziToast.error({
                        title: 'ERROR!',
                        message: "Verifique los datos ingresados e intente nuevamente",
                        position: 'topRight',
                        timeout: 1500,
                        onClosed: function() {
                            window.location.reload();
                        }

                    });

                }

            })
            .catch((error) => console.error(error));

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
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
            // ... the form gets submitted:
            return false;
        }
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
    .required{
        color:red;
    }
    .nombre_evaluacion{
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