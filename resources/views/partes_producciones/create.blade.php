@extends('layouts.app', ['activePage' => 'Pedidos Producion', 'titlePage' => 'Pedidos Produccion'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Registro Parte Produccion: {{$user->sucursals[0]->nombre}} </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="background-color: #6777ef;">
                        
                        <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                          
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plato">Producto<span class="required">*</span></label>
                                    <div class="selectric-hide-select">
                                        <select name="producto_id" class="form-control selectric" id="producto">
                                            <option value="x">Seleccione los Productos </option>
                                            @foreach($productos as $producto)
                                            
                                            <option value="{{$producto->id}}">{{$producto->nombre}}</option>
                                            
                                            @endforeach

                                        </select>
                                        <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="cantidad_solicitada">Cantidad*</label>
                                <input type="number" name="cantidad" id="cantidad_solicitada" class="form-control" value="">
                                <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                            </div>

                            <input type="hidden" id="producto_nombre" name="nombre" class="form-control" value="">
                            <input type="hidden" id="precio" name="precio_plato" class="form-control" value="" placeholder="Bs" readonly>
                            <input type="hidden" id="subtotal_solicitado" name="subtotal" class="form-control" value="" placeholder="Bs" readonly>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-success" id="agregar_insumo">Agregar Insumo</button>
                            </div>
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
                        <th style="text-align: center;">Cantidad a Registrar</th>
                        <th style="text-align: center;">Precio</th>
                        <th style="text-align: center;">Sub Total </th>

                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @php
                        $total =0;
                        @endphp
                        @if (session('partes_producciones'))
                        @foreach (session('partes_producciones') as $indice => $value)
                        <tr>

                            <td style="text-align: center;">{{$value['producto_nombre']}} </td>
                            <td style="text-align: center;"> {{ $value['cantidad_solicitada'] }}</td>
                            <td style="text-align: center;"> {{ $value['precio'] }}</td>

                            <td style="text-align: center;">{{ $value['subtotal'] }} Bs</td>
                            @php
                            $total += $value['subtotal'];
                            @endphp
                            <td style="text-align: center;">
                                <button class="btn btn-danger" onclick="eliminar({{ $indice }});"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                        <tr>
                            <td colspan="6" style="text-align: center;" class="table-info">Total: {{ number_format($total,3) }} Bs</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer">
            <div class=" text-center">
                <button type="button" class="btn btn-outline-info" id="guardar_pedido"> Registrar </button>
                <button type="button" class="btn btn-outline-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>
    
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ URL::asset('assets/js/partes_producciones/create.js') }}"> </script>
<script>
    let ruta_agregar_insumo = "{{ route('partes_producciones.agregarInsumo') }}";
    let ruta_obtener_precio = "{{route('partes_producciones.obtenerPrecios')}}"
    let ruta_guardar_pedido = "{{ route('partes_producciones.store') }}";
    let ruta_eliminar_insumo = "{{route('partes_producciones.eliminarInsumo') }}"; 
    let ruta_parte_producciones = "{{ route('partes_producciones.index') }}";
    
    



</script>
<script>
    $(document).ready(function() {
        $("#producto")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch( ruta_obtener_precio , {
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
            if (data.success== false) {
                iziToast.warning({
                    title: "WARNING",
                    message:
                        "El producto no cuenta con inventario . . . ",
                    position: "topCenter",
                    timeout: 1200,
                    onClosed() {
                        $("#plato")
                            .val("sin_seleccionar")
                            .trigger("change.select2");
                    },
                });
            } else {
                let precio=0;
                if(data.precio!=null){
                    precio=data.precio;
                }
                
                document.getElementById('producto_nombre').value=data.nombre;     
                document.getElementById("precio").value = precio;
                /* document.getElementById("unidad_medida").value =
                    unidad_medida; */

            }
        })
        .catch((error) => console.error(error));
        });
    });
</script>
@endsection