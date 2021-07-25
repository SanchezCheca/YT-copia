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

    <div class="container-fluid mx-0">
        <?php
        if (isset($ultimosVideos)) {
            ?>
        <p class="h3 mt-2">
            Últimos vídeos <a class="textoMenor" href="{{url('search')}}">Ver todo</a>
        </p>
        <!-- ÚLTIMOS VÍDEOS -->
        <div class="row">
            <?php
        foreach ($ultimosVideos as $videoRec) {
                            ?>
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2">
                <a href="{{ url('video/' . $videoRec->filename) }}"><img class="img-fluid videosPrincipal"
                        src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                        width="240vh"></a>
                <p class="my-0 text-truncate tituloVideoRecomendado">
                    <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                </p>
                <p class="my-0 canalVideoRecomendado text-truncate">
                    <a href="{{ url('user/' . $videoRec->creatorUsername) }}"><img class="perfilResultadoBusqueda" src="{{url($videoRec->creatorImageUrl)}}"> {{ $videoRec->creatorUsername }}</a>
                </p>
                <p class="my-0 viewsVideoRecomendado ml-4">
                    {{ number_format($videoRec->views, 0, ',', '.') }} visualizaciones
                </p>
            </div>
            <?php
                        }
                        ?>

        </div>
        <?php
        }
        ?>

        <!-- VÍDEOS DE SUSCRIPCIONES -->
        <?php
        if (isset($videosSuscripciones)) {
            ?>
        <p class="h3 mt-4">
            De tus suscripciones <a class="textoMenor" href="{{url('mySubs')}}">Ver suscripciones</a>
        </p>
        <div class="row">
            <?php
        foreach ($videosSuscripciones as $videoRec) {
                            ?>
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2">
                <a href="{{ url('video/' . $videoRec->filename) }}"><img class="img-fluid videosPrincipal"
                        src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                        width="240vh"></a>
                <p class="my-0 text-truncate tituloVideoRecomendado">
                    <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                </p>
                <p class="my-0 canalVideoRecomendado text-truncate">
                    <a href="{{ url('user/' . $videoRec->creatorUsername) }}"><img class="perfilResultadoBusqueda" src="{{url($videoRec->creatorImageUrl)}}"> {{ $videoRec->creatorUsername }}</a>
                </p>
                <p class="my-0 viewsVideoRecomendado ml-4">
                    {{ number_format($videoRec->views, 0, ',', '.') }} visualizaciones
                </p>
            </div>
            <?php
                        }
                        ?>
        </div>
        <?php
        }
        ?>

        <!-- VÍDEOS MÁS VISTOS -->
        <?php
        if (isset($videosMasVistos)) {
            ?>
        <p class="h3 mt-4">
            Vídeos más vistos <a class="textoMenor" href="{{url('search/:topVideos')}}">Ver todo</a>
        </p>
        <div class="row">
            <?php
            foreach ($videosMasVistos as $videoRec) {
                                ?>
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2">
                <a href="{{ url('video/' . $videoRec->filename) }}"><img class="img-fluid videosPrincipal"
                        src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                        width="240vh"></a>
                <p class="my-0 text-truncate tituloVideoRecomendado">
                    <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                </p>
                <p class="my-0 canalVideoRecomendado text-truncate">
                    <a href="{{ url('user/' . $videoRec->creatorUsername) }}"><img class="perfilResultadoBusqueda" src="{{url($videoRec->creatorImageUrl)}}"> {{ $videoRec->creatorUsername }}</a>
                </p>
                <p class="my-0 viewsVideoRecomendado ml-4">
                    {{ number_format($videoRec->views, 0, ',', '.') }} visualizaciones
                </p>
            </div>
            <?php
                            }
                            ?>
        </div>
        <?php
        }
        ?>

    </div>

    @include('footer')

    @include('scripts')
</body>

</html>
