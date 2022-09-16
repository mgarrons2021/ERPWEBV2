@extends('layouts.app', ['activePage' => 'personales', 'titlePage' => 'Personales'])

@section('content')
<section class="section">
    <div class="section-header">
        <h3 class="page__heading">Asignar Turno</h3>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12">
                <form action="{{ route('personales.assignTurn', $user->id) }}" method="POST" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="col-sm-12">
                                <h3 class="text-left">Asignar Turno A: {{$user->name}} {{$user->apellido}}</h3>
                                
                                <div class="form-group">
                                    <div class="tab-pane active">
                                        <br>
                                        <table class="table table-bordered table-md">

                                            {{-- Select for users loaded bro --}}
                                            {{-- <div class="form-group">
                                                <label for="tags" class="control-label">Users</label>
                                                <select name="tags" class="form-control" multiple="multiple" id="tags"></select>
                                            </div> --}}

                                            <thead>
                                                {!! Form::model($user, ['route' => ['personales.assignTurn', $user], 'method' => 'put']) !!}
                                                @foreach ($turnos as $turno)
                                                <tr>
                                                    <th>
                                                        <label class="form-check-label">
                                                            {!! Form::checkbox('turnos[]', $turno->id, null, ['class' => 'form-check-input ']) !!}
                                                            {{ $turno->turno }}
                                                        </label>
                                                    </th>
                                                </tr>
                                                @endforeach
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('personales.index') }}" class="btn btn-warning" style="color:white">Volver</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
{{-- <script type="text/javascript">
    $(document).ready(function () {   
        $('#tags').select2({
          
            tags: true,
            tokenSeparators: [','],
            ajax: {
                dataType: 'json',
                url: '{{ route("personales.obtenerUsuarios") }}',
                delay: 250,
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {
                  return {
                    results: data
                  };
                },
            }
           
        });
        
    });
</script> --}}
@endsection