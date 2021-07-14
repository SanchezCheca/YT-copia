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
        if (isset($usuarioIniciado)) {
            ?>
    <div class="container rounded mt-2">
        <form name="editProfile" action="{{url('editProfile')}}" method="POST" enctype="multipart/form-data">
            @csrf
        <!-- CABECERA DEL CANAL -->
        <div class="row rounded-top bg-dark py-2">
            <div class="col-12">
                <!-- Cabecera -->
                <div class="text-white cabeceraCanal d-inline">

                    <img src="{{ url($usuarioIniciado->publicProfileImageUrl) }}"
                        class="img-thumbnail rounded float-left mt-2 mr-3" id="imagenPerfil">

                    <p class="h3 text-white d-inline mt-2">
                        {{ $usuarioIniciado->username }}
                    </p>

                    <br>
                    <input class="mt-2" type="file" name="profileImage" accept="image/png, image/jpg, image/jpeg" id="inputImagenPerfil">
                    <p class="font-italic mb-0">
                        Formato jpg o png
                    </p>
                </div>
            </div>
        </div>
        <!-- CUERPO DEL CANAL -->
        <div class="row bg-light pb-3">
            <div class="col-12 text-center">
                <div class="form-group mt-4">
                    <label for="descripcion" class="text-left w-100">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" placeholder="Di algo sobre ti" id="descripcion">{{$usuarioIniciado->about}}</textarea>
                </div>

                <input type="submit" class="btn btn-success" value="Guardar cambios">
                <a href="{{url()->previous()}}">
                    <button type="button" class="btn btn-warning">
                        Volver
                    </button>
                </a>
            </div>
        </div>
        <!-- PIE DEL CANAL -->
        <div class="row rouded-bottom">
            <div class="col-12 bg-dark text-center rounded-bottom">
                .
            </div>
        </div>

        </form>
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



    @include('scripts')

    <!-- CAMBIA LA IMAGEN DE PERFIL EN EL MOMENTO EN QUE LA SELECCIONA -->
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagenPerfil').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#inputImagenPerfil").change(function(){
            console.log('hola');
            readURL(this);
        });
    </script>
</body>

</html>
