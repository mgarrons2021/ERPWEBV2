<html>

<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
    <link rel="shortcut icon" href="../public/img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Registro Asistencia</title>
    <style>
        body {
            background-color: #FFFFFF;
            font-family: 'Ubuntu', sans-serif;
        }

        .logo {
            background-color: #FFFFFF;
            width: 400px;
            margin: 4em auto;
            display: absolute;
            text-align: center;
            border-radius: 1.5em;
            padding-top: 50px;
        }

        .main {
            background: #FFFFFF;
            width: 400px;
            height: 500px;
            margin: 2em auto;
            border-radius: 1.5em;
            display: relative;
            box-shadow: 0px 11px 35px 2px rgba(0, 0, 0, 0.14);
        }

        .sign {
            padding-top: 40px;
            color: #002c3e;
            font-family: 'Ubuntu', sans-serif;
            font-weight: bold;
            font-size: 23px;
            padding-top: 0;
        }

        .un {
            width: 76%;
            color: rgb(38, 50, 56); 
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            background: rgba(136, 126, 126, 0.04);
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            outline: none;
            box-sizing: border-box;
            border: 2px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 50px;
            margin-left: 46px;
            text-align: center;
            margin-bottom: 27px;
            font-family: 'Ubuntu', sans-serif;
        }

        form.form1 {
            padding-top: 40px;
        }

        .pass {
            width: 76%;
            color: rgb(38, 50, 56);
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            background: rgba(136, 126, 126, 0.04);
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            outline: none;
            box-sizing: border-box;
            border: 2px solid rgba(0, 0, 0, 0.02);
            margin-bottom: 50px;
            margin-left: 46px;
            text-align: center;
            margin-bottom: 27px;
            font-family: 'Ubuntu', sans-serif;
        }


        .un:focus,
        .pass:focus {
            border: 2px solid rgba(0, 0, 0, 0.18) !important;

        }

        .submit {
            cursor: pointer;
            border-radius: 5em;
            color: #fff;
            background: #0097a7;
            border: 0;
            padding-left: 40px;
            padding-right: 40px;
            padding-bottom: 10px;
            padding-top: 10px;
            font-family: 'Ubuntu', sans-serif;
            margin-left: 35%;
            font-size: 13px;
            box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
        }
        .submit:hover{
            background: #006978;
        }

        .forgot {
            text-shadow: 0px 0px 3px rgba(117, 117, 117, 0.12);
            color: #E1BEE7;
            padding-top: 15px;
        }

        #contenedor {
            text-align: center;
            grid-template-columns: 2fr 2fr 2fr;
            justify-content: center;
        }

        #caja1,
        #caja2,
        #caja3 {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            padding-top: 3%;
            width: 40px;
            height: 22px;
            font-size: 15px;
            border-radius: 0.9rem;
            box-shadow: 6px 10px 15px 1px rgb(8, 0, 0, 0.507);
        }

        #caja1 {
            background-color: #002c3e;
            color: azure;
            border-bottom: 10px solid #002c3e;
        }

        #caja2 {
            background-color: #002c3e;
            color: azure;
            border-bottom: 10px solid #002c3e;
        }

        #caja3 {
            background-color: #002c3e;
            color: azure;
            border-bottom: 10px solid #022431;
        }
    </style>
</head>

<body>


    <div class="main">
        <div class="logo">
            <img class="" src="{{ asset('img/LogoDonesco.png') }}" width=" 300px">
        </div>
        <p class="sign" align="center">Registro de Asistencia</p>
        <div id="contenedor">
            <div id="caja1">
                <label id="hora"></label>
            </div>
            <div id="caja2">
                <label id="minuto"></label>
            </div>
            <div id="caja3">
                <label id="segundo"></label>
            </div>
        </div>
        <form action="{{ route('personales.marcar_asistencia') }}" method="POST" class="form1">
          {{--   @csrf --}}
            <input class="un" type="number" align="center" name="codigo" placeholder="Codigo de Usuario">
            <br><br>
            <button class="submit" align="center">Marcar</button>
        </form>
    </div>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    @if (session('mensaje') == 'Registro de Ingreso Exitoso')
    <script>
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Registro de Ingreso Exitoso',
            showConfirmButton: true,
            timer: 2500
        })
    </script>
    @endif

    @if (session('mensaje') == 'Registro de Salida Exitoso')
    <script>
        Swal.fire({
            position: 'top-center',
            icon: 'success',
            title: 'Registro de Salida Exitoso',
            showConfirmButton: true,
            timer: 2500
        })
    </script>
    @endif

    @if (session('mensaje') == 'Ya Registro de Salida y Entrada Exitoso')
    <script>
        Swal.fire({
            position: 'top-center',
            icon: 'warning',
            title: 'Ya Registro Entrada y Salida',
            showConfirmButton: true,
            timer: 2500
        })
    </script>
    @endif

    @if (session('mensaje') == 'Codigo de Usuario Incorrecto')
    <script>
        Swal.fire({
            position: 'top-center',
            icon: 'error',
            title: 'Codigo de Usuario Incorrecto',
            showConfirmButton: true,
            timer: 2500
        })
    </script>
    @endif
    <script>
        window.addEventListener('load', () => {
            let horaHTML = document.getElementById('hora')
            let minutoHTML = document.getElementById('minuto')
            let segundoHTML = document.getElementById('segundo')

            const mostrarHora = () => {
                let fecha = new Date()
                let hora = fecha.getHours()
                let minuto = fecha.getMinutes()
                let segundo = fecha.getSeconds()
                horaHTML.textContent = String(hora).padStart(2, "0")
                minutoHTML.textContent = String(minuto).padStart(2, "0")
                segundoHTML.textContent = String(segundo).padStart(2, "0")

                setTimeout(mostrarHora, 1000)
            }
            mostrarHora()
        })
    </script>

</body>


</html>