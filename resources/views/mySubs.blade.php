<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mis suscripciones - YT-copia</title>

    @include('estilos')
</head>

<body>
    @include('navbar')

    <div class="container mx-auto bg-light">

        <div class="row pt-2">
            <div class="col-12">
                <p class="h4">
                    Mis suscripciones
                </p>
            </div>
            <?php
            if (isset($channels)) {
                foreach ($channels as $channel) {
                    ?>
                    <!-- canal -->
                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 text-center my-2">
                        <a href="{{'user/' . $channel->username}}">
                            <img class="perfilMisSuscripciones" src="{{url($channel->publicProfileImageUrl)}}">
                            <p class="h5 mx-auto text-dark">
                                {{$channel->username}}
                            </p>
                        </a>
                        <!-- nº de suscriptores -->
                        <p class="textomenor">
                            {{ number_format($channel->nSubs, 0, ',', '.') }} <?php if ($channel->nSubs == 1) {
                                echo 'suscriptor';
                            } else {
                                echo 'suscriptores';
                            } ?>
                        </p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>


    </div>

    @include('footer')

    @include('scripts')
</body>

</html>
