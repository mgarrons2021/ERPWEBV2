<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DONESCO</title>
    <style>
        .contenedor {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hijo {
            width: auto;
            height: auto;
            background-color: black;
            color: white;
            padding: 30px;
            border-radius: 5%;
        }
    </style>
</head>

<body>

    <div class="contenedor">
        <div class="hijo">
            <h1 style="text-align: center;margin:5px;color:white;">DONESCO S.R.L.</h1>
            <h2><b>Producto : </b></h2> <span>{{$nombre}}</span>
            <h2><b>Precio anterior : </b></h2> <span>{{$precioanterior}} bs.</span>
            <h2><b>Nuevo precio : </b></h2> <span>{{$precionuevo}} bs.</span>
            <h3 style="text-align: center;margin-top:15px;background-color: green;color:white;padding:5px;border-radius:10px;">PRECIO ACTUALIZADO</h3>
        </div>
    </div>

</body>

</html>