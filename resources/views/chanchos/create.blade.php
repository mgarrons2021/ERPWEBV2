@extends('layouts.app', ['activePage' => 'categoria_plato', 'titlePage' => 'Categoria Plato'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Control de Calidad: Chancho</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <form action="{{ route('chanchos.store') }}" method="POST" class="form-horizontal">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Informacion General</h4>
                    </div>
                    <div class="card-header">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="usuario"> Nombre Usuario <span class="required">*</span></label>
                                <input type="text" class="form-control  @error('usuario') is-invalid @enderror" id="usuario" name="usuario" step="any" >
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="costilla_kilos"> Costilla Kilos <span class="required">*</span></label>
                                <input type="number" class="form-control  @error('costilla_kilos') is-invalid @enderror" id="costilla_kilos" name="costilla_kilos" step="any" placeholder="0,00">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="pierna_kilos"> Pierna Kilos <span class="required">*</span></label>
                                <input type="number" class="form-control  @error('pierna_kilos') is-invalid @enderror" id="pierna_kilos" name="pierna_kilos" step="any" placeholder="0,00">
                            </div>
                        </div>

                        
                        
                    </div>
                </div>


                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Informacion Costilla</h4>
                    </div>
                    
                    <div class="card-body">
                        <br>
                            @csrf

                            <div class="row">   
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="costilla_marinado"> Costilla Marinado  <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('costilla_marinado') is-invalid @enderror" id="costilla_marinado" name="costilla_marinado" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="costilla_horneado"> Costilla Horneado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('costilla_horneado') is-invalid @enderror" id="costilla_horneado" name="costilla_horneado" step="any" placeholder="0,00">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="costilla_cortado"> Costilla Cortado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('costilla_cortado') is-invalid @enderror" id="costilla_cortado" name="costilla_cortado" step="any" placeholder="0,00">
                                </div>
                            </div>

                        </div> 
                    </div>
                </div>


                <div class="card">
                    <div class="card-header" style="justify-content:center ;">
                        <h4>Informacion Pierna</h4>
                    </div>
                    
                    <div class="card-body">
                        <br>
                            @csrf

                            <div class="row">

                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label for="pierna_marinado"> Pierna Marinado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('pierna_marinado') is-invalid @enderror" id="pierna_marinado" name="pierna_marinado" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                          
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pierna_horneado"> Pierna Horneado <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('pierna_horneado') is-invalid @enderror" id="pierna_horneado" name="pierna_horneado" step="any" placeholder="0,00">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pierna_cortada"> Pierna Cortado  <span class="required">*</span></label>
                                    <input type="number" class="form-control  @error('pierna_cortada') is-invalid @enderror" id="pierna_cortada" name="pierna_cortada" step="any" placeholder="0,00">
                                </div>
                            </div>
                            
                        </div>

                        <label for="chancho_enviado"> Lechon Cortado <span >*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Kg</span></div>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="lechon_cortado" step="any">
                            <div class="input-group-append"><span class="input-group-text">.00</span></div>
                        </div>

                        <label for="chancho_enviado"> Chancho Enviado  <span >*</span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">Kg</span></div>
                            <input type="number" class="form-control" aria-label="Amount (to the nearest dollar)" name="chancho_enviado" step="any">
                            <div class="input-group-append"><span class="input-group-text">.00</span></div>
                        </div>
                                  
                    </div>
                     

                </div>

                    <div class="col-md-6">
                        <button type="submit" class="btn btn-primary">Registrar Chancho</button>
                        <a class="btn btn-danger" href="{{route('chanchos.index')}}">Volver</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    </div>

</section>
@endsection