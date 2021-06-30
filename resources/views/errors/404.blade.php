<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>404 - YT-copia</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="../fonts/all.css">
        <link rel="stylesheet" href="../css/estilos.css">
    </head>
    <body class="text-center">
        @include('../navbar')

        <h2 class="h2 mt-5">404 - NO SE ENCUENTRA</h2>

        @include('../scripts')
        <script src="../fonts/all.js"></script>
    </body>
</html>
