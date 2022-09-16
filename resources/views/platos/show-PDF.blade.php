<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detalles del Plato</title>
    <Style>
        body {

            font-family: Arial;
        }

        #main-container {
            margin: 150px auto;
            width: 600px;
        }

        table {
            background-color: white;
            text-align: left;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: center;

        }

        thead {
            background-color: #246355;
            border-bottom: solid 1px #0F362D;
            color: white;
        }


        tr:hover td {
            background-color: #369681;
            color: white;
        }

        .card-header {
            text-align: center;
        }

        .foot1 {
            color: black;
            font-weight: bold;
        }

        .foot2 {
            color: black;
            font-weight: bold;
        }

        .table_pie {
            background-color: #D5DBDB;
        }

        #myImg {
            margin: auto;
            display: block;


            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 70px;
            padding-bottom: 1px;
        }

        .imagen {
            border-radius: 50px;
            width: 28%;
            height: 25%
        }

        .contenedor-img {
            text-align: center;
        }
        .content{
            text-align: center;
        }        
    </Style>
</head>

<body>
    <div class="card">
        <div class="card-header">
            <h2> Datos Generales del Plato</h2>
        </div>
        <div class="card-body">
            <div class="contenedor-img">
                @if($plato->imagen!=null && $plato->imagen!='')
                <img id="myImg" src="{{url($plato->imagen) }}" alt="" class="imagen">
                @else
                <h3 style="color: #b1b8bf"> Sin imagen </h3>
                @endif
            </div>
            <div class="content">
                <h5 class="card-title">Nombre del Plato: {{$plato->nombre}}</h5>
                <p class="card-text">Categoria plato : {{ $plato->categoria_plato->nombre }}</p>
                <p class="card-text">
                    <small class="text-muted">
                        @if($plato->estado == 1)
                        <div> <span class="badge badge-success"> Ofertado</span></div>
                        @else
                        <div> <span class="badge badge-warning">De Baja</span></div>
                        @endif
                    </small>
            </div>

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Receta del Plato : {{$plato->nombre}}</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <th class="text-center"> Producto </th>
                    <th class="text-center"> Precio </th>
                    <th class="text-center"> U.M. </th>
                    <th class="text-center"> Cantidad </th>
                    <th class="text-center"> Subtotal </th>
                </thead>
                <tbody>
                    @if(isset($recetas[0]))
                    @foreach($recetas as $receta )
                    <tr>
                        <td class="text-center table-light"> {{$receta->productoProveedor->producto->nombre}} </td>
                        <td class="text-center"> {{$receta->productoProveedor->precio}} </td>
                        <td class="text-center table-light">
                            @if(isset($receta->productoProveedor->producto->unidad_medida_compra->nombre))
                            {{$receta->productoProveedor->producto->unidad_medida_compra->nombre}}
                            @else
                            Sin U.M.
                            @endif
                        </td>
                        <td class="text-center"> {{$receta->cantidad}} </td>
                        <td class="text-center"> Bs. {{$receta->subtotal}} </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
                <tfoot class="table_pie">
                    <tr>
                        <td colspan="4" class="foot1">Costo del Plato</td>
                        <td class="foot2"> Bs. {{$plato->costo_plato}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>