@extends('layouts.app', ['activePage' => 'sucursales', 'titlePage' => 'Sucursales'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Modificar Departamento</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card card-primary">
                            <br>
                            <form action="{{ route('departamentos.update',$departamento->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="nombre" value="{{$departamento->nombre}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="descripcion">descripcion<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="descripcion" value="{{$departamento->descripcion}}" required>
                                        </div>

                                    </div>
                                    
                             

                                <div class="row">
                                    
                                    
                                  
                                    
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                        <a href="{{route('departamentos.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
                                    </div>
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
    </div>

</section>
@endsection