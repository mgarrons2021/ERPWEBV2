@extends('layouts.app', ['activePage' => 'receta', 'titlePage' => 'Receta'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Asignacion de Receta al Plato: {{$plato->nombre}} </h3>
        <input type="hidden" id="plato_id" value="{{$plato->id}}">
    </div>
    <div class="section-body">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <h4>Seleccione el Item a Agregar</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="proveedor"> Proveedor <span class="required">*</span></label>
                                <select name="proveedor" id="proveedor" class="form-select" style="width: 100%;">
                                    <option value=""> Seleccionar proveedor </option>
                                    @foreach($proveedores as $provedor)
                                    <option value="{{$provedor->id}}"> {{$provedor->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="producto"> Producto <span class="required">*</span></label>
                                <select name="producto" id="producto" class="form-select" style="width: 100%;">
                                    <option value=""> Seleccionar producto </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cantidad">Cantidad<span class="required">*</span></label></label>
                                <input type="number" name="cantidad" id="cantidad" class="form-control" value="" placeholder="Cantidad...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="precio">Precio del Producto<span class="required">*</span></label></label>
                                <input type="number" name="precio" id="precio" class="form-control" value="" placeholder="0.0000" readonly>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="subtotal">Subtotal<span class="required">*</span></label></label>
                                <input type="number" name="subtotal" id="subtotal" class="form-control" value="" placeholder="0.0000" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary" id="agregar_item"> Agregar Item</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 id="titulo_detalle">Detalle de el {{$plato->nombre}}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-md" style="width: 100%;" id="table">
                            <thead>
                                <th style="text-align: center;">Producto</th>
                                <th style="text-align: center;">Precio</th>
                                <th style="text-align: center;">Cantidad</th>
                                <th style="text-align: center;">Subtotal</th>
                                <th style="text-align: center;">Opciones</th>
                            </thead>
                            <tbody id="tbody">
                                <?php $subtotal = 0; ?>
                                @if (session('lista_receta'))
                                @foreach (session('lista_receta') as $indice => $item)
                                <tr>
                                    <td style="text-align: center;">
                                        {{$item['producto_nombre']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$item['precio']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{$item['cantidad']}}
                                    </td>
                                    <td style="text-align: center;">
                                        {{number_format ($item['subtotal'] , 4)}}
                                    </td>

                                    <td style="text-align: center;">
                                        <button class="btn btn-danger" id="eliminar" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                                    </td>
                                    <?php $subtotal += $item['subtotal']; ?>
                                    
                                </tr>
                                @endforeach
                                @endif
                                <tr>
                                    
                                    <td colspan="1" style="text-align: center;">TOTAL COSTO PLATO </td>
                                    <td colspan="4" style="text-align: center;">
                                     Bs. {{number_format ($subtotal , 4)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class=" text-center">
                        <button type="button" class="btn btn-primary" id="registrar_receta">Registrar
                            Receta</button>
                        <a href="{{ route('platos.index')}}" type="button" class="btn btn-danger" id="cancelar">Cancelar </a>
                    </div>
                </div>
            </div>
        </div>
</section>

@endsection
@section('scripts')
@section('page_js')
<script>
    let ruta_plato = "{{route('platos.index')}}";
    let agregar_detalle = "{{ route('recetas.agregarDetalle')}}";
    let eliminar_detalle = "{{ route('recetas.eliminarDetalle')}}";
    let registrar_receta = "{{ route('recetas.registrarReceta')}}";
    let guardar = document.getElementById("agregar_item");
    let costo_plato = document.getElementById("costo_plato");
    var total_receta = 0;
    var producto_proveedor_id = document.getElementById("producto");
    var cantidad = document.getElementById("cantidad");
    let plato_id = document.getElementById("plato_id");


    let btn_registrar_receta = document.getElementById("registrar_receta");
    const csrfToken = document.head.querySelector(
        "[name~=csrf-token][content]"
    ).content;


    $(document).ready(function() {
        $('#categoria_plato').select2();
        $('#producto').select2();
        $('#proveedor').select2();
        $('#plato').select2();
        $('#categoria_plato').change(function(e) {
            fetch(ruta_obtenerplatos, {
                    method: "POST",
                    body: JSON.stringify({
                        categoria_id: e.target.value,
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
                    var opciones = "<option> Seleccionar Plato</option>";
                    for (let i in data.lista) {
                        opciones +=
                            '<option value="' +
                            data.lista[i].id +
                            '">' +
                            data.lista[i].nombre +
                            "</option>";
                    }
                    $('#plato').html(opciones).fadeIn();
                })
                .catch((error) => console.error(error));
        });
        let ruta_obtenerproductos = "{{ route('recetas.obtenerproductos') }}";
        $('#proveedor').change(function(e) {
            fetch(ruta_obtenerproductos, {
                    method: "POST",
                    body: JSON.stringify({
                        proveedor_id: e.target.value,
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
                    var opciones = "<option> Seleccionar producto</option>";
                    var precio = 0;
                    for (let i in data.lista) {
                        opciones +=
                            '<option value="' +
                            data.lista[i].id +
                            '">' +
                            data.lista[i].nombre +
                            "</option>";
                    }

                    $('#producto').html(opciones).fadeIn();
                })
                .catch((error) => console.error(error));
        });
        let ruta_obtenerprecio = "{{ route('recetas.obtenerprecio') }}";
        $('#producto').change(function(e) {
            fetch(ruta_obtenerprecio, {
                    method: "POST",
                    body: JSON.stringify({
                        producto_id: e.target.value,
                        proveedor_id: $('#proveedor').val()
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
                    /* console.log(data); */
                    console.log(data);
                    $('#precio').val(data);
                })
                .catch((error) => console.error(error));

        });
        cantidad.addEventListener('keyup', (e) => {
            subtotal.value = (cantidad.value * precio.value).toFixed(4);

        })
        $("#registrar").click(function() {
            console.log('hello');
        });
    });
</script>
<script>
    guardar.addEventListener("click", (e) => {
        if(cantidad.value != "" ){
            fetch(agregar_detalle, {
                method: "POST",
                body: JSON.stringify({
                    detallePlato: {
                        producto_id: producto.value,
                        proveedor_id:$('#proveedor').val(),
                        precio: precio.value,
                        cantidad: cantidad.value,
                        subtotal: subtotal.value,
                    },
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
                total_receta = 0;
                var opciones = "";
                for (let i in data.lista_receta) {
                    total_receta += parseFloat(
                        data.lista_receta[i].subtotal
                    );
                    opciones += "<tr>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].producto_nombre +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].precio +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].cantidad +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].subtotal, +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        '<button class="btn btn-danger" onclick="eliminar(' +
                        i +
                        ');"><i class="fas fa-trash"></i></button>' +
                        "</td>";
                    opciones += "</tr>";
                }
                opciones +=
                    "<tr>" +
                    '<td colspan="1" style="text-align: center;">Total costo plato </td>' +
                    '<td colspan="4" style="text-align: center;">Bs.' +
                    total_receta.toFixed(4) +
                    "</td>" +
                    "</tr>";

                document.getElementById("tbody").innerHTML = opciones;
                cantidad.value = 0;
                subtotal.value = 0;
            })
            .catch((error) => console.error(error));

        }else{
            alert('Debe ingresar una cantidad')
        }
        
    });
</script>
<script>
    function eliminar(i) {
        fetch(eliminar_detalle, {
                method: "POST",
                body: JSON.stringify({
                    data: i,
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
                total_receta = 0;
                var opciones = "";
                for (let i in data.lista_receta) {
                    total_receta += parseFloat(
                        data.lista_receta[i].subtotal
                    );
                    opciones += "<tr>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].producto_nombre +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].precio +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].cantidad +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        data.lista_receta[i].subtotal, +
                        "</td>";
                    opciones +=
                        '<td style="text-align: center;">' +
                        '<button class="btn btn-danger" onclick="eliminar(' +
                        i +
                        ');"><i class="fas fa-trash"></i></button>' +
                        "</td>";
                    opciones += "</tr>";
                }

                opciones +=
                    "<tr>" +
                    '<td colspan="1" style="text-align: center;">Total costo plato </td>' +
                    '<td colspan="4" style="text-align: center;">Bs.' +
                    total_receta.toFixed(4) +
                    "</td>" +
                    "</tr>";

                document.getElementById("tbody").innerHTML = opciones;
            });
    }
</script>
<script>
    btn_registrar_receta.addEventListener("click", (e) => {
        fetch(registrar_receta, {
                method: "POST",
                body: JSON.stringify({
                    plato_id: plato_id.value,
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
                if (data.success == true) {
                    iziToast.success({
                    title: "SUCCESS",
                    message: "Registro agregado exitosamente",
                    position: "topRight",
                    timeout: 1500,
                    onClosed: function () {
                       window.location.href = ruta_plato; 
                    },
                });
                }
            })
            .catch((error) => console.error(error));
    });
</script>
@endsection