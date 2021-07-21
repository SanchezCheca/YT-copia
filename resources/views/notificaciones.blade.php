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

    <div class="container">

        <div class="row">
            <div class="col-12 mt-2">
                <?php
                if (isset($notificacionesSinLeer) && isset($notificacionesLeidas) && sizeof($usuarioIniciado->notificaciones) > 0) {
                    if (sizeof($notificacionesSinLeer) > 0) {
                        ?>
                <!-- NOTIFICACIONES SIN LEER -->
                <p class="h4 text-center my-2 d-inline">
                    Notificaciones recientes<div class="spinner-grow text-danger"></div>
                </p>
                <table class="table my-3">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Asunto</th>
                            <th scope="col">Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //Muestra todas las notificaciones
                            foreach($notificacionesSinLeer as $notif) {
                                ?>
                        <tr>
                            <th scope="row">{{ $notif->created_at->format('d-m-Y') }}</th>
                            <td>{{ $notif->title }}</td>
                            <td>{{ $notif->content }}</td>
                        </tr>
                        <?php
                            }
                          ?>
                    </tbody>
                </table>
                <hr>
                <?php
                    }
                    ?>

                <!-- NOTIFICACIONES DEL USUARIO -->
                <p class="h4 text-center my-2 d-inline">
                    Notificaciones pasadas
                </p>
                <table class="table mt-2">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Asunto</th>
                            <th scope="col">Mensaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //Muestra todas las notificaciones
                            foreach($notificacionesLeidas as $notif) {
                                ?>
                        <tr>
                            <th scope="row">{{ $notif->created_at->format('d-m-Y') }}</th>
                            <td>{{ $notif->title }}</td>
                            <td>{{ $notif->content }}</td>
                        </tr>
                        <?php
                            }
                          ?>
                    </tbody>
                </table>
                <?php
                } else {
                    ?>
                <p class="h5 font-italic text-center">
                    Aún no tienes notificaciones. <a href="{{ url()->previous() }}">Volver atrás</a>
                </p>
                <?php
                }
                ?>
            </div>
        </div>

    </div>

    @include('footer')

    @include('scripts')
</body>

</html>
