<div class="card">
    <div class="card-header">
        <h4>Seleccione la Fecha a Visualizar</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: hidden">
            <form action="{{ route('personales.filtrarEvaluacionUsuario',$user->id) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="input-daterange input-group" id="datepicker">
                            <span class="input-group-addon "><strong>Fecha De:</strong> </span>
                            <input type="date" id="fecha_inicial" class="input-sm form-control" name="fecha_inicial" value="" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <input class="form-control btn btn-primary" type="submit" value="Ver Evaluaciones" id="filtrar" name="filtrar">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>