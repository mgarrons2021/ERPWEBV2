@extends('layouts.app', ['activePage' => 'Precio Sucursales', 'titlePage' => 'Precio Sucursales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Nuevo Insumo </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione el Producto</label>
                                    <select name="producto" class="form-select select22" id="producto" style="width: 100%;">
                                        <option value="x">Seleccione el Producto </option>
                                        @foreach($categorias as $categoria)
                                        @if( $categoria->nombre != "Produccion" && $categoria->nombre != "Bebidas" )
                                        <optgroup label="{{Str::upper( $categoria->nombre)}}" class="title-select">
                                            @foreach($categoria->productos as $producto)
                                            @if( $producto->estado != 0 )
                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            @endif
                                            @endforeach
                                        </optgroup>
                                        @endif
                                        @endforeach
                                    </select>
                                    <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Seleccione el Dia</label>
                                    <select name="dia" class="form-select select22" id="dia" style="width: 100%;">
                                        <option value="x">Seleccione el Dia </option>
                                        @foreach($insumos as $insumo)
                                            <option value="{{$insumo->id}}">{{$insumo->dia}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Cantidad*</label>
                                <input type="number" name="cantidad_solicitada" id="cantidad" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" id="agregar_insumo" onclick="agregar()">Agregar Insumo</button>
                            </div>
                            <input type="hidden" id="producto_nombre" name="producto_nombre" class="form-control" value="">
                            <input type="hidden" id="precio" name="precio" class="form-control" value="" placeholder="Bs" readonly>
                            <input type="hidden" id="subtotal_solicitado" name="subtotal_solicitado" class="form-control" value="" placeholder="Bs" readonly>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
    
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;" id="table">
                    <thead class="table-info">                        
                        <th style="text-align: center;">Producto</th>
                        <th style="text-align: center;">Dia</th>
                        <th style="text-align: center;">Cantidad Solicitada</th>                                                         
                    </thead>
                    <tbody id="tbody">
                        
                        <tr>
                            <td style="text-align: center;"> NAME </td>
                            <td style="text-align: center;"> Dia </td>
                            <td style="text-align: center;"> 0</td>
                                                     
                        </tr>
                       
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-outline-info" id="guardar_pedido" onclick="registrar()"> Registrar Insumos Predefinidos </button>
                <a type="button" href="{{route('pedidos.pedido_especial')}}" class="btn btn-outline-danger">Cancelar </a>
            </div>
        </div>
    </div>

    <div class="card">
        
        <div class="card-body">
            <h2>Insumos Registrados</h2>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="width: 100%;" id="table2">
                    <thead class="table-info">                        
                        <th style="text-align: center;">Producto</th>
                        <th style="text-align: center;">Dia</th>
                        <th style="text-align: center;">Cantidad Solicitada</th>       
                        <th style="text-align: center;"></th>                                                         
                    </thead>
                    <tbody id="tbody2">
                        @foreach( $productos as $insumo)
                        <tr>
                            <td style="text-align: center;"> {{ $insumo->producto->nombre }} </td>
                            <td style="text-align: center;"> {{ $insumo->insumos_dias->dia }} </td>
                            <td style="text-align: center;"> {{ $insumo->cantidad }} </td>      
                            <td style="text-align: center;">
                            <a class="btn btn-danger" onclick="eliminar({{$insumo->id}})">ELIMINAR</a>
                            </td>                      
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')

<!-- <script type="text/javascript" src="{{ URL::asset('assets/js/pedidos/create.js') }}"> </script> -->
<script>
    const csrfToken = document.head.querySelector(
        "[name~=csrf-token][content]"
    ).content;

    let ruta_agregar_insumo = "{{ route('pedidos.agregarInsumo') }}";
    let ruta_obtener_precios = "{{route('pedidos.obtenerPrecios')}}"
    let ruta_eliminar_insumo = "{{ route('pedidos.eliminarInsumo') }}";
    let ruta_guardar_pedido = "{{ route('pedidos.store') }}";
    let ruta_pedidos = "{{ route('pedidos.index') }}";
    let ruta_obtener_plato = "{{route('platos_sucursales.obtenerPlato')}}";
    let ruta_especial = "{{route('pedidos.pedido_especial')}}";
    let ruta_guardar_especial = "{{route('productosinsumos.store')}}";
    let ruta_index ='{{route("productosinsumos.create")}}';
    let ruta_eliminar="{{route('productosinsumos.destroy')}}";

    let producto =  document.getElementById('producto');
    let dia =  document.getElementById('dia');
    let cantidad =  document.getElementById('cantidad');
    let tbody= document.getElementById('tbody');
    let array_productos = new Array();

    function agregar(){
        console.log(producto.value);
        console.log(dia.value);
        console.log(cantidad.value);

        array_productos.push({
            'nombre' : producto.options[producto.selectedIndex].text,
            'dia' : dia.options[dia.selectedIndex].text,
            'idproducto':producto.value,
            'iddia': dia.value,
            'cantidad':cantidad.value
        }); 
        tbody.innerHTML='';
        let text='';
        array_productos.forEach(element => { 
            text+='<tr>'+
                    '<td style="text-align: center;"> '+element.nombre+' </td>'+
                    '<td style="text-align: center;"> '+element.dia+' </td>'+
                    '<td style="text-align: center;">'+element.cantidad+'</td>'+                          
                '</tr>';
        });
        tbody.innerHTML+=text;
    }

    function registrar(){

        console.log(array_productos);
        fetch(ruta_guardar_especial, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
            body: JSON.stringify({
                productos:array_productos
            }),
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data);
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Insumos agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_especial;
                    },
                });
            }
        })
        .catch((error) => {
            iziToast.warning({
                title: "AVISO",
                message: "Problemas al guardar los insumos",
                position: "topCenter",
                timeout: 1500,
                
            });
        });

    }


    function eliminar(id){
        console.log(id);
        fetch(ruta_eliminar, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },
            body: JSON.stringify({
                id:id
            }),
        })
        .then((response) => {
            return response.json();
        })
        .then((data) => {
            console.log(data);
            if (data.success == true) {
                iziToast.success({
                    title: "SUCCESS",
                    message: "Eliminado",
                    position: "topRight",
                    timeout: 1000,
                    onClosed: function () {
                        window.location.href = ruta_index;
                    },
                });
            }
        })
        .catch((error) => {
            iziToast.warning({
                title: "AVISO",
                message: "Problemas al eliminar",
                position: "topCenter",
                timeout: 1500,
                
            });
        });


    }
</script>

@section('page_js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#table2').DataTable({
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "",
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
            }
        });

        $("#producto")
        .select2({
            placeholder: "Seleccione una opcion",
        })
    });
</script>
@endsection
@endsection
