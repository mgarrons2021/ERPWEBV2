@extends('layouts.app', ['activePage' => 'cuis', 'titlePage' => 'cuis'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">CATALOGOS ACTUALIZADOS DEL SIAT </h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Eventos Significativos</h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-outline-info" id="sincronizarCatalogo">Sincronizar Catalogos</button><br><br>
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($eventos_significativos as $evento_significativo)
                                    <tr>
                                        <td style="text-align:center">{{$evento_significativo->codigo_clasificador}}</td>
                                        <td style="text-align:center">{{$evento_significativo->descripcion}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Motivos Anulaciones</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($motivos_anulaciones as $motivo_anulacion)
                                    <tr>
                                        <td style="text-align:center">{{$motivo_anulacion->codigo_clasificador}}</td>
                                        <td style="text-align:center">{{$motivo_anulacion->descripcion}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Documentos de Identidad</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($motivos_anulaciones as $motivo_anulacion)
                                    <tr>
                                        <td style="text-align:center">{{$motivo_anulacion->codigo_clasificador}}</td>
                                        <td style="text-align:center">{{$motivo_anulacion->descripcion}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Leyendas de Facturas</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Actividad</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($leyendas_factura as $leyenda_factura)
                                    <tr>
                                        <td style="text-align:center">{{$leyenda_factura->codigo_actividad}}</td>
                                        <td style="text-align:center">{{$leyenda_factura->descripcion_leyenda}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Mensajes y Servicios</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($mensajes_servicios as $mensaje_servicio)
                                    <tr>
                                        <td style="text-align:center">{{$mensaje_servicio->codigo_clasificador}}</td>
                                        <td style="text-align:center">{{$mensaje_servicio->descripcion}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Metodos de Pagos</h4>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($metodos_pagos as $metodo_pago)
                                    <tr>
                                        <td style="text-align:center">{{$metodo_pago->codigoClasificador}}</td>
                                        <td style="text-align:center">{{$metodo_pago->descripcion}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Productos y Servicios</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Actividad</th>
                                    <th style="color: #fff;text-align:center">Codigo Producto</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($productos_servicios as $producto_servicio)
                                    <tr>
                                        <td style="text-align:center">{{$producto_servicio->codigo_actividad}}</td>
                                        <td style="text-align:center">{{$producto_servicio->codigo_producto}}</td>
                                        <td style="text-align:center">{{$producto_servicio->descripcion_producto}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Tipos de Emisiones</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($tipos_emisiones as $tipo_emision)
                                    <tr>
                                        <td style="text-align:center">{{$tipo_emision->codigoClasificador}}</td>
                                        <td style="text-align:center">{{$tipo_emision->descripcion}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Tipos de Facturas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($tipos_facturas as $tipo_factura)
                                    <tr>
                                        <td style="text-align:center">{{$tipo_factura->codigoClasificador}}</td>
                                        <td style="text-align:center">{{$tipo_factura->descripcion}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Tipos de Monedas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($tipos_monedas as $tipo_moneda)
                                    <tr>
                                        <td style="text-align:center">{{$tipo_moneda->codigoClasificador}}</td>
                                        <td style="text-align:center">{{$tipo_moneda->descripcion}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Unidades de Medidas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table">
                                <thead style="background-color: #6777ef;">

                                    <th style="color: #fff;text-align:center">Codigo Clasificador</th>
                                    <th style="color: #fff;text-align:center"> Descripcion</th>

                                </thead>
                                <tbody>
                                    @foreach ($unidades_medidas as $unidade_medida)
                                    <tr>
                                        <td style="text-align:center">{{$unidade_medida->codigoClasificador}}</td>
                                        <td style="text-align:center">{{$unidade_medida->descripcion}}</td>
                                    </tr>
                                    @endforeach
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
<script>
    let sincronizarCatalogo = document.getElementById("sincronizarCatalogo");
    let ruta_sincronizar = "{{route('sincronizar_catalogos.ejecutar_pruebas_catalogos')}}";
    let ruta_index = "{{route('puntos_ventas.index')}}";
    let x = 1;

    sincronizarCatalogo.addEventListener('click', (e) => {
        Swal.fire({
            title: 'Sincronizando Catalogos...',
            allowEscapeKey: false,
            icon: 'info',
            allowOutsideClick: false,
            background: '#19191a',
            showConfirmButton: false,
            onOpen: () => {
                Swal.showLoading();
            },
        });
        $.ajax({
            url: ruta_sincronizar,
            type: 'GET',
            data: {},
            success: function(res) {
                console.log('entro');
                if (x == 1) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Sincronizacion Catalogos Exitosa',
                        showConfirmButton: true,
                        timer: 3500,
                        willClose: function() {
                            window.location.href = ruta_index;
                        },
                    })
                }
            }


        })

    });
</script>
@section('page_js')



<script>
    let tables = document.getElementsByClassName("table");

    for (let index = 0; index < tables.length; index++) {
        const table = tables[index];
        console.log(table)
    }

    $('table.table').DataTable({

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

    });
</script>
@endsection
@endsection