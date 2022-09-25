@extends('layouts.app', ['activePage' => 'cuis', 'titlePage' => 'cuis'])

@section('content')

@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">SINCRONIZACION DE CATALOGOS SIAT </h3>

    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Eventos Significativos</h4>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-outline-info" id="sincronizarCatalogo" >Sincronizar Catalogos</button><br><br>
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

                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Motivos Anulaciones</h4>
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive">
                            <table class="table table-striped mt-15" id="table1">
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
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    let sincronizarCatalogo = document.getElementById("sincronizarCatalogo");
    let ruta_sincronizar = "{{route('sincronizar_catalogos.ejecutar_pruebas_catalogos')}}";
    let ruta_index = "{{route('puntos_ventas.index')}}";
    let x =1;

    sincronizarCatalogo.addEventListener('click',(e)=>{
        
        $.ajax({
            url: ruta_sincronizar,
            type: 'GET',
            data:{},
            success: function(res) {
                console.log('entro');
            if(x == 1){
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
    $('#table').DataTable({

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

<script>
    $('#table1').DataTable({

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