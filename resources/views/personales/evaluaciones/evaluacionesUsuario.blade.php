@extends('layouts.app',['activePage' => 'home', 'titlePage' => 'Home'])
@section('css')
@endsection
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Evaluaciones de: {{$user->name}} {{$user->apellido}}</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                @include('personales.evaluaciones.recursos.filtrar_fechas')
            </div>
            <div class="col-lg-12">
                @include('personales.evaluaciones.recursos.resultados')
            </div>
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#collapseBonos" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-lg"></i>
                        </a>
                        <h4> &nbsp Detalles </h4>
                    </div>
                    <div class="collapse" id="collapseBonos">
                        <div class="card-body">
                            @include('personales.evaluaciones.recursos.criterios')
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('scripts')
<script>
    var currentTab = 0;
    document.addEventListener("DOMContentLoaded", function(event) {
        showTab(currentTab);
    });

    function showTab(n) {
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
        } else {
            document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
            document.getElementById("nextBtn").innerHTML = 'Siguiente';
        } else {
            document.getElementById("nextBtn").innerHTML = 'Siguiente';
        }
        /*  fixStepIndicator(n) */
    }

    function nextPrev(n) {
        var x = document.getElementsByClassName("tab");
        if (n == 1 && !validateForm()) return false;
        x[currentTab].style.display = "none";
        currentTab = currentTab + n;
        if (currentTab >= x.length) {
            document.getElementById("all-steps").style.display = "none";
            document.getElementById("register").style.display = "none";
        }
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
        return valid;
    }
</script>

@endsection
@section('page_css')
<style>
    .leyenda {
        font-size: 15px;
    }
.color{
  background-color:#DE9A42 ; 
}
    body {
        background: #eee
    }

    #regForm {
        width: 100%;
    }

    #register {

        color: #6A1B9A;
    }

    h1 {
        text-align: center
    }



    .tab input:focus {

        border: 1px solid #6a1b9a !important;
        outline: none;
    }

    input.invalid {

        border: 1px solid #e03a0666;
    }

    .tab {
        display: none
    }


    .all-steps {}

    .step {}

    .step.active {
        opacity: 1
    }


    .step.finish {
        color: #fff;
        background: #6a1b9a;
        opacity: 1;

    }



    .all-steps {
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px
    }

    .thanks-message {
        display: none
    }

    [data-toggle="collapse"] .fa:before {
        content: "\f13a";
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f139";
    }
</style>
@endsection