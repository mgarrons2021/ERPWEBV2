|@extends('layouts.app', ['activePage' => 'ventas_sucursal', 'titlePage' => 'Ventas_Sucursal'])

@section('content')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
@endsection

<section class="section">

    <div class="section-header">
        <h1 class="text-center">Reporte de Ventas por Sucursal</h1>
    </div>

    <div class="card-body">
        <div class="table-responsive" style="overflow-x: hidden">

            <div class="row">
                <div class="col-md-6">

                    <div class="input-daterange input-group" id="datepicker">
                        <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                        <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="input-daterange input-group" id="datepicker">
                        <span class="input-group-addon "><strong>A:</strong> </span>
                        <input type="date" id="fecha_final" class="input-sm form-control" name="fecha_final" value="" />
                    </div>
                </div>

            </div>
            <div class="card-footer">
                <div class="col-md-4" style="margin: 0 auto;">
                    <input class="form-control btn btn-primary" value="Filtrar" type="button" id="filtrar" name="filtrar" onclick="filtrar()">
                </div>
            </div>

        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card"></div>
                <div class="card-body">

                    <div class="table-responsive ">
                        <table id="dtable" class="table">
                            <thead style="background-color: #6777ef;">
                                <tr id="thead">

                                </tr>
                            </thead>
                            <tbody id="tbody">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    </form>

    <div class="col-lg-12">

    </div>

</section>

@endsection

@section('scripts')

@section('page_js')
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
{{-- <script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

@endsection

<script>
    let ruta = "http://donesco.com.bo/eerpweb/reporte/api.php?";
    let thead = document.getElementById('thead');
    let tbody = document.getElementById('tbody');
    let date = new Date();
    let fecha = (date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + (date.getDate() - 1)).toString();

    $(document).ready(function() {

        obtener(ruta + `fecha=${fecha}&fecha_a=${fecha}`);

        /* $('#dtable').dataTable({
                    "bLengthChange": false,
                    "bPaginate": true,
                    "bInfo": false,
                    destroy: true,
                    responsive: true,
                    "autoWidth": false,
                    language: {
                        search: 'Buscar:',
                        paginate: {
                            first: "Primero",
                            previous: "Anterior",
                            next: "Siguiente",
                            last: "Ultimo"
                        },
                    }
        });  */

    });

    function obtener(rutaa) {

        Swal.fire({ //alerta
            title: 'Cargando la informacion ...',
            allowEscapeKey: false,
            icon: 'info',
            allowOutsideClick: false,
            background: '#19191a',
            showConfirmButton: false,
            onOpen: () => {
                Swal.showLoading();
            },
        });

        var settings = {
            'cache': false,
            "async": true,
            "crossDomain": true,
            "url": rutaa + '',
            'dataType': "json",
            "method": "GET",
            "headers": {
                "Content-Type": "application/json",
                "accept": "application/json",
                "Access-Control-Allow-Origin": "*",
                'Access-Control-Allow-Credentials': 'true'
            }
        }

        /* $('#dtable').dataTable({    
            destroy:true,
        });  */

        fetch(rutaa, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    'Accept': 'application/json',
                },
            })
            .then((response) => {
                console.log(response)
                return response.json();
            })
            .then((data) => {

                /*$('#dtable').DataTable( {    
                    destroy:true,
                } ); 
                 */

                //$('#dtable').dataTable().fnDestroy();

                let plato = data.platos;

                plato.push({
                    'idplato': 'gaseosas',
                    'nombre': 'Gaseosas'
                });

                plato.push({
                    'idplato': 'refrescos',
                    'nombre': 'Refrescos'
                });

                console.log(data);
                mostrarPlatos(plato);
                mostrarSucursalesyDetalles(data.data, data.platos);
                Swal.close();

                //$('#dtable').DataTable();

                $('#dtable').dataTable({
                    "bLengthChange": false,
                    "bPaginate": true,
                    "bInfo": false,
                    destroy: true,
                    responsive: true,
                    "autoWidth": false,
                    language: {
                        search: 'Buscar:',
                        paginate: {
                            first: "Primero",
                            previous: "Anterior",
                            next: "Siguiente",
                            last: "Ultimo"
                        },
                    },
                    dom: 'Bftipr',
                    buttons: [{
                            //Botón para Excel
                            extend: 'excel',
                            footer: true,
                            title: 'Reporte Ventas',
                            filename: 'reporte',
                            //Aquí es donde generas el botón personalizado
                            text: '<button class="btn btn-success">Exportar a Excel <i class="fas fa-file-excel"></i></button>'
                        },
                        //Botón para PDF
                        {
                            extend: 'pdf',
                            footer: true,
                            title: 'Reporte Ventas',
                            filename: 'reporte',
                            text: '<button class="btn btn-danger">Exportar a PDF <i class="far fa-file-pdf"></i></button>',
                            customize: function(pdfDocument) {}
                        },
                    ]
                });
                /* $('#table').DataTable({
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
            }); */

            })
            .catch((error) => console.error(error));
    }

    function mostrarPlatos(platos) {
        thead.innerHTML = '';
        let th = document.createElement('th');
        th.innerHTML = "Sucursal";
        th.style = "color: #fff";
        th.class = "text-center";
        thead.appendChild(th);

        platos.forEach(plato => {
            let th = document.createElement('th');
            th.innerHTML = plato.nombre;
            th.style = "color: #fff";
            th.class = "text-center";
            thead.appendChild(th);
        })
    }

    function mostrarSucursalesyDetalles(data, platos1) {
        tbody.innerHTML = '';

        let totales = new Array();
        var primeros = true;
        let aux = 0;

        data.forEach(element => {
            let tr = document.createElement('tr');
            let td = document.createElement('td');
            td.innerHTML = element.nombre_sucursal;
            tr.appendChild(td);
            platos1.forEach(plato1 => {
                let sw = false;
                let td = document.createElement('td');

                if (primeros) {
                    totales.push(0);
                }

                element.platos.forEach(plato2 => {

                    if (plato1.idplato == plato2.idplato) {
                        td.innerHTML = plato2.cantidad;
                        tr.appendChild(td);
                        sw = true;
                        totales[aux] += parseFloat(plato2.cantidad);
                    }
                });

                if (!sw) {
                    td.innerHTML = 0;
                    tr.appendChild(td);
                }
                sw = false;
                aux += 1;
            });

            aux = 0;
            primeros = false;
            tbody.appendChild(tr);

        });

        let total = '<tr class="table-info"><td>TOTAL</td>';
        for (let index = 0; index < totales.length; index++) {
            total = total + '<td>' + totales[index] + '</td>';
        }

        total = total + '</tr>';
        tbody.insertAdjacentHTML('afterbegin', total);

    }

    function filtrar() {
        let fecha1 = document.getElementById('fecha_inicial').value;
        let fecha2 = document.getElementById('fecha_final').value;
        obtener(ruta + `fecha=${fecha1}&fecha_a=${fecha2}`);
    }
</script>

@endsection