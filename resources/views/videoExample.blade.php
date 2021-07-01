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

        <div class="row mx-0 px-2">
            <div class="col-12 col-lg-8 mx-auto px-center">
                <div class="row">
                    <div class="col-12">
                        <!-- CONTENIDO DE VÍDEO, TÍTULO Y DESCRIPCIÓN -->
                        <?php
                            if (isset($videoInfo)) {
                                ?>
                                    <video class="video-js vjs-default-skin vjs-big-play-centered"
                                        controls preload="auto" controlsList="nodownload"
                                        data-setup='{"example_option":true}'>
                                        <source src="{{$videoInfo[0]->publicUrl}}" type="video/mp4" />
                                        <p class="vjs-no-js">Si no puedes ver este vídeo es que tienes un navegador muy antigüo :)</p>
                                    </video>
                                <?php
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <!--Tarjeta video recomendado -->
                    <div class="col-12">
                        <img src="https://cdn.pixabay.com/photo/2013/08/10/17/01/africa-171315_960_720.jpg" width="80px" class="float-left">
                        <p>
                            Hola que tal
                        </p>
                    </div>
                </div>
            </div>
        </div>
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
