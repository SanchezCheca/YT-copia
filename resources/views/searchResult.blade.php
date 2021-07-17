<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Resultados de búsqueda - YT-copia</title>

    @include('estilos')
</head>

<body>
    @include('navbar')

    <div class="container mx-auto bg-light">

        <div class="row">
            <?php
                if (isset($videos) && sizeof($videos) > 0) {
                    //Título para el caso de que sea el top de vídeos o los últimos vídeos subidos
                    if (isset($searchTerm) && $searchTerm == ':topVideos') {
                        ?>
                        <div class="col-12 mt-2">
                            <p class="h4">
                                Vídeos más vistos
                            </p>
                        </div>
                        <?php
                    } else if (!isset($searchTerm)) {
                        ?>
                        <div class="col-12 mt-2">
                            <p class="h4">
                                Últimos vídeos subidos
                            </p>
                        </div>
                        <?php
                    }

                    foreach($videos as $video) {
                        ?>
            <div class="col-12 my-2">
                <a href="{{ url('video/' . $video->filename) }}"><img class="img-fluid float-left imagenResultadoBusqueda mr-3"
                        src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $video->thumbnailFilename }}"
                        width="240vh"></a>
                <p class="my-0 text-truncate tituloVideoRecomendado">
                    <a href="{{ url('video/' . $video->filename) }}">{{ $video->title }}</a>
                </p>
                <p class="my-0 canalVideoRecomendado text-truncate">
                    <a href="{{ url('user/' . $video->creatorUsername) }}"><img class="perfilResultadoBusqueda" src="{{url($video->creatorImageUrl)}}"> {{ $video->creatorUsername }}</a>
                </p>
                <p class="my-0 viewsVideoRecomendado">
                    {{ number_format($video->views, 0, ',', '.') }} visualizaciones
                </p>
            </div>
            <?php
                    }
                } else {
                    ?>
                    <div class="col-12 my-2 text-center">
                        <p class="font-italic">No hay resultados</p>
                    </div>
                    <?php
                }
                ?>
        </div>


    </div>

    @include('footer')

    @include('scripts')
</body>

</html>
