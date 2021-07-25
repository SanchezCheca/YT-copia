<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Subir - YT-copia</title>
    <link href="//vjs.zencdn.net/5.4.6/video-js.min.css" rel="stylesheet">
    @include('estilos')
</head>

<body>
    @include('navbar')

    <?php if (isset($videoInfo)) { ?>
    <div class="row mx-0 px-5 mt-4">
        <div class="col-12 col-lg-8">
            <!-- CONTENIDO DE VÍDEO, TÍTULO Y DESCRIPCIÓN -->
            <video class="video-js vjs-default-skin vjs-big-play-centered cajaVideo" controls preload="auto"
                controlsList="nodownload" data-setup='{"example_option":true}'>
                <source src="{{ $videoInfo[0]->publicUrl }}" type="video/mp4" />
                <p class="vjs-no-js">Si no puedes ver este vídeo es que tienes un navegador muy antigüo :)</p>
            </video>
        </div>
        <div class="col-12 col-lg-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="h4">
                        Vídeos recomendados
                    </h4>
                </div>
                <!--TARJETAS DE VÍDEOS RECOMENDADOS -->
                <div class="col-12 mt-2">
                    <a href="#"><img src="https://cdn.pixabay.com/photo/2013/08/10/17/01/africa-171315_960_720.jpg" width="120vh" class="float-left mr-2"></a>
                    <p class="my-0 tituloVideoRecomendado text-truncate">
                        <a href="#">Título del vídeo</a>
                    </p>
                    <p class="my-0 canalVideoRecomendado text-truncate">
                        <a href="#">Canal del autor</a>
                    </p>
                    <p class="my-0 viewsVideoRecomendado">
                        2 visualizaciones
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php } else {
        ?>
        <p class="mx-auto">
            El vídeo no se encuentra, <a href="inicio">volver a inicio.</a>
        </p>
        <?php
    } ?>

    <!--
        <div class="row mx-0">
            <div class="col-12 col-md-6 col-lg-4 mx-auto p-3 text-center">
               <hr>
                <video id="example_video_1" class="video-js vjs-default-skin vjs-big-play-centered"
                    controls preload="auto" controlsList="nodownload"
                    data-setup='{"example_option":true}'
                    width="600">
                    <source src="https://vdm2.s3.eu-west-3.amazonaws.com/videos/UAOrsYkMEVlQl99OXhJRRJfcxqjN9JtgYqe2sNHU.mp4" type="video/mp4" />
                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                </video>
            </div>
        </div>
    -->

    <script src="//vjs.zencdn.net/5.4.6/video.min.js"></script>
    @include('scripts')
</body>

</html>
