<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Subir - YT-copia</title>

        @include('estilos')
    </head>
    <body>
        @include('navbar')

        <div class="row mx-0">
            <div class="col-12 col-md-6 col-lg-4 mx-auto p-3 text-center">
                <form class="border rounded p-3" action="uploadFile" name="uploadForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="archivo">
                        <label class="custom-file-label">Seleccionar Archivo</label>
                      </div>
                      <button type="submit" class="btn btn-dark mt-2" name="botonUpload"><i class="fas fa-upload"></i> Subir</button>
                </form>
            </div>
        </div>

        @include('scripts')
    </body>
</html>
