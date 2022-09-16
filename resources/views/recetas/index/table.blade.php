<table class="table table-striped mt-15" id="table">
    <thead class="bg-primary">
        <th class="text-center" style="color: #fff;">Plato</th>
        <th class="text-center" style="color: #fff;">Categoria</th>
        <th></th>
    </thead>
    <tbody>
        @foreach ($recetas as $receta)
        <tr>
            <td class="text-center">
                <a href="{{route('recetas.show', $receta->id)}}">{{$receta->plato->nombre}} </a>
            </td>

            <td class="text-center">{{$receta->plato->categoria_plato->nombre}}</td>
            <td>
                <div class="dropdown" style="position: absolute;">
                    <a href="#" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item " href="">Editar</a></li>
                        <li>
                            <form action="" id="formulario-eliminar2" class="formulario-eliminar" method="POST">
                                @csrf
                                @method('Delete')
                                <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('formulario-eliminar2').submit()" id="enlace">Eliminar</a>
                            </form>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>