@extends('layouts.app', ['activePage' => 'productos_proveedores', 'titlePage' => 'productos_proveedores'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Formulario de Solicitud de Cambio de Precio</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>


                        <input type="hidden" value="{{$producto_proveedor->producto_id}}" id="producto" />
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha">Fecha<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="fecha" value="{{$producto_proveedor->fecha}}" readonly>
                                    <input type="hidden" class="form-control" id="producto_proveedor_id" name="producto_proveedor_id" value="{{$producto_proveedor->id}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proveedor">Proveedor<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="proveedor" value="{{$producto_proveedor->proveedor->nombre}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="producto">Producto<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="producto" value="{{$producto_proveedor->producto->nombre}}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio_actual">Precio Actual<span class="required">*</span></label>
                                    <input type="number" class="form-control" name="precio_actual" id="precioanterior" value="{{$producto_proveedor->precio}}" step="any" readonly required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="precio_nuevo">Ingrese el Nuevo Precio<span class="required">*</span></label>
                                    <input type="number" class="form-control" name="precio_nuevo" id="precionuevo" value="" step="any" placeholder="Ingrese el Nuevo Precio">
                                    <p class="text-left text-danger d-none" id="errorprecio">Debe ingresar un precio determinado</p>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="motivo">Motivo de Cambio<span class="required">*</span></label>
                                    <input type="text" class="form-control" name="motivo" value="" step="any" id="motivo" placeholder="Ingrese el Motivo">
                                    <p class="text-left text-danger d-none" id="errormotivo">Debe ingresar el motivo del cambio</p>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-info" id="solicitar">Solicitar</button>
                            <a href="{{route('productos_proveedores.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                        </div>
                    </div>
                </div>
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
    const csrfToken = document.head.querySelector(
        "[name~=csrf-token][content]"
    ).content;
    let producto_proveedor_id = document.getElementById('producto_proveedor_id');
    let enviarsolicitud = document.getElementById('solicitar');
    let producto = document.getElementById('producto');
    let precionuevo = document.getElementById('precionuevo');
    let precioanterior = document.getElementById('precioanterior');
    let motivo = document.getElementById('motivo');
    let ruta = "{{route('mail.sendEmail')}}";
    let rutaindex= "{{route('productos_proveedores.index')}}";
    let json_data;
    enviarsolicitud.addEventListener("click", function() {
        
        if(precionuevo.value==""){
            $('#errorprecio').removeClass("d-none");;
        }else{
            $('#errorprecio').addClass('d-none');            
        }

        if(motivo.value==""){
            $('#errormotivo').removeClass('d-none');
        }else{
            $('#errormotivo').addClass('d-none');            
        }

        if(motivo.value!="" && precionuevo.value!=""){

            $('#solicitar').addClass('disabled');

            json_data = {
            "_token": "{{ csrf_token() }}",
            "producto_proveedor_id": producto_proveedor_id.value,
            "producto": producto.value,
            "precionuevo": precionuevo.value,
            "precioanterior": precioanterior.value,
            "motivo": motivo.value,
        }
        $.ajax({
            type: "POST", // la variable type guarda el tipo de la peticion GET,POST,..
            url: ruta, //url guarda la ruta hacia donde se hace la peticion
            headers: {
                'X-CSRFToken': csrfToken
            },
            data: JSON.stringify(json_data), // data recive un objeto con la informacion que se enviara al servidor
            contentType: 'application/json',
            //dataType: dataType // El tipo de datos esperados del servidor. Valor predeterminado: Intelligent Guess (xml, json, script, text, html).
            success: function(datos) { //success es una funcion que se utiliza si el servidor retorna informacion
                console.log('Result - '+datos);
                if(datos==1){
                    iziToast.success({
                        title: "SUCCESS",
                        message: "La solicitud se hizo correctamente !",
                        position: "topRight",
                        timeout: 1100,
                        onClosed: function () {
                            window.location.href = rutaindex;
                        },
                    });
                }else{
                    iziToast.warning({
                        title: "AVISO",
                        message: "Problemas al enviar la solicitud de cambio de precio",
                        position: "topCenter",
                        timeout: 1500,                        
                    });
                }
                          
            },
        })

        }

        
    });
</script>
@endsection