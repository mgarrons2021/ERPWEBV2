<div class="col-lg-12">
    <div class="card">
        <div class="card-body text-white bg-primary">
            <div class=" mensaje">
                <p class="leyenda text-center" style="font-size: 15px;"> Parametro Expectativas: <br>
                 Donde 1 = Muy por debajo, &nbsp
                    2 = Ligeramente por debajo,&nbsp
                    3 = Cumple,&nbsp
                    4 = Por encima ,&nbsp
                    5 = Muy por encima.&nbsp
                </p>
            </div>
        </div>
    </div>

</div>
<div class="col-lg-12 ">
    <form id="regForm">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>

        <div class="tab">
            <div class="card border">
                <div class="card-header">
                    <h4> Criterio Comunicacion (Amabilidad) </h4>
                </div>
                <div class="card-body">

                    <table class="table">
                        @foreach($evaluaciones_user as $evaluacion_user)
                        @if($evaluacion_user->evaluacion->categoria == 'comunicacion' )
                        <thead class="table">
                            <th class="text-center"> {{$evaluacion_user->evaluacion->nombre}}</th>
                            @if($evaluacion_user->puntaje > 4)
                            <td class="text-center table-light">
                                <div class="badge badge-success">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                            </td>
                            @elseif($evaluacion_user->puntaje > 2 && $evaluacion_user->puntaje <= 4 ) <td class="text-center table-light" >
                                <div class="badge bg-warning">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                                </td>
                                @else
                                <td class="text-center table-light ">
                                    <div class="badge badge-danger">Puntaje: {{$evaluacion_user->puntaje}} /5 </div>
                                </td>
                                @endif
                        </thead>
                        @endif
                        @endforeach

                    </table>
                    @if(isset($evaluador))
                    <p class="text-center"> Evaluado por: {{$evaluador[0]->name}} {{$evaluador[0]->apellido}} </p>
                    @endif
                </div>
            </div>
        </div>
        <!-- tab -->
        <div class="tab">
            <div class="card border">
                <div class="card-header">
                    <h4> Criterio Coordinación (Orden y limpieza) </h4>

                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach($evaluaciones_user as $evaluacion_user)
                        @if($evaluacion_user->evaluacion->categoria == 'coordinacion' )
                        <thead class="table">
                            <th class="text-center"> {{$evaluacion_user->evaluacion->nombre}}</th>
                            @if($evaluacion_user->puntaje > 4)
                            <td class="text-center table-light">
                                <div class="badge badge-success">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                            </td>
                            @elseif($evaluacion_user->puntaje > 2 && $evaluacion_user->puntaje <= 4 ) <td class="text-center table-light">
                                <span class="badge bg-warning">Puntaje: {{$evaluacion_user->puntaje}} /5</span></td>
                                @else
                                <td class="text-center table-light">
                                    <div class="badge badge-danger">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                                </td>
                                @endif
                        </thead>
                        @endif
                        @endforeach
                    </table>
                    @if(isset($evaluador))
                    <p class="text-center"> Evaluado por: {{$evaluador[0]->name}} {{$evaluador[0]->apellido}} </p>
                    @endif
                </div>
            </div>

        </div>
        <!-- tab -->
        <div class="tab">
            <div class="card border">
                <div class="card-header">
                    <h4> Criterio Cooperación </h4>

                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach($evaluaciones_user as $evaluacion_user)
                        @if($evaluacion_user->evaluacion->categoria == 'cooperacion' )
                        <thead class="table">
                            <th class="text-center"> {{$evaluacion_user->evaluacion->nombre}}</th>
                            @if($evaluacion_user->puntaje > 4)
                            <td class="text-center table-light" >
                                <div class="badge badge-success">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                            </td>
                            @elseif($evaluacion_user->puntaje > 2 && $evaluacion_user->puntaje <= 4 ) <td class="text-center table-light">
                                <span class="badge bg-warning">Puntaje: {{$evaluacion_user->puntaje}} /5</span></td>
                                @else
                                <td class="text-center table-light">
                                    <div class="badge badge-danger">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                                </td>
                                @endif
                        </thead>
                        @endif
                        @endforeach
                    </table>
                    @if(isset($evaluador))
                    <p class="text-center"> Evaluado por: {{$evaluador[0]->name}} {{$evaluador[0]->apellido}} </p>
                    @endif
                </div>
            </div>

        </div>
        <!-- tab -->
        <div class="tab">
            <div class="card border">
                <div class="card-header">
                    <h4> Criterio Conocimiento (Cumplimiento) </h4>

                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach($evaluaciones_user as $evaluacion_user)
                        @if($evaluacion_user->evaluacion->categoria == 'conocimiento' )
                        <thead class="table">
                            <th class="text-center"> {{$evaluacion_user->evaluacion->nombre}}</th>
                            @if($evaluacion_user->puntaje > 4)
                            <td class="text-center table-light">
                                <div class="badge badge-success">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                            </td>
                            @elseif($evaluacion_user->puntaje > 2 && $evaluacion_user->puntaje <= 4 ) <td class="text-center table-light">
                                <span class="badge bg-warning">Puntaje: {{$evaluacion_user->puntaje}} /5</span></td>
                                @else
                                <td class="text-center table-light">
                                    <div class="badge badge-danger">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                                </td>
                                @endif
                        </thead>
                        @endif
                        @endforeach
                    </table>
                    @if(isset($evaluador))
                    <p class="text-center"> Evaluado por: {{$evaluador[0]->name}} {{$evaluador[0]->apellido}} </p>
                    @endif
                </div>
            </div>
        </div>
        <!-- tab -->
        <div class="tab"> 
            <div class="card border">
                <div class="card-header">
                    <h4> Criterio Compromiso </h4>

                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach($evaluaciones_user as $evaluacion_user)
                        @if($evaluacion_user->evaluacion->categoria == 'compromiso' )
                        <thead class="table table-bordered">
                            <th class="text-center"> {{$evaluacion_user->evaluacion->nombre}}</th>
                            @if($evaluacion_user->puntaje > 4)
                            <td class="text-center table-light">
                                <div class="badge badge-success">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                            </td>
                            @elseif($evaluacion_user->puntaje > 2 && $evaluacion_user->puntaje <= 4 ) <td class="text-center table-light">
                                <span class="badge bg-warning">Puntaje: {{$evaluacion_user->puntaje}} /5</span></td>
                                @else
                                <td class="text-center table-light">
                                    <div class="badge badge-danger">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                                </td>
                                @endif
                        </thead>
                        @endif
                        @endforeach
                    </table>
                    @if(isset($evaluador))
                    <p class="text-center"> Evaluado por: {{$evaluador[0]->name}} {{$evaluador[0]->apellido}} </p>
                    @endif
                </div>
            </div>

        </div>
        <!-- tab -->
        <div class="tab">
            <div class="card border">
                <div class="card-header">
                    <h4> Criterio Carisma al cliente </h4>

                </div>
                <div class="card-body">
                    <table class="table">
                        @foreach($evaluaciones_user as $evaluacion_user)
                        @if($evaluacion_user->evaluacion->categoria == 'carisma al cliente' )
                        <thead class="table">
                            <th class="text-center"> {{$evaluacion_user->evaluacion->nombre}}</th>
                            @if($evaluacion_user->puntaje > 4)
                            <td class="text-center table-light">
                                <div class="badge badge-success">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                            </td>
                            @elseif($evaluacion_user->puntaje > 2 && $evaluacion_user->puntaje <= 4 ) <td class="text-center table-light">
                                <span class="badge bg-warning">Puntaje: {{$evaluacion_user->puntaje}} /5</span></td>
                                @else
                                <td class="text-center table-light">
                                    <div class="badge badge-danger">Puntaje: {{$evaluacion_user->puntaje}} /5</div>
                                </td>
                                @endif
                        </thead>
                        @endif
                        @endforeach
                    </table>
                    @if(isset($evaluador))
                    <p class="text-center"> Evaluado por: {{$evaluador[0]->name}} {{$evaluador[0]->apellido}} </p>
                    @endif
                </div>
            </div>
        </div>
    </form>

    <div style="" id="nextprevious" align="center">
        <div>
            <button type="button" id="prevBtn" onclick="nextPrev(-1)" class="btn btn-danger">Anterior </i></button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)" class="btn btn-primary">Siguiente </button>
        </div>
    </div>
</div>