<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        Administración de usuarios - YT-copia
    </title>

    @include('estilos')
</head>

<body>
    @include('navbar')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Mensaje</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        if (isset($contactos)) {
                            foreach ($contactos as $contacto) {
                                ?>
                                <tr>
                                    <th scope="row">{{$contacto->name}}</th>
                                    <td>{{$contacto->email}}</td>
                                    <td>{{$contacto->created_at->format('d-m-Y H:m:s')}}</td>
                                    <td><p class="formateado bg-light p-1">{{$contacto->message}}</p></td>
                                  </tr>
                                <?php
                            }
                        } else {
                            echo '¿No hay contactos?';
                        }
                      ?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>

    @include('footer')
    @include('scripts')

</body>

</html>
