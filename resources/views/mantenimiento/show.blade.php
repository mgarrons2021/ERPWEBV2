@extends('layouts.app', ['activePage' => 'mantenimiento', 'titlePage' => 'mantenimiento'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Registro Nro: {{ $mantenimiento->id }} de Caja Chica</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">

                    <div class="card-header">
                        <h4> Datos de Mantenimeinto &nbsp;- &nbsp;{{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive"></div>
                        <table class="table table-bordered table-md">
                            <tbody>
                                <tr>
                                    <th> Funcionario Encargado:</th>
                                    <td> <span class="badge badge-success"> {{ $mantenimiento->user->name }} </span></td>
                                </tr>
                                <tr>
                                    <th> Sucursal:</th>
                                    <td> {{ $mantenimiento->sucursal->nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Registro:</th>
                                    <td>{{ $mantenimiento->fecha }}</td>
                                </tr>
                                <tr>
                                    <th> Total Egreso:</th>
                                    <td>{{ $mantenimiento->total_egreso }} BS</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalles de Mantenimiento &nbsp;- &nbsp; {{$fecha_actual}} </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <th style="text-align: center;"> Foto </th>
                                <th style="text-align: center;"> Tipo de Egreso </th>
                                <th style="text-align: center;"> Glosa </th>
                                <th style="text-align: center;"> Egreso </th>

                            </thead>
                            <tbody>
                                @foreach($mantenimiento->detalles_mantenimiento as $detalle)
                                <tr>
                                    <td style="text-align: center;"> <img class="imagenes" src="{{ url($detalle->foto)}}" alt="" width="80px" height="85px" style="border-radius:25px ;padding:5px"></td>
                                    <td style="text-align: center;">{{$detalle->categoria_caja_chica->nombre}}</td>
                                    <td style="text-align: center;">{{$detalle->glosa}}</td>
                                    <td style="text-align: center;">{{$detalle->egreso}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="3" style="text-align: center;"> Total Gasto en Mantenimiento</td>
                                <td colspan="1" style="text-align: center;"> {{$mantenimiento->total_egreso}} Bs. </td>
                            </tfoot>
                        </table>
                        <!-- Modal -->
                        <div id="myModal" class="modal">
                            <span class="close">&times;</span>
                            <img class="modal-content" id="img01">
                            <div id="caption"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="button-container ">
            <a href="{{ route('mantenimiento.index') }}" class="btn btn-warning  btn-twitter mr-2"> Volver </a>
            <a href="" class="btn btn-info btn-twitter"> Editar </a>
        </div>
    </div>
</section>
@endsection
@section('page_js')
<script>
    let imagenes = document.getElementsByClassName("imagenes");
    var modal = document.getElementById("myModal");
    var img = document.getElementById("myImg");
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");


    var span = document.getElementsByClassName("close")[0];
    span.onclick = function() {
        modal.style.display = "none";
    }
    for (let i in imagenes) {
        let imagen = imagenes[i];
        imagen.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }
    }


</script>
@endsection
@section('page_css')
<style>
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 50%;
        left: 12%;
        max-width: 300px;
    }

    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    .modal-content,
    #caption {
        -webkit-animation-name: zoom;
        -webkit-animation-duration: 0.6s;
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @-webkit-keyframes zoom {
        from {
            -webkit-transform: scale(0)
        }

        to {
            -webkit-transform: scale(1)
        }
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }

        to {
            transform: scale(1)
        }
    }

    .close {
        position: absolute;
        top: 50px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #bbb;
        text-decoration: none;
        cursor: pointer;
    }

    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>
@endsection