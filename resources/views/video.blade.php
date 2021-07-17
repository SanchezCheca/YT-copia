<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php if (isset($video)) {
            echo $video->title . ' - YT-copia';
        } else {
            echo 'Vídeo no encontrado - YT-copia';
        }
        ?>
    </title>
    <link href="//vjs.zencdn.net/5.4.6/video-js.min.css" rel="stylesheet">
    @include('estilos')
</head>

<body>
    @include('navbar')


    <?php if (isset($video)) { ?>
    <div class="row mx-0 px-5 mt-4 mx-0">
        <div class="col-12 col-lg-8">
            <!-- CONTENIDO DE VÍDEO, TÍTULO Y DESCRIPCIÓN -->
            <div class="row">
                <div class="col-12">
                    <!-- Reproductor -->
                    <video class="video-js vjs-default-skin vjs-big-play-centered cajaVideo" controls preload="auto"
                        controlsList="nodownload" data-setup='{"example_option":true}'>
                        <source src="{{ $video->publicUrl }}" type="video/mp4" />
                        <p class="vjs-no-js">Si no puedes ver este vídeo es que tienes un navegador muy antigüo :)</p>
                    </video>
                </div>
                <div class="col-12 mt-2">
                    <!-- TÍTULO -->
                    <p class="h3">
                        {{ $video->title }}
                        <?php
                        if (isset($usuarioIniciado) && ($usuarioIniciado->rol == 1 || $usuarioIniciado->id == $creator->id)) {
                            //Es el creador del vídeo o bien un administrador, muestra botón para editar
                            ?>
                        <a href="{{ url('video/' . $video->filename . '/edit') }}">
                            <button class="btn btn-info float-right">
                                EDITAR VÍDEO
                            </button>
                        </a>
                        <?php
                        }
                        ?>
                    </p>
                    <p>
                        {{ number_format($video->views, 0, ',', '.') }} visualizaciones&nbsp;&nbsp;
                        <?php
                        //Likes
                        if (isset($hasLiked) && $hasLiked) {
                            ?>
                        <a href="{{ url('likeVideo/' . $video->filename) }}" class="text-dark"
                            style="text-decoration: none"><i class="fas fa-thumbs-up"></i> {{ $video->likes }}</a>
                        <?php
                        } else {
                            ?>
                        <a href="{{ url('likeVideo/' . $video->filename) }}" class="text-dark"
                            style="text-decoration: none"><i class="far fa-thumbs-up"></i> {{ $video->likes }}</a>
                        <?php
                        }

                        echo ' &nbsp; ';

                        //Dislikes
                        if (isset($hasDisliked) && $hasDisliked) {
                            ?>
                        <a href="{{ url('dislikeVideo/' . $video->filename) }}" class="text-dark"
                            style="text-decoration: none"><i class="fas fa-thumbs-down"></i>
                            {{ $video->dislikes }}</a>
                        <?php
                        } else {
                            ?>
                        <a href="{{ url('dislikeVideo/' . $video->filename) }}" class="text-dark"
                            style="text-decoration: none"><i class="far fa-thumbs-down"></i>
                            {{ $video->dislikes }}</a>
                        <?php
                        }

                        ?>
                    </p>
                    <?php
                        if (isset($creator)) {
                            ?>
                    <hr>
                    <a href="{{ url('user/' . $creator->username) }}" class="text-dark"
                        style="text-decoration: none; text-color: black">
                        <img src="{{ url($creator->publicProfileImageUrl) }}" height="45vh"
                            class="rounded-circle float-left mr-2">

                        <div>
                            <p class="textoMayor mb-0 ml-5">
                                {{ $creator->username }}
                            </p>
                            <p class="textoMenor mt-0 ml-5">
                                {{ number_format($creator->nSubs, 0, ',', '.') }}
                                <?php
                                if ($creator->nSubs == 1) {
                                    echo ' suscriptor';
                                } else {
                                    echo ' suscriptores';
                                }
                                ?>
                            </p>
                        </div>


                    </a>
                    <?php
                        }
                        ?>
                    <hr>
                    <!-- DESCRIPCION -->
                    <p class="formateado">{{ $video->description }}</p>
                </div>
                <!-- CAJA DE COMENTARIOS -->
                <div class="col-12 mt-4">
                    <hr>
                    <p class="h4">Comentarios (<?php if (isset($nCommentaries)) {
                    echo $nCommentaries;
                } ?>)</p>
                    <form name="comentar" action="{{ url('comentar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="video_id" value="{{ $video->id }}">
                        <div class="row">
                            <div class="col-10">
                                <textarea class="form-control" name="commentary" rows="2"
                                    placeholder="Escribe un comentario" id="descripcion" maxlength="40"></textarea>
                            </div>
                            <div class="col-2">
                                <input type="submit" value="Comentar" class="btn btn-success w-100">
                            </div>
                        </div>
                    </form>

                    <!-- Lista de comentarios -->
                    <?php
                    if (isset($commentaries)) {
                        foreach ($commentaries as $commentary) {
                            ?>
                    <p class="mt-2" >
                        <a href="{{ url('user/' . $commentary->creatorUsername) }}" class="text-dark mr-2">
                            <img class="perfilRedondo" src="{{ url($commentary->creatorImageUrl) }}">
                            <b>{{ $commentary->creatorUsername }}</b>
                        </a>
                        {{ $commentary->commentary }}
                    </p>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>


        </div>
        <div class="col-12 col-lg-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="h4">
                        Vídeos recomendados
                    </h4>
                </div>
                <!--TARJETAS DE VÍDEOS RECOMENDADOS -->
                <?php
                if (isset($videosRecomendados)) {
                    foreach ($videosRecomendados as $videoRec) {
                        ?>
                <div class="col-12 mt-2">
                    <a href="{{ url('video/' . $videoRec->filename) }}"><img
                            src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                            width="200vh" class="float-left mr-2"></a>
                    <p class="my-0 tituloVideoRecomendado text-truncate">
                        <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                    </p>
                    <p class="my-0 canalVideoRecomendado text-truncate">
                        <a
                            href="{{ url('user/' . $videoRec->creatorUsername) }}">{{ $videoRec->creatorUsername }}</a>
                    </p>
                    <p class="my-0 viewsVideoRecomendado">
                        {{ $videoRec->views }} visualizaciones
                    </p>
                </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php } else {
        ?>
    <p class="mx-auto">
        El vídeo no se encuentra, <a href="{{ url('/') }}">volver a inicio.</a>
    </p>
    <?php
    } ?>

    @include('footer')
    <script src="//vjs.zencdn.net/5.4.6/video.min.js"></script>
    @include('scripts')
</body>

</html>
