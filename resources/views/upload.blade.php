<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Subir - YT-copia</title>

    @include('estilos')

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <style>
        .progress {
            position: relative;
            width: 100%;
        }

        .bar {
            background-color: #000000;
            width: 0%;
            height: 20px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            left: 50%;
            color: #ffffff;
        }

    </style>
</head>

<body>
    @include('navbar')

    <div class="row mx-0">
        <div class="col-12 col-md-8 col-xl-6 mx-auto p-3 text-center">
            <!-- Formulario para subida de vídeos -->
            <form class="border rounded p-3  bg-light" action="{{ url('upload') }}" name="uploadForm"
                method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Título del formulario -->
                <h3 class="h3">Subir vídeo</h3>

                <!-- Entrada de archivo -->
                <div class="custom-file my-2" id="archivo">
                    <input type="file" class="form-control pb-5 pt-3" name="archivo" required accept="video/*">
                </div>

                <!-- Separador -->
                <div class="w-100 mt-5" id="separador">
                    <hr>
                </div>

                <!-- Barra de progreso -->
                <div class="progress mt-4">
                    <div class="bar"></div>
                    <div class="percent">0%</div>
                </div>

                <!-- Texto que indica que se está procesando -->
                <div id="textoProcesando" class="bg-dark text-white rounded mt-4 text-center py-2 font-weight-bold">
                    <div class="spinner-grow" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <p class="my-auto">
                    Procesando vídeo, por favor espera.
                  </p>
                </div>

                <!-- Título -->
                <div class="form-group mt-4">
                    <label for="titulo" class="text-left w-100">Título</label>
                    <input class="form-control" name="titulo" placeholder="Elige un título para tu vídeo" required maxlength="50" id="titulo">
                </div>

                <!-- Descripción -->
                <div class="form-group mt-4">
                    <label for="descripcion" class="text-left w-100">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3" placeholder="Describe tu vídeo" id="descripcion"></textarea>
                </div>

                <!-- Etiquetas -->
                <div class="form-group mt-4">
                    <label for="tags" class="text-left w-100">Etiquetas (separadas por coma)</label>
                    <input class="form-control" type="text" name="etiquetas" placeholder="etiqueta1, etiqueta2" maxlength="200" id="etiquetas">
                </div>

                <!-- Botón subir -->
                <button type="submit" class="btn btn-dark mt-2" name="botonUpload" id="botonUpload"><i class="fas fa-upload"></i>
                    Subir</button>
            </form>
        </div>
    </div>

    @include('footer')
    <script type="text/javascript">
        var SITEURL = "{{ URL('/') }}";
        $(function() {
            $(document).ready(function() {
                //Variables
                var bar = $('.bar');
                var percent = $('.percent');
                var textoProcesando = $('#textoProcesando');
                var progress = $('.progress');

                var titulo = $('#titulo');
                var descripcion = $('#descripcion');
                var etiquetas = $('#etiquetas');
                var botonUpload = $('#botonUpload');
                var separador = $('#separador');
                var archivo = $('#archivo');

                progress.hide();
                textoProcesando.hide();
                $('form').ajaxForm({
                    beforeSend: function() {
                        progress.show();
                        var percentVal = '0%';
                        bar.width(percentVal)
                        percent.html(percentVal);

                        //Inhabilita los elementos del formulario
                        titulo.attr('readonly', true);
                        descripcion.attr('readonly', true);
                        etiquetas.attr('readonly', true);
                        separador.hide();
                        archivo.hide();

                        botonUpload.attr('disabled');
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal)
                        percent.html(percentVal);

                        if (percentComplete == 100) {
                            progress.hide();
                            textoProcesando.show();
                        }
                    },
                    complete: function(xhr) {
                        if (xhr.responseJSON.success) {
                            window.location.href = SITEURL + "/video/" + xhr.responseJSON.success;
                        } else {
                            alert('Parece que ha ocurrido algún error, comprueba los datos.')
                        }

                        console.log('TERMINADO');
                        console.log(xhr);
                        console.log('--------------');
                        console.log(xhr.responseJSON.success);
                    }
                });
            });
        });
    </script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="fonts/all.js"></script>

</body>

</html>
