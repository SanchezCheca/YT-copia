<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Administración de usuarios - YT-copia
    </title>

    @include('estilos')
</head>

<body>
    @include('navbar')

    <div class="container">
        <?php
        if (isset($mensaje)) {
            ?>
            <p class="w-100 p-2 rounded bg-success text-center text-white mt-2">
                {{$mensaje}}
            </p>
            <?php
        }
        ?>
        <form name="crearNotificacion" class="p-2 border rounded my-3 bg-light" action="{{url('crearNotificacion')}}" method="POST">
            @csrf
            <input type="number" class="form-control my-2" name="user_id" placeholder="ID del usuario" required>
            <input type="text" class="form-control my-2" name="title" placeholder="Título de la notificación" required>
            <input type="text" class="form-control my-2" name="content" placeholder="Contenido de la notificación" required>
            <input type="submit" class="btn btn-success my-2" value="Enviar">
        </form>
    </div>

    @include('footer')
    @include('scripts')

</body>

</html>
