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
    <form name="editVideoForm" action="{{ url('editVideo') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $video->id }}">
        <div class="row mx-0 px-5 mt-4">
            <div class="col-12 col-lg-8 mx-auto text-center">
                <!-- CONTENIDO DE VÍDEO, TÍTULO Y DESCRIPCIÓN -->
                <div class="row">
                    <div class="col-12">
                        <!-- Reproductor -->
                        <video class="video-js vjs-default-skin vjs-big-play-centered cajaVideo" controls preload="auto"
                            controlsList="nodownload" data-setup='{"example_option":true}'>
                            <source src="{{ $video->publicUrl }}" type="video/mp4" />
                            <p class="vjs-no-js">Si no puedes ver este vídeo es que tienes un navegador muy antigüo :)
                            </p>
                        </video>
                    </div>
                    <div class="col-12 mt-2">
                        <!-- TÍTULO -->
                        <p class="h5">Título</p>
                        <input type="text" class="form-control" name="title" value="{{ $video->title }}">
                        <hr>
                        <!-- DESCRIPCION -->
                        <p class="h5">Descripción</p>
                        <textarea class="form-control" name="description" rows="3" placeholder="Descripción del vídeo"
                            id="descripcion">{{ $video->description }}</textarea>
                        <hr>
                        <!-- ETIQUETAS -->
                        <p class="h5">Etiquetas (separadas por coma)</p>
                        <input type="text" class="form-control" name="tags" value="{{ $tags }}"
                            placeholder="etiqueta1, etiqueta2">
                    </div>
                </div>
                <input type="submit" class="btn btn-success my-2" name="guardar" value="GUARDAR CAMBIOS">
                <input type="submit" class="btn btn-warning my-2" name="cancelar" value="CANCELAR">
                <input type="submit" class="btn btn-danger my-2" name="eliminar" id="eliminar" value="ELIMINAR VÍDEO">
            </div>
        </div>
    </form>
    <?php } else {
        ?>
    <p class="mx-auto">
        El vídeo no se encuentra, <a href="inicio">volver a inicio.</a>
    </p>
    <?php
    } ?>

    <script src="//vjs.zencdn.net/5.4.6/video.min.js"></script>
    @include('scripts')

    <script type="text/javascript">
        $(function() {
            $("#eliminar").click(function() {
                var result = confirm("¿Estás seguro?\nEsta acción no se puede deshacer");

                if (result == true) {
                    return true;
                } else {
                    return false;
                }
            });
        });
    </script>
</body>

</html>
