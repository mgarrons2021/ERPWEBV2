@extends('layouts.app', ['activePage' => 'platos', 'titlePage' => 'Platos'])
@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Lets edit some food bro</h3>
    </div>
    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <div align="center">
                @if(isset($plato->imagen))
                    <img id="imagenPrevisualizacion" src="{{url($plato->imagen) }}" width="150" height="130" />
                @else
                <img id="imagenPrevisualizacion"  src="{{url('img/no-image.jpeg')}}" style="border-radius:15px" width="150" height="130" />
                @endif
                </div>
                <form method="POST" action="{{route('platos.update', $plato->id)}}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <h6 class="card-title">Nombre Plato</h6>
                        <input type="text" class="form-control  @error('nombre') is-invalid @enderror" name="nombre" value="{{$plato->nombre}}">
                        @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <h6><label for="exampleFormControlInput1" class="form-label">Imagen</label></h6>
                        <input type="file" id="seleccionArchivos" class="form-control @error('descripcion') is-invalid @enderror" name="imagen">
                        @error('imagen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="row">
                     

                        <div class="col-md-6">
                            <h6 class="card-title">Unidad Medida Venta</h6>
                            <select class="form-select" aria-label="Default select example" name="unidad_medida_venta_id">
                                @foreach($um_ventas as $um_venta)
                                <option value="{{$um_venta->id}}">{{$um_venta->nombre}}</option>
                                @endforeach
                            </select>
                        </div> <br>
                        <div class="col-md-6">
                            <h6 class="card-title">Unidad Medida Compra</h6>
                            <select class="form-select" aria-label="Default select example" name="unidad_medida_compra_id">
                                @foreach($um_compras as $um_compra)
                                <option value="{{$um_compra->id}}">{{$um_compra->nombre}}</option>
                                @endforeach
                            </select>
                        </div> <br>
                    </div>
                    <div class="row">


                      

                        <div class="col-md-6">

                            <h6 class="card-title">Estado</h6>
                            <div class="selectric-hide-select">
                                <select name="estado" class="form-control selectric">
                                    <option value="1">Ofertado</option>
                                    <option value="0">De Baja</option>
                                </select>
                            </div>
                            <!-- <input type="text" class="form-control" name="estado"> -->

                        </div>
                    </div> <br>


                    <input type="submit" class="btn btn-success" value="Actualizar">
                    <a href="{{route('platos.index')}}" class="btn btn-danger btn-xs">Volver</a>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
@section('page_js')
<script>
    const $seleccionArchivos = document.querySelector("#seleccionArchivos"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacion");
    $seleccionArchivos.addEventListener("change", () => {
        const archivos = $seleccionArchivos.files;
        if (!archivos || !archivos.length) {
            $imagenPrevisualizacion.src = "";
            return;
        }
        const primerArchivo = archivos[0];
        const objectURL = URL.createObjectURL(primerArchivo);
        $imagenPrevisualizacion.src = objectURL;
    });
</script>
@endsection
@endsection
@section('css')
<style>
    input[type=button] {
        color: white;
        font-family: Lato;
        padding-left: auto;
        padding-right: auto;
        text-align: center;
        font-size: 18px;
        border-style: solid;
        border-width: thin;
        border-color: rgb(193, 218, 214);
        border-radius: 3px;
    }
</style>

@endsection