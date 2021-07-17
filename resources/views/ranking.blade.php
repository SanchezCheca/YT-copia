<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RANKING - YT-copia</title>

    @include('estilos')
</head>

<body>
    @include('navbar')

    <div class="container-fluid mx-0">

        <?php
        //----------CANALES CON MÁS SUSCRIPTORES
        if (isset($topUsers)) {

            ?>
        <p class="h3 mt-2 mx-0">
            <i class="fas fa-users"></i> Canales con más suscriptores
        </p>
        <!-- MEJORES CANALES -->
        <div class="row mx-0">
            <?php
            foreach ($topUsers as $channel) {
                    ?>
            <!-- canal -->
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2 text-center">
                <a href="{{ 'user/' . $channel->username }}">
                    <img class="perfilMisSuscripciones" src="{{ url($channel->publicProfileImageUrl) }}">
                    <p class="h5 mx-auto text-dark">
                        {{ $channel->username }}
                    </p>
                </a>
                <!-- nº de suscriptores -->
                <p class="textomenor">
                    {{ number_format($channel->nSubs, 0, ',', '.') }}
                    <?php if ($channel->nSubs == 1) {
                        echo 'suscriptor';
                    } else {
                        echo 'suscriptores';
                    } ?>
                </p>
            </div>
            <?php
                }
                ?>
        </div>
        <?php
        }
        ?>

        <?php
        //----------VÍDEOS MÁS VISTOS
        if (isset($topVideos)) {
            ?>
        <p class="h3 mt-5 mx-0">
            <i class="fas fa-chart-bar"></i> Vídeos más vistos <a class="textoMenor"
                href="{{ url('search/:topVideos') }}">Ver todo</a>
        </p>
        <!-- MEJORES VÍDEOS -->
        <div class="row mx-0">
            <?php
        foreach ($topVideos as $videoRec) {
                            ?>
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2">
                <a href="{{ url('video/' . $videoRec->filename) }}"><img class="img-fluid videosPrincipal"
                        src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                        width="240vh"></a>
                <p class="my-0 text-truncate tituloVideoRecomendado">
                    <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                </p>
                <p class="my-0 canalVideoRecomendado text-truncate">
                    <a href="{{ url('user/' . $videoRec->creatorUsername) }}"><img class="perfilResultadoBusqueda"
                            src="{{ url($videoRec->creatorImageUrl) }}"> {{ $videoRec->creatorUsername }}</a>
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

        <?php
        //----------VÍDEOS CON MÁS LIKES
        if (isset($topVideosByLikes)) {
            ?>
        <p class="h3 mt-5 mx-0">
            <i class="fas fa-thumbs-up"></i> Vídeos con más likes
        </p>
        <!-- MEJORES VÍDEOS -->
        <div class="row mx-0">
            <?php
        foreach ($topVideosByLikes as $videoRec) {
                    ?>
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2">
                <a href="{{ url('video/' . $videoRec->filename) }}"><img class="img-fluid videosPrincipal"
                        src="{{ 'https://vdm2.s3.eu-west-3.amazonaws.com/thumbnails/' . $videoRec->thumbnailFilename }}"
                        width="240vh"></a>
                <p class="my-0 text-truncate tituloVideoRecomendado">
                    <a href="{{ url('video/' . $videoRec->filename) }}">{{ $videoRec->title }}</a>
                </p>
                <p class="my-0 canalVideoRecomendado text-truncate">
                    <a href="{{ url('user/' . $videoRec->creatorUsername) }}"><img class="perfilResultadoBusqueda"
                            src="{{ url($videoRec->creatorImageUrl) }}"> {{ $videoRec->creatorUsername }}</a>
                </p>
                <p class="my-0 viewsVideoRecomendado ml-4">
                    {{ number_format($videoRec->nLikes, 0, ',', '.') }} <i class="fas fa-thumbs-up"></i>
                </p>
            </div>
            <?php
                }
                ?>

        </div>
        <?php
        }
        ?>

        <?php
        //----------CANALES CON MÁS SUSCRIPTORES
        if (isset($topUsersBynVideos)) {

        ?>
        <p class="h3 mt-2 mx-0 mt-5">
            <i class="fas fa-video"></i> Canales con más vídeos subidos
        </p>
        <!-- MEJORES CANALES -->
        <div class="row mx-0">
            <?php
        foreach ($topUsersBynVideos as $channel) {
            ?>
            <!-- canal -->
            <div class="col-12 col-lg-2 col-md-4 col-sm-6 my-2 text-center">
                <a href="{{ 'user/' . $channel->username }}">
                    <img class="perfilMisSuscripciones" src="{{ url($channel->publicProfileImageUrl) }}">
                    <p class="h5 mx-auto text-dark">
                        {{ $channel->username }}
                    </p>
                </a>
                <!-- nº de suscriptores -->
                <p class="textomenor">
                    {{ number_format($channel->nVideos, 0, ',', '.') }}
                    <?php if ($channel->nVideos == 1) {
                        echo 'vídeo';
                    } else {
                        echo 'vídeos';
                    } ?>
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
