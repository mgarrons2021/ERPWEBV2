@extends('layouts.app', ['activePage' => 'formulario', 'titlePage' => 'Formulario'])
@section('content')
@section('css')

@endsection

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Formulario Dosificacion </h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card ">                   
                    <div class="card-body">
                        <form class="mx-auto" method="POST" action="{{route('autorizacion.store')}}">
                            @csrf 
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">                                      
                       
           
                                <label for="exampleInputEmail1">Fecha Inicio</label>
                                <input type="date" class="form-control" name="fecha_inicial" id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Fecha Fin</label>
                                    <input type="date" class="form-control"  name="fecha_fin" id="exampleInputEmail1" required>
                                </div>                               
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nro de Autorizacion</label>
                                    <input type="number" class="form-control" name="nro_autorizacion" id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">NIT</label>
                                    <input type="number" class="form-control" name="nit"  id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-info" title="ACEPTAR" >    
                                </div>                               
                            </div>
                            <div class="col-lg-6">                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Factura</label>
                                    <input type="text" class="form-control" name="nro_factura" id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Llave</label>
                                    <input type="text" class="form-control" name="llave" id="exampleInputEmail1" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Estado</label>
                                    <input type="text" class="form-control"  name="estado" id="exampleInputEmail1" required>
                                </div>                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Sucursal</label>
                                    <select name="sucursal_id" class="form-control selectric">
                                        @foreach( $sucursales as $sucursal )
                                        <option value="{{$sucursal->id}}">{{$sucursal->nombre}}</option>                                     
                                        @endforeach
                                    </select>
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