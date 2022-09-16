@extends('layouts.app', ['activePage' => 'categoria_plato', 'titlePage' => 'Categoria Plato'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Gestion de Carne de Keperi</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <form action="{{ route('keperis.store') }}" method="POST" class="form-horizontal">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre_usuario"> Nombre Usuario <span class="required">*</span></label>
                                <input type="text" class="form-control  @error('nombre_usuario') is-invalid @enderror" id="nombre_usuario" name="nombre_usuario" step="any" >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cantidad_kilos"> Peso Inicial <span class="required">*</span></label>
                                <input type="number" class="form-control  @error('cantidad_kilos') is-invalid @enderror" id="cantidad_kilos" name="cantidad_kilos" step="any" placeholder="0,00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for=""> Inv Actual <span class="required">*</span></label>
                                <input type="number" class="form-control  @error('peso_inicial') is-invalid @enderror" id="" name="" step="any" readonly placeholder="0,00">
                            </div>
                        </div>
                        
                    </div>
                </div>


                <div class="card">
                    
                   

                    <div class="card-body">
                        <br>
                            @csrf

                            <div class="row">

                                
                                <div class="col-md-8">
                                    <div class="form-group">
                                    <label for="cantidad_crudo"> Keperi en Crudo <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_crudo') is-invalid @enderror" id="cantidad_crudo" name="cantidad_crudo" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                          
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_marinado"> Keperi Marinado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_marinado') is-invalid @enderror" id="cantidad_marinado" name="cantidad_marinado" step="any" placeholder="0,00">
                                </div>
                            </div>
                            

                        </div>
                           
                        <div class="row">

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="cantidad_sellado"> Keperi Cocido <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_sellado') is-invalid @enderror" id="cantidad_sellado" name="cantidad_cocido" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="cantidad_sellado"> Keperi Sellado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_sellado') is-invalid @enderror" id="cantidad_sellado" name="cantidad_sellado" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cantidad_enviado"> Keperi Enviado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('cantidad_enviado') is-invalid @enderror" id="cantidad_enviado" name="cantidad_enviado" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                        </div>
                            
                            
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">Registrar Keperi</button>
                                <a class="btn btn-danger" href="{{route('keperis.index')}}">Volver</a>
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