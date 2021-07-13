<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            <?php
        if (isset($user)) {
            echo $user->username . ' ';
        } else {
            echo 'Canal que no existe ';
        }
        ?>- YT-copia
        </title>

        @include('estilos')
    </head>
    <body>
        @include('navbar')
        <?php
        if (isset($user)) {
            ?>
        <div class="container rounded mt-2">
            <div class="row rounded bg-dark">
                <div class="col-12">
                    <!-- Cabecera -->
                    <div class="text-white cabeceraCanal d-inline">

                            <img src="{{url($user->publicProfileImageUrl)}}" class="img-thumbnail rounded float-left mt-2 mr-3">

                            <?php
                            if ($user->id == $usuarioIniciado->id) {
                                //Es el canal propio
                                ?>
                                <button class="btn btn-primary float-right mt-2">
                                    Editar perfil
                                </button>
                                <?php
                            }
                            ?>

                            <p class="h3 text-white mt-4">
                                {{$user->username}}
                            </p>
                            <?php
                            if ($user->subs == 1) {
                                echo '<p><b>' . $user->subs . '</b> suscriptor</p>';
                            } else {
                                echo '<p><b>' . $user->subs . '</b> suscriptores</p>';
                            }
                            ?>


                    </div>
                </div>
                <div class="col-12 bg-light">
dawd
                </div>
                <div class="col-12 bg-dark text-center">
                    .
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="container rounded mt-2">
            <div class="row bg-dark rounded">
                <div class="col-12">
                    <p class="text-white h5 m-3">
                        El canal no existe. <a class="text-white font-weight-bold" href="{{url()->previous()}}">Volver.</a>
                    </p>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
        @include('scripts')
    </body>
</html>
