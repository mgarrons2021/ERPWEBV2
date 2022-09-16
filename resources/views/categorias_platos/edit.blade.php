@extends('layouts.app', ['activePage' => 'categorias_platos', 'titlePage' => 'Categoria Plato'])

@section('content')

<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Editar Categoria Plato</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-body">
                            <br>
                            <form action="{{ route('categorias_platos.update',$categoria_plato->id) }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                <div class="row ">
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre<span class="required">*</span></label>
                                            <input type="text" class="form-control" name="nombre" value="{{$categoria_plato->nombre}}" required>
                                        </div>

                                    </div>
                                    
                             

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="estado">Estado<span class="required">*</span></label>
                                                <div class="selectric-hide-select">
                                                    <select name="estado" class="form-control selectric">
                                                        @if($categoria_plato->estado===1)
                                                        <option value="1" selected>Activo</option>
                                                        <option value="0">Inactivo</option>
                                                        @endif
                                                        @if($categoria_plato->estado===0)
                                                        <option value="1">Activo</option>
                                                        <option value="0" selected>Inactivo</option>
                                                        @endif
                                                    </select>
                                                </div>
                                               
                                            </div>
                                        </div>


                                        
                                    </div>
                                    <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary" tabindex="7">Guardar</button>
                                            <a href="{{route('categorias_platos.index')}}" class="btn btn-danger" tabindex="8">Cancelar</a>
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