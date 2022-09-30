@extends('layouts.app', ['activePage' => 'keperis', 'titlePage' => 'Keperis'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Gestion Keperi</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                        <br>
                        <form action="{{ route('keperis.update',$keperi->id) }}" method="POST" class="form-horizontal">
                            @csrf
                            @method('PUT')
                            <div class="row ">

                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Fecha Corte<span class="required">*</span></label>
                                        <input type="date" class="form-control" name="fecha" value="{{$keperi->fecha}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha">Funcionario<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="nombre_usuario" value="{{$keperi->nombre_usuario}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cantidad_kilos">Cantidad Kilos<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="cantidad_kilos" value="{{$keperi->cantidad_kilos}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cantidad_crudo">Keperi en Crudo<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="cantidad_crudo" value="{{$keperi->cantidad_crudo}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cantidad_marinado">Keperi Marinado<span class="required">*</span></label>
                                        <input type="text" class="form-control" name="cantidad_marinado" value="{{$keperi->cantidad_marinado}}" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Temperatura Maxima Alcanzada<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="temperatura_maxima" value="{{$keperi->temperatura_maxima}}" step="any"  >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Veces Volcado<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="veces_volcado" value="{{$keperi->veces_volcado}}" step="any"  >
                                    </div>
                                </div>

                                
                                

                               

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Keperi Cocido<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="cantidad_cocido" value="{{$keperi->cantidad_cocido}}" step="any"  >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Keperi Cortado<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="cantidad_cortado" value="{{$keperi->cantidad_cortado}}" step="any" >
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="precio_producto">Keperi Enviado<span class="required">*</span></label>
                                        <input type="number" class="form-control" name="cantidad_enviado" value="{{$keperi->cantidad_enviado}}" step="any" required>
                                    </div>
                                </div>

                                
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                <a href="{{route('keperis.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                            </div>
                        </form>
                    </div>
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