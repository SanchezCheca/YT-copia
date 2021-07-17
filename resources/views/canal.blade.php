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
        <div class="row rounded-top bg-dark py-2">
            <div class="col-12">
                <!-- Cabecera -->
                <div class="text-white cabeceraCanal d-inline">

                    <img src="{{ url($user->publicProfileImageUrl) }}"
                        class="img-thumbnail rounded float-left mt-2 mr-3">

                    <?php
                            if (isset($usuarioIniciado) && $user->id == $usuarioIniciado->id) {
                                //Es el canal propio
                                ?>
                    <a href="{{url('editProfile')}}">
                        <button class="btn btn-primary float-right mt-2">
                            Editar perfil
                        </button>
                    </a>
                    <?php
                            }
                                ?>


                    <p class="h3 text-white d-inline mt-2">
                        {{ $user->username }}
                    </p>
                    <?php
                    if (!(isset($usuarioIniciado) && $usuarioIniciado->id == $user->id)) {
                        if (isset($estaSuscrito) && $estaSuscrito) {
                            ?>
                    <!-- BOTÓN SUSCRIBIRSE -->
                    <form class="d-inline ml-3" name="suscribirse" method="POST"
                        action="{{ url('subscribe/' . $user->username) }}">
                        @csrf
                        <button class="btn btn-danger" type="submit" id="botonSuscrito">
                            <span>Suscrito</span>
                        </button>
                    </form>
                    <?php
                        } else {
                            ?>
                    <!-- BOTÓN SUSCRIBIRSE -->
                    <form class="d-inline ml-3" name="suscribirse" method="POST"
                        action="{{ url('subscribe/' . $user->username) }}">
                        @csrf
                        <button class="btn btn-outline-danger" type="submit">
                            Suscribirme
                        </button>
                    </form>
                    <?php
                        }
                    }

                    if ($user->subs == 1) {
                        echo '<p class="mt-4"><b>' . number_format($user->subs, 0, ',', '.') . '</b> suscriptor &nbsp;&nbsp; ' . number_format($user->views, 0, ',', '.') . ' visualizaciones</p>';
                    } else {
                        echo '<p class="mt-4"><b>' . number_format($user->subs, 0, ',', '.') . '</b> suscriptores &nbsp;&nbsp; ' . number_format($user->views, 0, ',', '.') . ' visualizaciones</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row bg-light">

            <div class="col-12 col-md-8">
                <div class="row my-2">
                    <div class="col-12">
                        <p class="h4 mt-2">
                            Vídeos ({{ $user->nVideos }}) <a href="{{url('user/' . $user->username . '/videos')}}" class="textoMenor">Ver todos</a>
                        </p>
                    </div>
                    <?php
                    if (isset($userVideos)) {
                        foreach ($userVideos as $videoRec) {
                            ?>
                    <div class="col-lg-4 col-sm-6 col-12 text-center mb-4">
                        <a href="{{ url('video/' . $videoRec->filename) }}"><img
                                src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                                width="250vh" class="videosCanal"></a>
                        <p class="my-0 text-truncate tituloVideoRecomendado">
                            <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                        </p>
                        <p class="my-0 viewsVideoRecomendado">
                            {{ $videoRec->views }} visualizaciones
                        </p>
                    </div>
                    <?php
                        }
                    } else {
                        ?>
                    <p class="font-italic m-2">
                        El usuario no tiene vídeos
                    </p>
                    <?php
                    }
                    ?>
                </div>

            </div>
            <div class="col-12 col-md-4">
                <p class="h4 mt-2">
                    About
                </p>
                <p class="formateado">{{$user->about}}</p>
                <hr>
                <p class="h5 my-1">
                    Estadísticas
                </p>
                <p class="textoEstadisticas">
                    <i class="fas fa-users"></i> Suscriptores: {{ number_format($user->subs, 0, ',', '.') }}<br>
                    <i class="fas fa-chart-bar"></i> Visualizaciones totales: {{ number_format($user->views, 0, ',', '.') }}<br>
                    <i class="fas fa-video"></i> vídeos: {{ number_format($user->nVideos, 0, ',', '.') }}<br>
                    <i class="far fa-thumbs-up"></i> total de Likes: {{ number_format($user->likes, 0, ',', '.') }}<br>
                    <i class="far fa-thumbs-down"></i> total de dislikes: {{ number_format($user->dislikes, 0, ',', '.') }}<br>
                </p>
                <p class="textoEstadisticas font-italic">
                    <i class="far fa-calendar-alt"></i> Fecha de creación: {{ $user->created_at->format('d-m-Y') }}
                </p>
            </div>
        </div>
        <div class="row rouded-bottom">
            <div class="col-12 bg-dark text-center rounded-bottom">
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
                    El canal no existe. <a class="text-white font-weight-bold"
                        href="{{ url()->previous() }}">Volver.</a>
                </p>
            </div>
        </div>
    </div>
    <?php
    }
    ?>

    @include('footer')

    @include('scripts')

    <script>
        $('#botonSuscrito').hover(function() {
            $(this).find('span').text('Cancelar suscripción');
        }, function() {
            $(this).find('span').text('Suscrito');
        });
    </script>
</body>

</html>
