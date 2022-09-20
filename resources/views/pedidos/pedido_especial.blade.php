@extends('layouts.app', ['activePage' => 'Precio Sucursales', 'titlePage' => 'Precio Sucursales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Solicitud de Pedidos</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">                        
                        <h4 style="text-align:right;color:white;">Fecha: </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_pedido">Fecha Entrega*</label>
                                    <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control">
                                    <p class="text-left text-danger d-none" id="errorfecha">Debe ingresar una fecha </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <label for="cantidad_solicitada">Cantidad*</label>
                                <input type="number" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" onclick="agregar()">Agregar Insumo</button>
                            </div>
                            <input type="hidden" id="um" name="um" class="form-control" value="">
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
                        <th>CATEGORIA</th>
                        <th style="text-align: center;">Producto</th>
                        <th style="text-align: center;">Cantidad Solicitada</th>
                        <th style="text-align: center;">Unidad Medida</th>
                        <th style="text-align: center;">Costo Unitario </th>
                        <th style="text-align: center;">Sub Total </th>                        
                    </thead>
                    <tbody id="tbody">
                        @php
                            $total =0;
                            $subtotal=0;
                        @endphp                   
                        @foreach($productos_predefinidos as $item  )
                        <tr id="{{$item->id}}">                           
                            <Td  class="{{$item->producto->categoria->id}} categoria">{{$item->producto->categoria->nombre}}</td>
                            <td style="text-align: center;" class="id_productos" id="{{$item->producto_id}}">{{$item->producto->nombre}} </td>
                            <td style="text-align: center;"><input type="number"  id="stock-{{$item->id}}" value="{{ $item->cantidad }}" class="form-control stock" /> </td>
                            <td style="text-align: center;">  {{ $item->producto->unidad_medida_compra->nombre }}</td>
                            @if( sizeof(  $item->producto->productos_proveedores)>0)
                                @php 
                                    $subtotal= $item->producto->productos_proveedores[sizeof(  $item->producto->productos_proveedores)-1]->precio * $item->cantidad;
                                    $total+=$subtotal;
                                @endphp
                                <td style="text-align: center;" class="precios" id="precio-{{$item->id}}"> {{ $item->producto->productos_proveedores[sizeof(  $item->producto->productos_proveedores)-1]->precio  }}</td>
                                <td style="text-align: center;" class="td_subtotal" id="td_subtotal-{{$item->id}}" > {{ $subtotal}} </td>
                            @else
                                <td style="text-align: center;" class="precio" id="precio-{{$item->id}}"> 0</td>
                                <td style="text-align: center;"  class="td_subtotal" id="td_subtotal-{{$item->id}}" >0 </td>
                            @endif                                               
                        </tr>
                        @endforeach
                        @php
                            //dd($productos_predefinidos);
                        @endphp                      
                    </tbody>
                    <tfooter>
                        <tr>
                            <td colspan="6" style="text-align: center;" class="table-info" id="total_pedido">Total: {{ number_format($total,3) }} Bs</td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>

        <div class="card-footer">

            <div class=" text-center">
                <button type="button" class="btn btn-outline-success" id="guardar_pedido" onclick="registrar()"> Registrar Pedido </button>
                <button type="button" class="btn btn-outline-danger" id="cancelar">Cancelar </button>
                <a type="button" class="btn btn-outline-info" id="nuevos" href="{{route('productosinsumos.create')}}">Agregar Nuevos Productos </a>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
 
<script>

    let ruta_agregar_insumo = "{{ route('pedidos.agregarInsumo') }}";
    let ruta_obtener_precios = "{{route('pedidos.obtenerPrecios')}}"
    let ruta_eliminar_insumo = "{{ route('pedidos.eliminarInsumo') }}";
    let ruta_guardar_pedido = "{{ route('pedidos.pedido_especial_store') }}";
    let ruta_pedidos = "{{ route('pedidos.index') }}";
    let ruta_obtener_plato = "{{route('platos_sucursales.obtenerPlato')}}";

    let precios = document.getElementsByClassName('precios');
    let categorias = document.getElementsByClassName('categoria');
    let td_subtotales = document.getElementsByClassName("td_subtotal");
    let td_total_pedido = document.getElementById("total_pedido");
    let stocks_input = document.getElementsByClassName("form-control stock");
    let idproductos= document.getElementsByClassName('id_productos');
    let cantidad_solicitada= document.getElementById('cantidad_solicitada');
    let fecha  = document.getElementById('fecha_pedido');
    let producto_nombre= 0;
    let um= '';
    let preciogeneral= 0;
    let tbody =  document.getElementById('tbody');
    let subtotal_solicitado=0;

    let array_stocks = [];
    let array_subtotales = [];
    let array_detalle_pedido_id_a_agregar= [];
    let array_categorias = [];
    let precio_prod=[];
    let categoria_nombre='';
    let categoria_id=0;
    const csrfToken = document.head.querySelector( "[name~=csrf-token][content]" ).content;

    let producto_id;

    $(document).ready(function () {

        $("body").on("keyup", ".stock", function () {
            //console.log(stocks_input);
            for (let i in stocks_input) 
            {
                let stock = stocks_input[i];
                let precio = precios[i];
                //console.log(precio);
                let td_subtotal = td_subtotales[i];
                td_subtotal.innerHTML = stock.value *parseFloat(precio.innerHTML);
            }
            
            let total = 0;
            
            for (let j in td_subtotales) 
            {
                if (
                    td_subtotales[j].innerHTML !== undefined &&
                    !isNaN(td_subtotales[j].innerHTML)
                ) {
                    total += parseFloat(td_subtotales[j].innerHTML);
                }
            }

            td_total_pedido.innerHTML = total;

        });

        $("#producto")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch(ruta_obtener_precios, {
                method: "POST",
                body: JSON.stringify({
                    producto_id: e.target.value,
                }),
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": csrfToken,
                },
            })
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    console.log(data);
                    if (data.precio != null) {
                        producto_id = data.producto_id;
                        producto_nombre = data.producto_nombre;
                        um=data.unidad_medida;
                        preciogeneral =  data.precio;
                        categoria_nombre = data.categoria;
                        categoria_id = data.categoria_id;              
                    } else {
                        producto.selectedIndex = 0;
                        iziToast.warning({
                            title: "WARNING",
                            message:
                                "El producto no cuenta con un precio a registrar",
                            position: "topRight",
                            timeout: 1500,
                        });
                        $("#producto")
                            .val("x")
                            .trigger("change.select2");

                    }
                })
                .catch((error) => console.error(error));
        });

    });

    cantidad_solicitada.addEventListener("keyup", (e) => {
        subtotal_solicitado = (
            cantidad_solicitada.value * preciogeneral
        ).toFixed(4);
    });

    function detallesAEditar() {
        for (let i in checboxs_editar) {
            let checkbox_editar = checboxs_editar[i];
            if (checkbox_editar.value != undefined) {
                if (checkbox_editar.checked) {
                    array_stocks.push(stocks_input[i].value);
                    array_subtotales.push(td_subtotales[i].innerHTML);
                    array_detalle_pedido_id_a_editar.push(checkbox_editar.value);
                }
            }
        }
    }

    function agregar(){

        if ( $('#producto').val() != "x") {
            /*FILETES*/
            let nueva_cantidad = cantidad_solicitada.value;
            let nueva_subtotal = subtotal_solicitado;
            let nuevo_precio = preciogeneral;
            if (producto_id == 3) {
                let filete_en_unidades = cantidad_solicitada.value / 0.18;
                let precio_por_unidad_filete =
                    subtotal_solicitado / filete_en_unidades;
                console.log("precio filete/unidad: ", precio_por_unidad_filete);
                nuevo_precio = precio_por_unidad_filete;
                nueva_cantidad = cantidad_solicitada.value;
                nueva_subtotal = nuevo_precio * nueva_cantidad;
            }
            /*CHORIZOS*/

            if (producto_id == 195 || producto_id == 240) {
                let chorizo_en_unidades = 10 * cantidad_solicitada.value;
                let precio_por_unidad_chorizo =
                    subtotal_solicitado / chorizo_en_unidades;
                nuevo_precio = precio_por_unidad_chorizo;
                nueva_cantidad = cantidad_solicitada.value;
                nueva_subtotal = nuevo_precio * nueva_cantidad;
            }
            /*ALITAS DE POLLO*/
            if (producto_id == 201) {
                let pieza_en_unidades = cantidad_solicitada.value * 8;
                console.log(cantidad_solicitada.value);
                let precio_por_unidad_pieza =
                    subtotal_solicitado / pieza_en_unidades;
                console.log(subtotal_solicitado);
                console.log(pieza_en_unidades);
                    
                console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
                nuevo_precio = precio_por_unidad_pieza+1.8;
                nueva_cantidad = cantidad_solicitada.value;
                nueva_subtotal = nuevo_precio * nueva_cantidad;
            }

            /*POLLO BRASA*/

            if (producto_id == 200) {
                let pieza_en_unidades = cantidad_solicitada.value * 8;
                let precio_por_unidad_pieza =
                    subtotal_solicitado / pieza_en_unidades;
                console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
                nuevo_precio = 26.49;
                nueva_cantidad = cantidad_solicitada.value;
                nueva_subtotal = nuevo_precio * nueva_cantidad;
            }

            if (producto_id == 21) {
                let pieza_en_unidades = cantidad_solicitada.value / 0.200;
                let precio_por_unidad_pieza =
                    subtotal_solicitado / pieza_en_unidades;
                console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
                nuevo_precio = precio_por_unidad_pieza;
                nueva_cantidad = cantidad_solicitada.value;
                nueva_subtotal = nuevo_precio * nueva_cantidad;
            }

            /*PLATANO*/
            if (producto_id == 45) {
                let pieza_en_unidades = cantidad_solicitada.value * 64;
                let precio_por_unidad_pieza =
                    subtotal_solicitado / pieza_en_unidades;
                console.log("precio alitas/unidad: ", precio_por_unidad_pieza);
                nuevo_precio = precio_por_unidad_pieza;
                nueva_cantidad = cantidad_solicitada.value;
                nueva_subtotal = nuevo_precio * nueva_cantidad;
            }    


            let html='<tr id="'+stocks_input.length+'" >'+
                        '<Td class="'+categoria_id+' categoria">'+categoria_nombre+'  </td>'+
                        '<td style="text-align: center;" class="id_productos" id="'+producto_id+'">'+ producto_nombre +'  </td>'+
                        '<td style="text-align: center;"><input type="number"  id="stock-'+stocks_input.length+'" value="'+nueva_cantidad+'" class="form-control stock" /> </td>'+
                        '<td style="text-align: center;">  '+um+'</td>'+
                        '<td style="text-align: center;" class="precios" id="precio-'+stocks_input.length+'"> '+nuevo_precio+'</td>'+
                        '<td style="text-align: center;"  class="td_subtotal" id="td_subtotal-'+stocks_input.length+'" >'+nueva_subtotal+'  </td>'+
                    '</tr>';
            tbody.innerHTML+=html;
        }
        else
        {
            iziToast.warning({
                title: "AVISO",
                message: "Debe rellenar los campos faltantes",
                position: "topCenter",
                timeout: 1500,                
            });
        }
    }

    function registrar()
    {
        console.log(array_stocks);
        console.log(array_detalle_pedido_id_a_agregar);
        
        detallesAEditar();

        if( fecha.value !='' ){
            detallesAEditar();
            fetch(ruta_guardar_pedido, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": csrfToken,
            },  
            body: JSON.stringify({
                'stocks':array_stocks,
                'idproductos':array_detalle_pedido_id_a_agregar,
                'subtotales':array_subtotales,
                'total':td_total_pedido,
                'fecha_pedido':fecha.value,
                'precios':precio_prod
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
                    message: "Pedido agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                        window.location.href = ruta_pedidos;
                    },
                });
            }
        })
        .catch((error) => {
            iziToast.warning({
                title: "AVISO",
                message: "Problemas al guardar el pedido",
                position: "topCenter",
                timeout: 1500,
                
            });
        });

        }else{
            iziToast.warning({
                title: "AVISO",
                message: "Debe asignar una fecha para el pedido ...",
                position: "topCenter",
                timeout: 1500,
                
            });
        }        
    }

    function detallesAEditar() 
    {
        
        /* for (let index = 0; index < stocks_input.length; index++) {
            array_stocks.push(stocks_input[index].value);
            array_subtotales.push(td_subtotales[index].innerHTML);
            array_detalle_pedido_id_a_agregar.push(  idproductos[index].id );   
            precio_prod.push( precios[index].innerHTML );
        } */
        
        for (let index = 0; index < categorias.length; index++) {
            //console.log(categorias[index].classList[0]);    
            array_categorias.push( categorias[index].classList[0] );
        }
        console.log(array_categorias);
        
    }

</script>   

@endsection