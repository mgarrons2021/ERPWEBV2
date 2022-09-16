@extends('layouts.app', ['activePage' => 'MenuEvaluado', 'titlePage' => 'Reportes'])
@section('content')
@section('css')
@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Reporte General</h3>
    </div>
    <div class="section-body">
        <div class="row">
            
            <div class="card text-white bg-primary alert">
                <div class="card-body ">
                    <div class=" mensaje">
                        <p class="leyenda text-center" >REPORTE MENU SEMANAL <br>                       
                       
                        </p>
                    </div>
                </div>
            </div>           
            @php 
            $promediosabor=0;
            $promediopresenta=0;
            @endphp

            <form id="regForm" action="/action_page.php">
                <table class="table table-hover table-responsive" id="table">
                    <thead>
                        <th class="static" scope="col" style="background-color:white">SUCURSAL</th>
                        <th class="first-col"  scope="col">LUNES</th>
                        <th>MARTES</th>
                        <th>MIERCOLES</th>
                        <th>JUEVES</th>
                        <TH>VIERNES</TH>
                        <TH>SABADO</TH>
                        <TH>DOMINGO</TH>                       
                    </thead>
                    <tbody>
                        @foreach( $calificados as $detalle)
                        <tr>
                            <td class="static" scope="col" style="background-color:white">{{$detalle->nombre}}</td>
                            <td class="first-col"  scope="row"  > <span class="badge badge-{{  number_format($detalle->Lunes )==0?'danger':'info'; }}">{{ number_format($detalle->Lunes,2)}}</span> </td>
                            <td  > <span class="badge badge-{{  number_format($detalle->Martes )==0?'danger':'info'; }}">{{ number_format( $detalle->Martes ,2)}}</span> </td>
                            <td  > <span class="badge badge-{{  number_format($detalle->Miercoles )==0?'danger':'info'; }}">{{ number_format( $detalle->Miercoles ,2)}}</span> </td>
                            <td  > <span class="badge badge-{{  number_format($detalle->Jueves )==0?'danger':'info'; }}">{{ number_format( $detalle->Jueves ,2)}}</span> </td>
                            <td > <span class="badge badge-{{  number_format($detalle->Viernes )==0?'danger':'info'; }}">{{ number_format( $detalle->Viernes ,2)}}</span> </td>
                            <td  > <span class="badge badge-{{  number_format($detalle->Sabado )==0?'danger':'info'; }}">{{ number_format( $detalle->Sabado ,2)}} </span> </td>
                            <td ><span class="badge badge-{{  number_format($detalle->Domingo )==0?'danger':'info'; }} ">{{ number_format( $detalle->Domingo ,2)}}</span></td>
                        </tr>    
                        @endforeach              
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
    let ruta_index= "{{route('menus_semanales.reporteMenu')}}";
</script>
<script>
$("#table").DataTable({
    language: {
        sProcessing: "Procesando...",
        sLengthMenu: "Mostrar _MENU_EVALUADOS_ registros",
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
            sPrevious: "Anterior",
        },
        oAria: {
            sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
            sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
        },
    },
    columnDefs: [
        {
            orderable: false,
            targets: 7,
        },
    ],
});

    
</script>
@endsection

@section('page_css')
<style>
    table {
    display: block;
    overflow-x: auto;
    }

    .static {
    position: absolute;
    background-color: white;
    
    }

    .first-col {
    padding-left:40.5px!important;
    }

    .p-titulo {
        font-size: 20px;
    }

    .leyenda {
        font-size: 15px;
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

