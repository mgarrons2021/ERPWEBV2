@extends('layouts.app',['activePage' => 'home', 'titlePage' => 'Home'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Panel de administración </h3>

    </div>
    <div class="section-body">
        <div class="row">
            @role('Super Admin|Contabilidad|RRHH')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body ">
                        <!--    <h3 class="text-left">Donesco ERP</h3> -->
                        <div class="row">

                            <div class="col-md-4 col-xl-4">
                                <div class="card  text-white  mb-3 order-card card-color3 ">
                                    <div class="card-block border-success mb-3 ">
                                        <h6 class="text-center">&nbsp</h6>
                                        <h2 class="text-center"><i class="fa fa-users f-left"></i><span>
                                                {{ $cant_usuarios }}</span></h2>

                                        <p class="m-b-0 text-center"><a href="{{ route('personales.index') }}" class="text-white">Funcionarios</a></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-green order-card text-white card-color2">
                                    <div class="card-block border-success mb-3">
                                        <h6 class="">&nbsp</h6>
                                        <h2 class="text-center"><i class="	fa fa-cubes"> &nbsp</i><span>{{ $cant_areas }}</span></h2>
                                        <p class="m-b-0 text-center"><a href="{{ route('departamentos.index') }}" class="text-white">Areas</a>
                                        </p>
                                    </div>
                                </div>
                            </div>



                            <div class="col-md-4 col-xl-4">
                                <div class="card  order-card text-white mb-3 card-color1">
                                    <div class="card-block border-success mb-3">
                                        <h6>&nbsp</h6>
                                        <h2 class="text-center"><i class="fa fa-cube"></i><span>
                                                {{ $cant_sucursales }}</span></h2>
                                        <p class="m-b-0 text-center"><a href="{{ route('sucursales.index') }}" class="text-white">Sucursales</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-green order-card text-white card-color2">
                                    <div class="card-block border-success mb-3">
                                        <h6 class="">&nbsp</h6>
                                        <h2 class="text-center"><i class="	fa fa-user-times"> &nbsp</i><span>{{ $cant_retrasosFaltas }}</span></h2>
                                        <p class="m-b-0 text-center"><a href="{{ route('retrasosFaltas.index') }}" class="text-white">Retrasos - Faltas</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="card  order-card text-white mb-3 card-color1">
                                    <div class="card-block border-success mb-3">
                                        <h6>&nbsp</h6>
                                        <h2 class="text-center"><i class="fa fa-street-view"></i><span>
                                                {{ $cant_vacaciones }}</span></h2>
                                        <p class="m-b-0 text-center"><a href="{{ route('vacaciones.index') }}" class="text-white">Vacaciones</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="card bg-c-green order-card text-white card-color3">
                                    <div class="card-block border-success mb-3">
                                        <h6 class="">&nbsp</h6>
                                        <h2 class="text-center"><i class="	fa fa-chart-bar"> &nbsp</i><span>{{ $cant_compras }}</span></h2>
                                        <p class="m-b-0 text-center"><a href="{{ route('compras.index') }}" class="text-white">Compras: {{ $cant_compras }} </a> &nbsp <a class="text-white" href="{{ route('pagos.index') }}"> Pagos: {{ $cant_pagos }}</a>

                                        </p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @endrole
            <!--  <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block border-success mb-3">
                                <div id=''></div>
                            </div>
                        </div>
                    </div>
                </div> -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block border-success mb-3">
                            <div id='sucursales'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@section('scripts')
@if(session('status')=='false')
<script>
    iziToast.warning({
        title: "WARNING",
        message: "No tiene Cargo Asignado",
        position: "topCenter",
        timeout: 1500,
    });
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<script>
    var provData = <?php echo $compras_prov ?>;
    console.log(provData);
    var chart = Highcharts.chart('producto', {

        chart: {
            type: 'column'
        },

        title: {
            text: 'Cantidad de compras por proveedor'
        },

        /*     subtitle: {
                text: 'Productos activos en el sistema'
            }, */

        legend: {
            align: 'right',
            verticalAlign: 'middle',
            layout: 'vertical'
        },

        xAxis: {
            categories: ['Salsas', 'Saborizantes', 'Enlatado'],
            labels: {
                x: -10
            }
        },

        yAxis: {
            allowDecimals: false,
            title: {
                text: 'Cantidad'
            }
        },

        series: [{
            name: 'Proveedores',
            data: [provData]
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        align: 'center',
                        verticalAlign: 'bottom',
                        layout: 'horizontal'
                    },
                    yAxis: {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -5
                        },
                        title: {
                            text: null
                        }
                    },
                    subtitle: {
                        text: null
                    },
                    credits: {
                        enabled: false
                    }
                }
            }]
        }
    });

    document.getElementById('small').addEventListener('click', function() {
        chart.setSize(400);
    });

    document.getElementById('large').addEventListener('click', function() {
        chart.setSize(600);
    });

    document.getElementById('auto').addEventListener('click', function() {
        chart.setSize(null);
    });
</script>

<script>
    Highcharts.chart('sucursales', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Sucursales asociadas Donesco Srl.'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Suc Sur',
            colorByPoint: true,
            data: [{
                name: 'Suc Cine Center',
                y: 61.41,
                sliced: true,
                selected: true
            }, {
                name: 'Suc Boulevard',
                y: 11.84
            }, {
                name: 'Suc. Bajio',
                y: 10.85
            }, {
                name: 'Suc Radial 26',
                y: 4.67
            }, {
                name: 'Suc. Plan 3000',
                y: 4.18
            }, {
                name: 'Suc. Roca y Coronado',
                y: 1.64
            }, {
                name: 'Suc. Villa',
                y: 1.6
            }, {
                name: 'Suc. Palmas',
                y: 1.2
            }, {
                name: 'Suc Pampa',
                y: 2.61
            }]
        }]
    });
</script>
@endsection

@section('page_js')
<style>
    .card-color1 {
        background: linear-gradient(to left, #91eae4, #86a8e7, #7f7fd5);

    }

    .card-color2 {
        background: linear-gradient(to right, #96c93d, #00b09b);

    }

    .card-color3 {
        background: linear-gradient(to right, #ff4b2b, #ff416c);

    }
</style>
@endsection