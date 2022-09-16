@extends('layouts.app', ['activePage' => 'formulario', 'titlePage' => 'Formulario'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Verificar Codigo Control </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-body">
                        <form class="mx-auto" method="POST" action="{{route('autorizacion.store')}}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">


                                        <label for="exampleInputEmail1">Fecha </label>
                                        <input type="text" class="form-control" name="fecha" id="fecha" >
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nro de Autorizacion</label>
                                        <input type="number" class="form-control" name="nro_autorizacion" id="nro_autorizacion" value="{{$autorizacion->nro_autorizacion}}" >
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Factura</label>
                                        <input type="text" class="form-control" name="nro_factura" id="nro_factura" value="{{$autorizacion->nro_factura}}" >
                                    </div>


                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Nit</label>
                                        <input type="text" class="form-control" name="nit_ci" id="nit" value="{{$autorizacion->nit}}" >
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Monto</label>
                                        <input type="text" class="form-control" name="monto" id="monto" >
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Llave</label>
                                        <input type="text" class="form-control" name="llave" id="llave" value="{{$autorizacion->llave}}" >
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Codigo Verificacion</label>
                                        <input type="text" class="form-control" name="" value="" id=codigo_verificado>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="button" class="btn btn-primary" id="generar_codigo">Generar Codigo</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
@section('page_js')
<script type="module" src="{{ URL::asset('assets/js/servicios/CodigoControl.js') }}"> </script>

@endsection
@endsection