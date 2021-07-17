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

        <div class="container">
            <div class="row mt-2">
                <div class="col-12">

                    <?php
                    //Mensaje de respuesta
                    if (isset($mensaje)) {
                        ?>
                        <p class="bg-success text-dark rounded text-center p-2">
                            {{$mensaje}}
                        </p>
                        <?php
                    }
                    ?>

                    <form class="border rounded p-3" action="contacto" name="contactForm" method="POST">
                        @csrf
                        <p class="h4 text-center">
                            Contacto
                        </p>
                        <p class="h5">Nombre</p>
                        <input type="text" class="form-control" name="name" placeholder="Tu nombre" value="<?php if (isset($usuarioIniciado)) {echo $usuarioIniciado->username;} ?>" required>
                        <p class="h5 mt-2">Correo electrónico</p>
                        <input type="email" class="form-control" name="email" placeholder="Correo electrónico" value="<?php if (isset($usuarioIniciado)) {echo $usuarioIniciado->email;} ?>" required>
                        <p class="h5 mt-2">Mensaje</p>
                        <textarea class="form-control" name="message" rows="3" placeholder="Escribe tu mensaje" required></textarea>
                        <div class="w-100 text-center">
                            <input type="submit" name="enviarMensaje" value="Enviar" class="btn btn-success mt-2 text-dark">
                            <a href="{{url('/')}}"><button type="button" class="btn btn-warning mt-2">Volver</button></a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        @include('footer')
        @include('scripts')
    </body>
</html>
