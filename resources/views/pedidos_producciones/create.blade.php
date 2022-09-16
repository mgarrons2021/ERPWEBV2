@extends('layouts.app', ['activePage' => 'Pedidos Producion', 'titlePage' => 'Pedidos Produccion'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading"> Solicitud de Pedidos de Comida a CDP </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #6777ef;">
                                {{-- <h4 style="color:white;">Pedido: Nro {{$last_pedido}}. &nbsp;</h4> --}}
                                <h4 style="text-align:right;color:white;">Fecha: {{$fecha_actual}}</h4>
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
                                            <label for="plato">Menu del Dia<span class="required">*</span></label>
                                            <div class="selectric-hide-select">
                                                <select name="plato_id" class="form-control selectric" id="plato">
                                                    <option value="x">Seleccione los Platos </option>
        
                                                    @if(isset($menu_semanal->detalle_menus_semanales))
                                                    @foreach($menu_semanal->detalle_menus_semanales as $detalle)
                                                    @if( $detalle->plato->estado != 0 )
                                                    <option value="{{$detalle->plato->id}}">{{$detalle->plato->nombre}}</option>
                                                    @endif
                                                    @endforeach
                                                    @endif
        
        
                                                </select>
                                                <p class="text-left text-danger d-none" id="errorproducto">Debe seleccionar un producto</p>
                                            </div>
                                        </div>
                                    </div>
                                    
        
                                    <div class="col-md-6">
                                        <label for="cantidad_solicitada">Cantidad*</label>
                                        <input type="number" name="cantidad_solicitada" id="cantidad_solicitada" class="form-control" value="">
                                        <p class="text-left text-danger d-none" id="errorcantidad">Debe de ingresar una cantidad</p>
                                    </div>
        
                                    <input type="hidden" id="plato_nombre" name="plato_nombre" class="form-control" value="">
                                    <input type="hidden" id="precio" name="precio_plato" class="form-control" value="" placeholder="Bs" readonly>
                                    <input type="hidden" id="subtotal_solicitado" name="subtotal_solicitado" class="form-control" value="" placeholder="Bs" readonly>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-success" id="agregar_plato">Agregar Plato</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

            <div class="col-sm-4">
                <div class="card" style="height: 25.3rem ;">
                    <div class="card-header">
                        <a data-toggle="collapse" href="#collapseMenu" role="button" aria-expanded="false" aria-controls="collapseExample">
                            <i class="fa fa-lg"></i>
                        </a>
                        <h4> &nbsp Menu: {{ isset($menu_semanal->dia)?$menu_semanal->dia:'SI MENU'  }} </h4>
                    </div>
                    <div class="collapse" id="collapseMenu" style="overflow:scroll;">
                        <div class="card-body">
                            <div class="row">
                                <br><br>
                                <div class="table-responsive">
                                    <table class="table table-borderless  table-md">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="text-center">Plato </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if( isset($menu_semanal->detalle_menus_semanales) )
                                            @foreach ($menu_semanal->detalle_menus_semanales as $detalle)                                          
                                            <tr>
                                             
                                                <td class="text-center">{{ $detalle->plato->nombre}}</td>
                                               
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>                                             
                                                <td class="text-center">VACIO</td>                                               
                                            </tr>
                                            @endif
                                          
                                        </tbody>
                                    </table>
                                </div>
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

                        {{-- <th style="text-align: center;">Sucursal </th> --}}
                        <th style="text-align: center;">Plato</th>
                        <th style="text-align: center;">Cantidad Solicitada</th>
                        <th style="text-align: center;">Costo</th>
                        <th style="text-align: center;">Sub Total </th>

                        <th style="text-align: center;">Opciones</th>
                    </thead>
                    <tbody id="tbody">
                        @php
                        $total =0;
                        @endphp

                        @if (session('pedidos_producciones'))
                            @foreach (session('pedidos_producciones') as $indice => $value)
                            <tr>
                                <td style="text-align: center;">{{$value['plato_nombre']}} </td>
                                <td style="text-align: center;"> {{ $value['cantidad_solicitada'] }}</td>
                                <td style="text-align: center;"> {{ $value['costo'] }}</td>
                                <td style="text-align: center;">{{ $value['subtotal_solicitado'] }} Bs</td>
                                @php
                                    $total += $value['subtotal_solicitado'];
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
                <button type="button" class="btn btn-outline-info" id="guardar_pedido"> Registrar Pedido </button>
                <button type="button" class="btn btn-outline-danger" id="cancelar">Cancelar </button>
            </div>
        </div>
    </div>

</section>
@endsection
@section('scripts')
<script>
    let ruta_obtener_precio="{{ route('pedidos_producciones.obtenerPrecioPlato') }}";
    let ruta_agregar_plato = "{{ route('pedidos_producciones.agregarPlato') }}";
    let ruta_eliminar_plato = "{{ route('pedidos_producciones.eliminarPlato') }}";
    let ruta_obtener_costo = "{{route('pedidos_producciones.obtenerCosto')}}"

    let ruta_guardar_pedido = "{{ route('pedidos_producciones.store') }}";


    let ruta_pedidos = "{{ route('pedidos_producciones.index') }}";
</script>
<script>
    $(document).ready(function() {
        $("#plato")
        .select2({
            placeholder: "Seleccione una opcion",
        })
        .on("change", function (e) {
            fetch( ruta_obtener_costo , {
                method: "POST",
                body: JSON.stringify({
                    plato_id: e.target.value,
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
                        "El plato no cuenta con inventario . . . ",
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
                
                document.getElementById('plato_nombre').value=data.nombre;     
                document.getElementById("precio").value = precio;
                /* document.getElementById("unidad_medida").value =
                    unidad_medida; */

            }
        })
        .catch((error) => console.error(error));
        });
    });
</script>
<script type="text/javascript" src="{{ URL::asset('assets/js/pedidos_producciones/create.js') }}"> </script>
@endsection
@section('page_css')
<style>
    [data-toggle="collapse"] .fa:before {
        content: "\f13a";
    }

    [data-toggle="collapse"].collapsed .fa:before {
        content: "\f139";
    }
</style>
@endsection