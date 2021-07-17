<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Iniciar sesión - YT-copia</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="fonts/all.css">
        @include('estilos')
    </head>
    <body>
        @include('navbar')

        <div class="row mx-0">
            <div class="col-12 col-md-6 col-lg-4 mx-auto p-3 text-center">

                <?php
                if (isset($exito) && $exito && isset($mensaje)) {
                    ?>
                    <div class="rounded bg-success text-center p-1 mb-1">{{$mensaje}}</div>
                    <?php
                } else if (isset($mensaje)) {
                    ?>
                    <div class="rounded bg-danger text-center p-1 mb-1 font-weight-bold">{{$mensaje}}</div>
                    <?php
                }
                ?>

                <form class="border rounded p-3" action="login" name="loginForm" method="POST">

                    {{ csrf_field() }}
                    <input class="form-control" name="emailOrUsername" type="text" placeholder="Nombre de usuario o correo electrónico">
                    <input class="form-control mt-2" name="pass" type="password" placeholder="Contraseña">
                    <input type="submit" class="btn btn-dark mt-2" name="botonLogin" value="Iniciar sesión">
                    <p class="d-block mt-2 mb-0">¿No tienes cuenta? <a href="{{url('register')}}">Crear cuenta</a></p>
                  </form>

                  <?php
                    if (isset($ruta)) {
                        dd($ruta);
                    }
                  ?>

            </div>
        </div>

        @include('footer')
        @include('scripts')
    </body>
</html>
