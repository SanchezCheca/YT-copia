<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Inicio - YT-copia</title>

        @include('estilos')
    </head>
    <body>
        @include('navbar')

        <?php
        if (isset($usuarioIniciado)) {
            echo $usuarioIniciado;
        }
        if (isset($ruta)) {
            echo '<br>' . $ruta;
        }
        ?>

        @include('scripts')
    </body>
</html>
